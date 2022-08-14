<?php

namespace App\Providers;

use App\Actions\MakeContainer;
use App\Actions\MakeSection;
use App\Commands\MakeContainerCommand;
use App\Commands\MakeSectionCommand;
use Illuminate\Support\ServiceProvider;

class CommandsServiceProvider extends ServiceProvider
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
        $this->app->bindMethod([MakeSectionCommand::class, 'handle'], function (MakeSectionCommand $command) {
            return $command->handle(
                resolve(MakeSection::class)
            );
        });

        $this->app->bindMethod([MakeContainerCommand::class, 'handle'], function (MakeContainerCommand $command) {
            return $command->handle(
                resolve(MakeContainer::class)
            );
        });
    }
}
