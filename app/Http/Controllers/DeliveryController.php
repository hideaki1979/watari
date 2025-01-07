<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\DeliveryRepositoryInterface;
use App\Http\Requests\StoreDeliveryRequest;
use App\Services\GeocodingService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;  

class DeliveryController extends Controller
{
    protected $deliveryRepository;  // リポジトリのインスタンスを保持する変数
    protected $geocodingService;  // サービスのインスタンスを保持する変数

    // コンストラクタ：依存性の注入を受け取る
    public function __construct(
      DeliveryRepositoryInterface $deliveryRepository,
      GeocodingService $geocodingService
      ) {
      // 注入されたリポジトリのインスタンスを保存
      $this->deliveryRepository = $deliveryRepository;
      $this->geocodingService = $geocodingService;
    }

    /**
     * Display a listing of the resource.
     */
    // 配送一覧を表示するアクション
    public function index()
    {
      // リポジトリを使用して現在のユーザーの配送情報を取得
      $deliveries = $this->deliveryRepository->getAllByUser(Auth::id());
      
      // 環境変数からAPIキーを追加
      $apiKey = env('API_KEY');

      // 両方のデータをviewに渡す
      return view('deliveries.index', compact('deliveries', 'apiKey'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      $deliveries = $this->deliveryRepository->getAllByUser(Auth::id());
      return view('deliveries.create', compact('deliveries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeliveryRequest $request)
    {
      try {
        $validated = $request->validated();
        //Geocoding APIへのリクエスト
        $location = $this->geocodingService->getLocation($validated['address']);

        if(!$location) {
          return back()->withInput()
            ->withErrors(['address' => 'アドレスから位置情報を取得できませんでした']);
        }

        $this->deliveryRepository->createDelivery(
          $validated, $location, Auth::id()
        );
      
        return redirect()->route('deliveries.index')
          ->with('success', '登録が完了しました');
      } catch (\Exception $e) {
          Log::error('Geocoding error: ' . $e->getMessage());
          
          return back()->withInput()
            ->withErrors(['address' => '位置情報の処理中にエラーが発生しました']);
      }
    }

    /**
     * Display the specified resource.
     */
    public function show(Delivery $delivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Delivery $delivery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Delivery $delivery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delivery $delivery)
    {
        //
    }
}
