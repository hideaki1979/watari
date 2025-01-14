<?php
    namespace App\Repositories;

    use App\Models\Purchase;
    use App\Repositories\Interfaces\PurchaseRepositoryInterface;

    class PurchaseRepository implements PurchaseRepositoryInterface {
        private $model;   // Purchaseモデルのインスタンスを保持する変数

        public function __construct(Purchase $purchase) {
            $this->model = $purchase;
        }

        public function getAllPurchaseByUserId(int $userId) {
            return $this->model
                ->with('item')
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        public function create(array $data) {
            return $this->model->create($data);
        }
    }

?>
