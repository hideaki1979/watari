<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ItemService;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ItemService $itemService)
    {
        //
        // ログイン中のユーザーIDを取得
        $userId = Auth::id();

        // 出品中と売却済のデータを取得
        $availableItems = $itemService->getItemsByStatus($userId, '0'); // 出品中
        $soldItems = $itemService->getItemsByStatus($userId, '1');     // 売却済

        // ビューにデータを渡す
        return view('items.index', [
            'availableItems' => $availableItems,
            'soldItems' => $soldItems
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // バリデーション
        $validated = $request->validate([
            'category' => 'required|string|max:2',
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:1',
            'expiry_date' => 'required|date',
            'image_1' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'image_2' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'image_3' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'image_4' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);
        // ログイン中のユーザーIDを取得
        $userId = Auth::id();

        // 画像ファイルを保存し、パスを取得
        $imagePaths = [];
        for ($i = 1; $i <= 4; $i++) {
            $imageField = "image_{$i}";
            if ($request->hasFile($imageField)) {
                // フォルダパスを作成
                $folderPath = "images/{$userId}";
                Storage::disk('public')->makeDirectory($folderPath);

                // ファイル名を生成して保存
                $fileName = $request->file($imageField)->getClientOriginalName();
                $path = $request->file($imageField)->storeAs($folderPath, $fileName, 'public');
                // $imagePaths[$imageField] = Storage::url($path); // パブリックURLを取得
                $imagePaths[$imageField] = "storage/{$path}";
                // $imagePaths[$imageField] = asset('storage/' . $path);   // asset関数を使用してURLを生成
            } else {
                $imagePaths[$imageField] = null;
            }
        }

        // データベースに保存
        $item = new Item();
        $item->user_id = $userId;
        $item->category = $validated['category'];
        $item->item_name = $validated['item_name'];
        $item->description = $validated['description'];
        $item->price = $validated['price'];
        $item->expiry_date = $validated['expiry_date'];
        $item->list_status = '0'; // 出品中の状態をデフォルトに設定
        $item->image_1 = $imagePaths['image_1'];
        $item->image_2 = $imagePaths['image_2'];
        $item->image_3 = $imagePaths['image_3'];
        $item->image_4 = $imagePaths['image_4'];
        $item->save();

        // 成功時のリダイレクト
        return redirect()->route('items.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        $relatedItems = Item::where('user_id', $item->user_id)
            ->where('id', '!=', $item->id)
            ->where('list_status', 0)  // 販売中の商品のみ
            ->latest()  // 最新の商品から
            ->take(4)   // 4件まで
            ->get();
        // 配送先住所の取得
        $delivery = Delivery::where('user_id', $item->user_id)->first();

        // viewに両方のデータを渡す
        return view('items.show', compact('item', 'relatedItems', 'delivery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
    }


    public function main(ItemService $itemService)
    {
        // 必要に応じてデータを取得（例: おすすめアイテムなど）
        // $recommendedItems = $itemService->getRecommendedItems(); // 推奨アイテム取得の例

        // メインページのビューにデータを渡す
        // return view('items.main', [
        //     'recommendedItems' => $recommendedItems,
        // ]);

        return view('items.main');
    }

    public function showSeasonings()
    {
        // 必要ならデータをデータベースから取得し、ビューに渡す
        return view('items.seasonings');
    }

    public function showFoods()
    {
        // 必要であればデータベースから食品データを取得し、ビューに渡します。
        return view('items.foods');
    }

    public function showMap()
    {
        // 必要であれば、ここでデータを取得しビューに渡すことも可能です。
        return view('items.map');
    }

    // public function fetchLocations(Request $request)
    // {
    //     $query = $request->query('query');
    //     $items = Item::where('item_name', 'like', "%$query%")->get();

    //     $locations = [];
    //     foreach ($items as $item) {
    //         $delivery = Delivery::where('user_id', $item->user_id)->first();
    //         if ($delivery) {
    //             $locations[] = [
    //                 'item_name' => $item->item_name,
    //                 'address' => $delivery->address,
    //                 'latitude' => $delivery->latitude,
    //                 'longitude' => $delivery->longitude
    //             ];
    //         }
    //     }

    //     return response()->json($locations);
    // }


    public function fetchLocations(Request $request)
    {
        $query = $request->query('query');
        $items = Item::with('user') // userリレーションを事前ロード
                    ->where('item_name', 'like', "%$query%")
                    ->get();
    
        $locations = [];
        foreach ($items as $item) {
            $delivery = Delivery::where('user_id', $item->user_id)->first(); // 配送情報を取得
    
            if ($delivery) {
                // ユーザーの他の出品物を取得
                $otherItems = Item::where('user_id', $item->user_id)
                                ->where('id', '!=', $item->id) // 現在のアイテム以外
                                ->get(['id', 'item_name', 'image_1']); // IDも含めて取得
    
                // 必要な情報を配列に格納
                $locations[] = [
                    'item_id' => $item->id, // 現在のアイテムのID
                    'user_name' => $item->user->name, // ユーザー名
                    'item_name' => $item->item_name, // 現在のアイテム名
                    'image_1' => $item->image_1, // 現在のアイテムの画像
                    'address' => $delivery->address, // 配送住所
                    'latitude' => $delivery->latitude, // 緯度
                    'longitude' => $delivery->longitude, // 経度
                    'items' => $otherItems->toArray(), // 他の出品物
                ];
            }
        }
    
        return response()->json($locations); // JSON形式でレスポンスを返す
    }
    













    // public function fetchLocations(Request $request)
    // {
    //     $query = $request->query('query');
    //     $items = Item::with('user') // userリレーションを事前ロード
    //         ->where('item_name', 'like', "%$query%")
    //         ->get();

    //     $locations = [];
    //     foreach ($items as $item) {
    //         $delivery = Delivery::where('user_id', $item->user_id)->first(); // 配送情報を取得

    //         if ($delivery) {
    //             // ユーザーの他の出品物を取得
    //             $otherItems = Item::where('user_id', $item->user_id)
    //                 ->where('id', '!=', $item->id) // 現在のアイテム以外
    //                 ->get(['item_name', 'image_1']);

    //             // 必要な情報を配列に格納
    //             $locations[] = [
    //                 'user_name' => $item->user->name, // ユーザー名
    //                 'item_name' => $item->item_name, // 現在のアイテム名
    //                 'image_1' => $item->image_1, // 現在のアイテムの画像
    //                 'address' => $delivery->address, // 配送住所
    //                 'latitude' => $delivery->latitude, // 緯度
    //                 'longitude' => $delivery->longitude, // 経度
    //                 'items' => $otherItems->toArray(), // 他の出品物
    //             ];
    //         }
    //     }

    //     return response()->json($locations); // JSON形式でレスポンスを返す
    // }

    public function buy(Item $item)
    {
        // list_statusを1（売却済み）に更新
        $item->update([
            'list_status' => 1
        ]);

        // 購入完了ページへリダイレクト
        return view('items.buy', compact('item'));
    }
}
