<?php

namespace App\Services;

use App\Models\Item;

class ItemService
{
    /**
     * 指定されたユーザーIDと出品状態に基づいてアイテムを取得する
     *
     * @param int $userId
     * @param string $listStatus
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getItemsByStatus(int $userId, string $listStatus)
    {
        return Item::where('user_id', $userId)
                    ->where('list_status', $listStatus)
                    ->orderBy('created_at', 'desc')
                    ->get();
    }
}