<?php

namespace App\Actions;

use App\Repositories\ConfigurationJsonRepository;
use App\Traits\CreateDirectory;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Class MakeContainer
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 * @package App\Actions
 */
class MakeContainer
{
    use CreateDirectory;

    /**
     * @var array<int, string> Container's Skeleton
     */
    private static array $skeleton = [
        'Actions',
        'Collections',
        'Configs',
        'Data',
        'Data/Factories',
        'Data/Migrations',
        'Data/Seeders',
        'DTO',
        'Models',
        'Proxies',
        'UI',
        'UI/API',
        'UI/API/Controllers',
        'UI/API/Requests',
        'UI/API/Resources',
        'UI/API/Routes',
        'UI/WEB',
        'UI/WEB/Controllers',
        'UI/WEB/Requests',
        'UI/WEB/Resources',
        'UI/WEB/Routes',
        'UI/CLI',
        'UI/CLI/Commands',
    ];

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
     * Creates new Container
     *
     * @return string New Container name
     */
    public function execute(InputInterface $input = null): string
    {
        if ($input === null) {
            $input = $this->input;
        }

        /** @var string $name */
        $name = $input->getArgument('name');
        $section = $this->checkSection($input->getOption('section'));
        $path =
            $this->config->containersPath()
            .
            ($section === null ? '' : '/'.$section)
            .
            '/'.$name
        ;

        $this->makeDirectory($path, $name, 'Container');

        collect(self::$skeleton)->each(
            fn (string $name) => $this->makeDirectory($path.'/'.$name, $name) &&
                File::put($path.'/'.$name.'/.gitkeep', '') === 0
        );

        return $name;
    }

    /**
     * Checks if Section directory exists.
     *
     * If it doesn't exist, it will be created.
     * @param string|null $section
     * @return string|null Section name
     */
    private function checkSection(string $section = null): ?string
    {
        if ($section === null) {
            return null;
        }

        $sectionPath = $this->config->containersPath().'/'.$section;

        if (!File::isDirectory($sectionPath)) {
            $this->makeDirectory($sectionPath, $section, 'Section');
        }

        return $section;
    }
}
