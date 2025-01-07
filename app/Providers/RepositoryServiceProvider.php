<?php
    namespace App\Providers;

    use Illuminate\Support\ServiceProvider;
    use App\Repositories\Interfaces\ItemRepositoryInterface;
    use App\Repositories\ItemRepository;
    use App\Repositories\Interfaces\DeliveryRepositoryInterface;
    use App\Repositories\DeliveryRepository;

    class RepositoryServiceProvider extends ServiceProvider {
        // サービスコンテナへの登録処理
        // インターフェースとその実装クラスの紐付けを行う
        // これにより、インターフェースが要求された時に実装クラスが自動的に注入される
        public function register() {
            $this->app->bind(
                ItemRepositoryInterface::class,
                ItemRepository::class,
            );
            
            $this->app->bind(
                DeliveryRepositoryInterface::class,
                DeliveryRepository::class
            );
        }
    }
?>