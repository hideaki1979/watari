<?php 
    namespace App\Repositories;

    use App\Models\Delivery;
    use App\Repositories\Interfaces\DeliveryRepositoryInterface;

    class DeliveryRepository implements DeliveryRepositoryInterface {
        protected $model;   // Deliveryモデルのインスタンスを保持する変数

        // コンストラクタ：クラスのインスタンス作成時に実行される
        public function __construct(Delivery $delivery) {
            $this->model = $delivery;   // Deliveryモデルのインスタンスを保存
        }
        
        public function findByUserId(int $userId) {
            return $this->model->where('user_id', $userId)->first();
        }

        public function getAllByUser(int $userId) {
            return $this->model->with('user')   // ユーザー情報を事前に読み込み（N+1問題の回避）
                ->forUser($userId)  // スコープを使用
                ->latest()          // 最新のレコードから順に取得
                ->get();            // クエリを実行して検索結果を取得
        }
    }

?>