<?php

namespace App\Providers;

use App\Repositories\ConfigurationJsonRepository;
use App\Support\Harbor;
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
            $input = resolve(InputInterface::class);

            return new ConfigurationJsonRepository(
                $input->getOption('config') ?: Harbor::path().'/harbor-crane.json',
                $input->getOption('ship'),
                $input->getOption('containers'),
                $input->getOption('src-namespace')
            );
        });
    }
}
