<?php

namespace App\Commands;

use App\Actions\MakeSection;
use Illuminate\Console\Concerns\InteractsWithIO;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class MakeSectionCommand
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 * @package App\Commands
 */
class MakeSectionCommand extends BaseCommand
{
    use InteractsWithIO;

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Generate new Containers Section.';

    /**
     * Execute the console command.
     *
     * @param MakeSection $makeSection
     * @return int
     */
    public function handle(MakeSection $makeSection): int
    {
        $this->components->info(
            sprintf(
                'Section [%s] has been created successfully.',
                $makeSection->execute($this->input)
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
        $this->setName(config('harbor_crane.commands.make-section.signature'));

        $this
            ->addArgument(
                name: 'name',
                mode: InputArgument::REQUIRED,
                description: 'Section name'
            )
            ->addOption(
                name: 'container-name',
                mode: InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL,
                description: 'Containers names inside a section'
            )
        ;
    }
}
