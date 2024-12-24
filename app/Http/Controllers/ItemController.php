<?php

namespace App\Http\Controllers;

use App\Models\Item;
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
                $imagePaths[$imageField] = Storage::url($path); // パブリックURLを取得
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
      return view('items.show', compact('item', 'relatedItems'));
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

