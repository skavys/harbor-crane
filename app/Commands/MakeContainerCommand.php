<?php

namespace App\Commands;

use App\Actions\MakeContainer;
use Illuminate\Console\Concerns\InteractsWithIO;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class MakeContainerCommand
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 * @package App\Commands
 */
class MakeContainerCommand extends BaseCommand
{
    use InteractsWithIO;

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Generate new Container.';

    /**
     * Execute the console command.
     *
     * @param MakeContainer $makeContainer
     * @return int
     */
    public function handle(MakeContainer $makeContainer): int
    {
        $this->components->info(
            sprintf(
                'Container [%s] has been created successfully.',
                $makeContainer->execute($this->input)
            )
        );

        return 0;
    }

    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        parent::configure();

        /** @phpstan-ignore-next-line */
        $this->setName(config('harbor_crane.commands.make-container.signature'));

        $this
            ->addArgument(
                name: 'name',
                mode: InputArgument::REQUIRED,
                description: 'Container name'
            )
            ->addOption(
                name: 'section',
                mode: InputOption::VALUE_REQUIRED,
                description: 'Section name the container should be placed in'
            )
//            ->addOption(
//                name: 'model',
//                mode: InputOption::VALUE_REQUIRED,
//                description: 'Container\'s main model name'
//            )
//            ->addOption(
//                name: 'ui-full',
//                mode: InputOption::VALUE_NONE,
//                description: 'Generate Full UI (API, Web, CLI)'
//            )
//            ->addOption(
//                name: 'ui-api',
//                mode: InputOption::VALUE_NONE,
//                description: 'Generate API UI only'
//            )
//            ->addOption(
//                name: 'ui-web',
//                mode: InputOption::VALUE_NONE,
//                description: 'Generate Web UI only'
//            )
//            ->addOption(
//                name: 'ui-cli',
//                mode: InputOption::VALUE_NONE,
//                description: 'Generate CLI UI only'
//            )
        ;
    }
}
