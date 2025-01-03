<?php
    namespace App\Providers;

    use Illuminate\Support\ServiceProvider;
    use App\Repositories\Interfaces\ItemRepositoryInterface;
    use App\Repositories\ItemRepository;

    class RepositoryServiceProvider extends ServiceProvider {
        public function register() {
            $this->app->bind(
                ItemRepositoryInterface::class,
                ItemRepository::class,
            );
        }
    }
?>