<?php
    namespace App\Repositories\Interfaces;

    interface PurchaseRepositoryInterface {
        // ユーザIDの全ての購入履歴を取得
        public function getAllPurchaseByUserId(int $userId);

        // 購入履歴を作成
        public function create(array $data);
    }

?>
