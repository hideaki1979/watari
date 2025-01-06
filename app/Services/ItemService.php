<?php

namespace App\Services;

use App\Repositories\Interfaces\ItemRepositoryInterface;

class ItemService
{
    private $itemRepository;

    // Repositoryをコンストラクタで注入することで、テスト可能なコードにする
    public function __construct(ItemRepositoryInterface $itemRepository) {
        $this->itemRepository = $itemRepository;
    }
    /**
     * 指定されたユーザーIDと出品状態に基づいてアイテムを取得する
     *
     * @param int $userId
     * @param string $listStatus
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getItemsByStatus(int $userId, string $listStatus)
    {
        return $this->itemRepository->getByUserIdAndStatus($userId, $listStatus);
    }
}