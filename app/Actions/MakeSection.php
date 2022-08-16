<?php

namespace App\Actions;

use App\Repositories\ConfigurationJsonRepository;
use App\Traits\CreateDirectory;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Class MakeSection
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 * @package App\Actions
 */
class MakeSection
{
    use CreateDirectory;

    /**
     * @param ConfigurationJsonRepository $config
     * @param InputInterface $input
     */
    public function __construct(
        private readonly ConfigurationJsonRepository $config,
        private readonly InputInterface $input,
    ) {
        //
    }

    /**
     * Create new Containers Section
     *
     * @return string New Section name
     */
    public function execute(InputInterface $input = null): string
    {
        if ($input === null) {
            $input = $this->input; // @codeCoverageIgnore
        }

        /** @var string $name */
        $name = $input->getArgument('name');
        $path = $this->config->containersPath().'/'.$name;

        $this->makeDirectory($path, $name, 'Section');
        $this->makeContainers($name, $input);

        return $name;
    }

    /**
     * Calls container creation command
     *
     * @param string $sectionName
     * @param InputInterface $input
     * @return void
     */
    private function makeContainers(string $sectionName, InputInterface $input): void
    {
        collect($input->getOption('container-name'))
            ->each(fn (string $containerName) => Artisan::call(
                config('harbor_crane.commands.make-container.signature'),
                [
                    'name' => $containerName,
                    '--section' => $sectionName,
//                    '--ui-full' => true,
                ]
            ) === 0)
        ;
    }
}
