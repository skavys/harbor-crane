<?php

namespace App\Providers;

use App\Actions\MakeContainer;
use App\Actions\MakeSection;
use App\Repositories\ConfigurationJsonRepository;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Class ActionsServiceProvider
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 * @package App\Providers
 */
class ActionsServiceProvider extends ServiceProvider
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
        $this->app->singleton(MakeSection::class, function () {
            return new MakeSection(
                resolve(ConfigurationJsonRepository::class),
                resolve(InputInterface::class),
            );
        });

        $this->app->singleton(MakeContainer::class, function () {
            return new MakeContainer(
                resolve(ConfigurationJsonRepository::class),
                resolve(InputInterface::class),
            );
        });
    }
}
