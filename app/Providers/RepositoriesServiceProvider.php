<?php

namespace App\Providers;

use App\Repositories\ConfigurationJsonRepository;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Class RepositoriesServiceProvider
 *
 * @package App\Providers
 */
class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(ConfigurationJsonRepository::class, function () {
            return new ConfigurationJsonRepository(resolve(InputInterface::class));
        });
    }
}
