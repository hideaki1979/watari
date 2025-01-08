<?php

namespace App\Services;

use App\Repositories\Interfaces\ItemRepositoryInterface;
use App\Repositories\Interfaces\DeliveryRepositoryInterface;
use Illuminate\Http\Request;

class LocationService {
    protected $itemRepository;
    protected $deliveryRepository;

    public function __construct(
        ItemRepositoryInterface $itemRepository,
        DeliveryRepositoryInterface $deliveryRepository
    ) {
        $this->itemRepository = $itemRepository;
        $this->deliveryRepository = $deliveryRepository;
    }

    public function getLocations(Request $request) {
        $query = $request->query('query');
        $distance = (int)$request->query('distance', 100);
        $centerLat = (float)$request->query('lat');
        $centerLng = (float)$request->query('lng');

        $items = $this->itemRepository->searchByName($query);
        $locations = [];

        foreach($items as $item) {
            $delivery = $this->deliveryRepository
                        ->findByUserId($item->user_id); // 配送情報を取得
            if($delivery && $this->isWithinDistance(
                $centerLat, $centerLng, $delivery->latitude, $delivery->longitude, $distance
            )) {
                $otherItems = $this->itemRepository->getOtherItemsByUser($item->user_id, $item->id);
                // 必要な情報を配列に格納
                $locations[] = [
                    'item_id' => $item->id,                 // 現在のアイテムのID
                    'user_name' => $item->user->name,       // ユーザー名
                    'item_name' => $item->item_name,        // 現在のアイテム名
                    'image_1' => $item->image_1,            // 現在のアイテムの画像
                    'address' => $delivery-> address,       // 配送住所
                    'latitude' => $delivery->latitude,      // 緯度
                    'longitude' => $delivery->longitude,    // 経度  
                    'items' => $otherItems->toArray(),      // 他の出品物
                ];
            }
        }
        return $locations;
    }

    private function isWithinDistance($lat1, $lng1, $lat2, $lng2, $maxDistance) {
        $earthRadius = 6371000;  // 地球の半径（m）

        $lat1 = deg2rad($lat1);
        $lng1 = deg2rad($lng1);
        $lat2 = deg2rad($lat2);
        $lng2 = deg2rad($lng2);

        $dlat = $lat2 - $lat1;
        $dlng = $lng2 - $lng1;

        $a = sin($dlat/2) * sin($dlat/2) +
             cos($lat1) * cos($lat2) *
             sin($dlng/2) * sin($dlng/2);
             
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $earthRadius * $c;

        return $distance <= $maxDistance;
    }
}

?>