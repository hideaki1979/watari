<?php 
    namespace App\Services;

    // Laravelで外部APIを呼び出す際に使用するHTTPクライアントを提供するファサード
    use Illuminate\Support\Facades\Http;

    class GeocodingService {
        public function getLocation(string $address) {
            //Geocoding APIへのリクエスト
            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address' => $address,
                'key' => env('API_KEY'),
                'language' => 'ja',
            ]);
            // APIレスポンスの確認と処理
            if ($response->successful() && $response['status'] === 'OK') {
                return $response['results'][0]['geometry']['location'];
            }
        }
    }
?>