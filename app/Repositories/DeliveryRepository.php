<?php 
    namespace App\Repositories;

    use App\Models\Delivery;
    use App\Repositories\Interfaces\DeliveryRepositoryInterface;

    class DeliveryRepository implements DeliveryRepositoryInterface {
        protected $model;

        public function __construct(Delivery $delivery) {
            $this->model = $delivery;
        }
        
        public function findByUserId(int $userId) {
            return $this->model->where('user_id', $userId)->first();
        }

        public function getAllByUser(int $userId) {
            return $this->model->with('user')
                ->forUser($userId)  // スコープを使用
                ->latest()
                ->get();
        }
    }

?>