<?php

use Illuminate\Support\Facades\File;

it('can create section with no params', function () {
    [$code, $output] = run(
        config('harbor_crane.commands.make-section.signature'),
        [
            'name' => $this->sectionName,
            '--config' => $this->configPath,
        ]
    );

    expect($code)
        ->toBe(0)
        ->and($output)
        ->toBe(sprintf('Section [%s] has been created successfully.', $this->sectionName))
        ->and(File::isDirectory($this->containersPath.'/'.$this->sectionName))
        ->toBeTrue()
    ;
});

it('can create section with containers', function () {
    [$code, $output] = run(
        config('harbor_crane.commands.make-section.signature'),
        [
            'name' => $this->sectionName,
            '--config' => $this->configPath,
            '--container-name' => [
                'User',
                'Profile',
                'Admin',
            ],
        ]
    );

    expect($code)
        ->toBe(0)
        ->and($output)
        ->toBe(sprintf('Section [%s] has been created successfully.', $this->sectionName))
        ->and(File::isDirectory($this->containersPath.'/'.$this->sectionName))
        ->toBeTrue()
        ->and(File::isDirectory($this->containersPath.'/'.$this->sectionName.'/User'))
        ->toBeTrue()
        ->and(File::isDirectory($this->containersPath.'/'.$this->sectionName.'/Profile'))
        ->toBeTrue()
        ->and(File::isDirectory($this->containersPath.'/'.$this->sectionName.'/Admin'))
        ->toBeTrue()
    ;
});

it('cannot create section that already exists', function () {
    $run = fn () => run(
        config('harbor_crane.commands.make-section.signature'),
        [
            'name' => $this->sectionName,
            '--config' => $this->configPath,
        ]
    );

    $run();

    expect(fn () => $run())
        ->toThrow(sprintf('%s [%s] already exists.', 'Section', $this->sectionName))
    ;
});

it('cannot create section in the corrupted environment', function () {
    // emulate corrupted environment
    removeStructure($this->shipPath, $this->containersPath);

    expect(fn () => run(
        config('harbor_crane.commands.make-section.signature'),
        [
            'name' => $this->sectionName,
            '--config' => $this->configPath,
        ]
    ))
        ->toThrow(sprintf('%s [%s] could not be created.', 'Section', $this->sectionName))
    ;
});
