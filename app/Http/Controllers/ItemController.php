<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ItemService;
use App\Http\Requests\StoreItemRequest;
use App\Repositories\Interfaces\ItemRepositoryInterface;
use App\Services\LocationService;

class ItemController extends Controller
{
    private ItemRepositoryInterface $itemRepository;
    protected $locationService;

    public function __construct(
        ItemRepositoryInterface $itemRepository,
        LocationService $locationService
    ) {
        $this->itemRepository = $itemRepository;
        $this->locationService = $locationService;
    }

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
    public function store(StoreItemRequest $request)
    {
        // ログイン中のユーザーIDを取得
        $userId = Auth::id();
        // 画像ファイルを保存し、パスを取得
        $imagePaths = $this->itemRepository->saveImages($request->allFiles(), $userId);
        // バリデーションと登録情報を設定する。
        $itemData = array_merge(
            $request->validated(),
            [
                'user_id' => $userId,
                'list_status' => '0',
            ],
            $imagePaths
        );

        // データベースに保存
        $this->itemRepository->create($itemData);

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

    public function showMap(Request $request)
    {
        $query = $request->query('query');
        // 必要であれば、ここでデータを取得しビューに渡すことも可能です。
        return view('items.map', ['query' => $query]);
    }

    public function fetchLocations(Request $request)
    {
        $query = $request->query('query');
        $locations = $this->locationService->getLocations($query);

        return response()->json($locations); // JSON形式でレスポンスを返す
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
