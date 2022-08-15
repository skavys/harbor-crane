<?php

use App\Repositories\ConfigurationJsonRepository;
use App\Support\Harbor;

it('returns default global options', function () {
    $config = 'harbor-crane.json';
    $rootPath = Harbor::path();
    $repository = new ConfigurationJsonRepository($config);

    expect($repository->shipPath())
        ->toBe($rootPath.'/src/Ship')
        ->and($repository->containersPath())
        ->toBe($rootPath.'/src/Containers')
        ->and($repository->srcNamespace())
        ->toBe('App\\')
    ;
});

it('returns values from command line', function () {
    $config = 'harbor-crane.json';
    $ship = 'app/Ship';
    $containers = 'app/Containers';
    $srcNamespace = 'Bay\\';
    $rootPath = Harbor::path().'/';
    $repository = new ConfigurationJsonRepository($config, $ship, $containers, $srcNamespace);

    expect($repository->shipPath())
        ->toBe($rootPath.$ship)
        ->and($repository->containersPath())
        ->toBe($rootPath.$containers)
        ->and($repository->srcNamespace())
        ->toBe($srcNamespace)
    ;
});

it('can read values from config file', function () {
    $config = dirname(__DIR__, 2).'/Fixtures/config/bay.json';
    $rootPath = Harbor::path();
    $repository = new ConfigurationJsonRepository($config);

    expect($repository->shipPath())
        ->toBe($rootPath.'/app/src/Ship')
        ->and($repository->containersPath())
        ->toBe($rootPath.'/app/src/Containers')
        ->and($repository->srcNamespace())
        ->toBe('App\Bay\\')
    ;
});

test('command line has highest priority', function () {
    $config = dirname(__DIR__, 2).'/Fixtures/config/bay.json';
    $ship = 'app/Ship';
    $containers = 'app/Containers';
    $srcNamespace = 'Bay\\';
    $rootPath = Harbor::path().'/';
    $repository = new ConfigurationJsonRepository($config, $ship, $containers, $srcNamespace);

    expect($repository->shipPath())
        ->toBe($rootPath.$ship)
        ->and($repository->containersPath())
        ->toBe($rootPath.$containers)
        ->and($repository->srcNamespace())
        ->toBe($srcNamespace)
    ;
});

it('can handle corrupted config file', function () {
    $config = dirname(__DIR__, 2).'/Fixtures/config/corrupted.json';
    $repository = new ConfigurationJsonRepository($config);

    expect(fn () => $repository->shipPath())
        ->toThrow(sprintf('The configuration file [%s] is not valid JSON.', $config))
    ;
});
