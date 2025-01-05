<?php 
namespace App\Repositories\Interfaces;

use App\Models\Item;

interface ItemRepositoryInterface {
    public function create(array $data): Item;
    public function saveImages(array $files, int $userId): array;
    public function searchByName(string $query);
    public function getOtherItemsByUser(int $userId, int $currentItemId);
}

?>


