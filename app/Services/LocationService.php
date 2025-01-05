<?php

namespace App\Services;

use App\Repositories\Interfaces\ItemRepositoryInterface;
use App\Repositories\Interfaces\DeliveryRepositoryInterface;

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

    public function getLocations(string $query) {
        $items = $this->itemRepository->searchByName($query);
        $locations = [];

        foreach($items as $item) {
            $delivery = $this->deliveryRepository
                        ->findByUserId($item->user_id); // 配送情報を取得
            if($delivery) {
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
}

?>