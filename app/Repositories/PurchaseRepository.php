<?php
    namespace App\Repositories;

    use App\Models\Purchase;
    use App\Repositories\Interfaces\PurchaseRepositoryInterface;

    class PurchaseRepository implements PurchaseRepositoryInterface {
        protected $model;   // Itemモデルのインスタンスを保持する変数

        public function __construct(Purchase $model) {
            $this->model = $model;
        }

        public function getAllPurchaseByUserId(int $userId) {
            return $this->model
                ->with('item')
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }

?>