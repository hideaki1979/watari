<?php 
namespace App\Repositories\Interfaces;

use App\Models\Item;

interface ItemRepositoryInterface {
    // メソッドの定義
    public function create(array $data): Item;
    public function saveImages(array $files, int $userId): array;
    public function searchByName(string $query);
    public function getOtherItemsByUser(int $userId, int $currentItemId);
    public function getByUserIdAndStatus(int $userId, string $listStatus);
    public function findRelatedItems(int $userId, int $itemId, int $limit = 4);
}

?>


