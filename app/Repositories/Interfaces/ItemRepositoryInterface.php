<?php 
namespace App\Repositories\Interfaces;

use App\Models\Item;

interface ItemRepositoryInterface {
    // リポジトリで実装すべきメソッドを定義
    // itemsテーブルの登録処理
    public function create(array $data): Item;
    // 画像のアップロード処理
    public function saveImages(array $files, int $userId): array;
    // 商品名（あいまい検索）で検索
    public function searchByName(string $query);
    // ユーザーの他の出品物を取得
    public function getOtherItemsByUser(int $userId, int $currentItemId);
    // 指定されたユーザーIDと出品状態に基づいてアイテムを取得する
    public function getByUserIdAndStatus(int $userId, string $listStatus);
    // 関連商品を取得（最大4件）
    public function findRelatedItems(int $userId, int $itemId, int $limit = 4);
    // 出品状態を更新
    public function updateListStatus(Item $item, int $status): bool;
}

?>


