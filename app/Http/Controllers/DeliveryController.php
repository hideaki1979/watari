<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;
// Laravelで外部APIを呼び出す際に使用するHTTPクライアントを提供するファサード
use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;  

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $deliveries = Delivery::with('user')
          ->where('user_id', Auth::id())
          ->latest()
          ->get();
      
      // APIキーを追加
      $apiKey = env('API_KEY');

      // 両方のデータをviewに渡す
      return view('deliveries.index', compact('deliveries', 'apiKey'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      $deliveries = Delivery::where('user_id', Auth::id())->get();
      return view('deliveries.create', compact('deliveries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $validated = $request->validate([
        'address' => 'required|string|max:255',
      ]);
      try {
        //Geocoding APIへのリクエスト
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
          'address' => $validated['address'],
          'key' => env('API_KEY'),
          'language' => 'ja',
        ]);
         // APIレスポンスの確認と処理
        if ($response->successful() && $response['status'] === 'OK') {
          $location = $response['results'][0]['geometry']['location'];
          //dbへの保存
          Delivery::create([
            'address' => $validated['address'],
            'latitude' => $location['lat'],
            'longitude' => $location['lng'],
            'user_id' => Auth::id(), 
          ]);
          return redirect()->route('deliveries.index')
            ->with('success', '登録が完了しました');
        }

        return back()->withInput()
          ->withErrors(['address' => 'アドレスから位置情報を取得できませんでした']);

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
