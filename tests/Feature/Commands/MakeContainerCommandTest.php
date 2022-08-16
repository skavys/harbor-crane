<?php

use Illuminate\Support\Facades\File;

it('can create container with no params', function () {
    [$code, $output] = run(
        config('harbor_crane.commands.make-container.signature'),
        [
            'name' => $this->containerName,
            '--config' => $this->configPath,
        ]
    );

    expect($code)
        ->toBe(0)
        ->and($output)
        ->toBe(sprintf('Container [%s] has been created successfully.', $this->containerName))
        ->and(File::isDirectory($this->containersPath.'/'.$this->containerName))
        ->toBeTrue()
    ;
});

it('can create container and section', function () {
    [$code, $output] = run(
        config('harbor_crane.commands.make-container.signature'),
        [
            'name' => $this->containerName,
            '--section' => $this->sectionName,
            '--config' => $this->configPath,
        ]
    );

    expect($code)
        ->toBe(0)
        ->and($output)
        ->toBe(sprintf('Container [%s] has been created successfully.', $this->containerName))
        ->and(File::isDirectory($this->containersPath.'/'.$this->sectionName.'/'.$this->containerName))
        ->toBeTrue()
    ;
});

it('can create container inside existed section', function () {
    run(
        config('harbor_crane.commands.make-section.signature'),
        [
            'name' => $this->sectionName,
            '--config' => $this->configPath,
        ]
    );

    [$code, $output] = run(
        config('harbor_crane.commands.make-container.signature'),
        [
            'name' => $this->containerName,
            '--section' => $this->sectionName,
            '--config' => $this->configPath,
        ]
    );

    expect($code)
        ->toBe(0)
        ->and($output)
        ->toBe(sprintf('Container [%s] has been created successfully.', $this->containerName))
        ->and(File::isDirectory($this->containersPath.'/'.$this->sectionName.'/'.$this->containerName))
        ->toBeTrue()
    ;
});

it('cannot create container that already exists', function () {
    $run = fn () => run(
        config('harbor_crane.commands.make-container.signature'),
        [
            'name' => $this->containerName,
            '--config' => $this->configPath,
        ]
    );

    $run();

    expect(fn () => $run())
        ->toThrow(sprintf('%s [%s] already exists.', 'Container', $this->containerName))
    ;
});

it('cannot create container in the corrupted environment', function () {
    // emulate corrupted environment
    removeStructure($this->shipPath, $this->containersPath);

    expect(fn () => run(
        config('harbor_crane.commands.make-container.signature'),
        [
            'name' => $this->containerName,
            '--config' => $this->configPath,
        ]
    ))
        ->toThrow(sprintf('%s [%s] could not be created.', 'Container', $this->containerName))
    ;
});

it('can create correct container structure', function () {
    run(
        config('harbor_crane.commands.make-container.signature'),
        [
            'name' => $this->containerName,
            '--config' => $this->configPath,
        ]
    );

    $path = $this->containersPath.'/'.$this->containerName;
    collect(containerSkeleton())
        ->each(fn (string $name) => expect(File::isDirectory($path.'/'.$name))->toBeTrue())
    ;
});
