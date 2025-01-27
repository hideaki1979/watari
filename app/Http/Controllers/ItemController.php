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
use App\Repositories\Interfaces\DeliveryRepositoryInterface;

class ItemController extends Controller
{
    // リポジトリのインスタンスを保持する変数
    private ItemRepositoryInterface $itemRepository;
    private DeliveryRepositoryInterface $deliveryRepository;
    // サービスのインスタンスを保持する変数
    protected $locationService;
    private $itemService;

    // 必要なサービスをコンストラクタで注入
    public function __construct(
        ItemRepositoryInterface $itemRepository,
        LocationService $locationService,
        ItemService $itemService,
        DeliveryRepositoryInterface $deliveryRepository
    ) {
        $this->itemRepository = $itemRepository;
        $this->locationService = $locationService;
        $this->itemService = $itemService;
        $this->deliveryRepository = $deliveryRepository;
    }

    /**
     * 一覧表示のメソッド
     */
    public function index()
    {
        //
        // ログイン中のユーザーIDを取得
        $userId = Auth::id();

        // 出品中（'0'）と売却済（'1'）のデータを取得
        $availableItems = $this->itemService->getItemsByStatus($userId, '0'); // 出品中
        $soldItems = $this->itemService->getItemsByStatus($userId, '1');     // 売却済

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
        $relatedItems = $this->itemRepository->findRelatedItems(
            $item->user_id,
            $item->id
        );
        // 配送先住所の取得
        $delivery = $this->deliveryRepository->findByUserId($item->user_id);

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
        $lat = $request->query('lat');
        $lng = $request->query('lng');

        // 必須パラメータのバリデーション
        if(!$lat || !$lng) {
            return response()->json([
                'error' => '経度・緯度は必須です。'
            ], 400);
        }

        try {
            $locations = $this->locationService->getLocations($request);

            return response()->json($locations); // JSON形式でレスポンスを返す
        } catch(\Exception $e) {
            return response()->json([
                'error' => 'データ取得に失敗しました。'
            ], 500);
        }
    }
}
