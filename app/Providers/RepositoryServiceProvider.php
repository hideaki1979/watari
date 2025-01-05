<?php
    namespace App\Providers;

    use Illuminate\Support\ServiceProvider;
    use App\Repositories\Interfaces\ItemRepositoryInterface;
    use App\Repositories\ItemRepository;
    use App\Repositories\Interfaces\DeliveryRepositoryInterface;
    use App\Repositories\DeliveryRepository;

    class RepositoryServiceProvider extends ServiceProvider {
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