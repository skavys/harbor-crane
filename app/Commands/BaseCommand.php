<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class BaseCommand
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 * @package App\Commands
 */
abstract class BaseCommand extends Command
{
    /**
     * The configuration of the command.
     *
     * @return void
     */
    protected function configure(): void
    {
        parent::configure();

        $this
            ->addOption(
                name: 'config',
                mode: InputOption::VALUE_REQUIRED,
                description: 'Harbor Crane configuration file'
            )
            ->addOption(
                name: 'ship',
                mode: InputOption::VALUE_REQUIRED,
                description: 'Path to Ship [default: "src/Ship"]'
            )
            ->addOption(
                name: 'containers',
                mode: InputOption::VALUE_REQUIRED,
                description: 'Path to Containers [default: "src/Containers"]'
            )
            ->addOption(
                name: 'src-namespace',
                mode: InputOption::VALUE_REQUIRED,
                description: 'Application root namespace [default: "App"]'
            )
        ;
    }
}
