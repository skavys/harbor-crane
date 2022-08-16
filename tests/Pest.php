<?php

use App\Actions\MakeContainer;
use App\Commands\MakeContainerCommand;
use App\Commands\MakeSectionCommand;
use App\Support\Harbor;
use Illuminate\Foundation\Console\Kernel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

uses(Tests\TestCase::class)->in('Feature');
uses()
    ->beforeEach(function () {
        $this->path = Harbor::path().'/storage/tests';
        $this->shipPath = $this->path.'/Ship';
        $this->containersPath = $this->path.'/Containers';
        $this->sectionName = 'AccountSection';
        $this->containerName = 'User';
        $this->configPath = dirname(__DIR__).'/tests/Fixtures/config/tests.json';
        createStructure($this->shipPath, $this->containersPath);
    })
    ->afterEach(fn () => removeStructure($this->shipPath, $this->containersPath))
    ->in('Feature/Commands');

/**
 * Runs the given console command.
 *
 * @param string  $command Command name
 * @param array $arguments Command arguments and options
 * @return array [status-code, actual-message]
 */
function run(string $command, array $arguments): array
{
    $commandInstance = match ($command) {
        config('harbor_crane.commands.make-section.signature') => resolve(MakeSectionCommand::class),
        config('harbor_crane.commands.make-container.signature') => resolve(MakeContainerCommand::class),
    };

    $input = new ArrayInput($arguments, $commandInstance->getDefinition());
    $output = new BufferedOutput(OutputInterface::VERBOSITY_VERBOSE);

    app()->singleton(InputInterface::class, fn () => $input);
    app()->singleton(OutputInterface::class, fn () => $output);

    $statusCode = resolve(Kernel::class)->call($command, $arguments, $output);
    $output = Str::of($output->fetch())->replace('INFO', '')->trim()->toString();

    return [$statusCode, $output];
}

/**
 * Creates Porto structure for tests
 *
 * @param string $shipPath
 * @param string $containersPath
 * @return void
 */
function createStructure(string $shipPath, string $containersPath): void
{
    File::makeDirectory($shipPath);
    File::makeDirectory($containersPath);
}

/**
 * Removes Porto structure
 *
 * @param string $shipPath
 * @param string $containersPath
 * @return void
 */
function removeStructure(string $shipPath, string $containersPath): void
{
    File::isDirectory($shipPath) && File::deleteDirectory($shipPath);
    File::isDirectory($containersPath) && File::deleteDirectory($containersPath);
}

/**
 * @return array
 */
function containerSkeleton(): array
{
    return MakeContainer::skeleton();
}
