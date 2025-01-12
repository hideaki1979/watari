<?php
    namespace App\Repositories\Interfaces;

    interface PurchaseRepositoryInterface {
        // ユーザIDの全ての購入履歴を取得
        public function getAllPurchaseByUserId(int $userId);
    }

?>