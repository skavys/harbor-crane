<?php

namespace App\Repositories;

use App\Support\Harbor;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Class ConfigurationJsonRepository
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 * @package App\Repositories
 */
class ConfigurationJsonRepository
{
    private readonly string $configPath;

    private readonly string|null $shipPath;

    private readonly string|null $containersPath;

    private readonly string|null $srcNamespace;

    /**
     * Creates a new Configuration Json Repository instance.
     *
     * @param InputInterface $input
     */
    public function __construct(private readonly InputInterface $input)
    {
        $this->configPath = $this->input->getOption('config') ?: Harbor::path().'/harbor-crane.json';
        $this->shipPath = $this->input->getOption('ship');
        $this->containersPath = $this->input->getOption('containers');
        $this->srcNamespace = $this->input->getOption('src-namespace');
    }

    /**
     * Gets Ship path option
     *
     * @return string
     */
    public function shipPath(): string
    {
        return Harbor::path().'/'.($this->shipPath ?: ($this->get()['ship'] ?? 'src/Ship'));
    }

    /**
     * Gets Containers path option
     *
     * @return string
     */
    public function containersPath(): string
    {
        return Harbor::path().'/'.($this->containersPath ?: ($this->get()['containers'] ?? 'src/Containers'));
    }

    /**
     * Gets application root namespace
     *
     * @return string
     */
    public function srcNamespace(): string
    {
        return $this->srcNamespace ?: ($this->get()['src-namespace'] ?? 'App\\');
    }

    /**
     * Gets the configuration from the "harbor-crane.json" file.
     *
     * @return array<string, array<int, string>|string>
     */
    private function get(): array
    {
        if (!File::isFile($this->configPath)) {
            return [];
        }

        return tap(json_decode((string)file_get_contents($this->configPath), true), function ($configuration) {
            if (!is_array($configuration)) {
                abort(1, sprintf('The configuration file [%s] is not valid JSON.', $this->configPath));
            }
        });
    }
}
