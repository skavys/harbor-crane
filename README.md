<p align="center">
    <a href="https://github.com/skavys/harbor-crane/actions/workflows/build.yml" target="_blank" title="build"><img src="https://github.com/skavys/harbor-crane/actions/workflows/build.yml/badge.svg?branch=master" alt="build"></a>
    <a href="https://packagist.org/packages/skavys/harbor-crane" target="_blank" title="download"><img src="https://img.shields.io/packagist/dt/skavys/harbor-crane?style=flat-square" alt="download"></a>
    <a href="https://github.com/skavys/harbor-crane/blob/stat/LICENSE" target="_blank" title="license"><img src="https://img.shields.io/github/license/skavys/harbor-crane?style=flat-square" alt="license"></a>
    <a href="https://github.com/skavys/harbor-crane/releases" target="_blank" title="release"><img src="https://img.shields.io/github/v/release/skavys/harbor-crane?display_name=tag&sort=semver&style=flat-square" alt="release"></a>
    <a href="https://packagist.org/packages/skavys/harbor-crane" target="_blank" title="php"><img src="https://img.shields.io/packagist/php-v/skavys/harbor-crane?style=flat-square" alt="php"></a>
</p>

# Harbor Generator commands

## Introduction

**Harbor Crane** is a tool to generate files and directories for [Porto][1] architecture pattern.

## Installation

You may install `Harbor Crane` via Composer:
```bash
composer require skavys/harbor-crane --dev
```

Alternatively, `Harbor Crane` has standalone version distributed as `PHAR` archive. You may download 
`phar` version in `Assets` section of each [release][7]. 

## Configuration

Each command has following _global_ options:
- `--config` - loads configuration from a `JSON` file;
- `--ship` - relative path to the `Ship` directory (default is `src/Ship`);
- `--containers` - relative path to the `Containers` directory (default is `src/Containers`);
- `--src-namespace` - Porto root namespace (default is `App`).

## Available Commands

Run `vendor/bin/harbor-crane` to see the list of available commands.

## Usage
Run following command to create `AccountSection` section:

```bash
./vendor/bin/harbor-crane make:section AccountSection
```

You can create section and containers inside this section in one step:

```bash
./vendor/bin/harbor-crane make:section AccountSection --container-name=User --container-name=Profile
```

Above command will create `AccountSection` section and two containers in it: `User` and `Profile`.

Run following command to create `Product` container:

```bash
./vendor/bin/harbor-crane make:container Product
```

Above command will create `Product` container in `containers` directory (`src/Containers` by default).

You can create section and container in it in one step:

```bash
./vendor/bin/harbor-crane make:container Product --section=ProductSection
```

Above command will create `ProductSection` section if it doesn't exist and create `Product` container in this section.

## Configuration file
If your global options differ from default ones and you don't want to provide them for each command run, you can
create `JSON` configuration file. By default, the name of configuration file is `harbor-crane.json` and 
it should be located in the root directory of your project:

```json
{
    "ship": "app/Ship",
    "containers": "app/Containers",
    "src-namespace": "App"
}
```

## Contributing
Thank you for considering contributing to Harbor Crane! You can read the contribution guide [here][2].

## Code of Conduct
Please review and abide by the [Code of Conduct][3].

## Credits

- [Dzianis Kotau][4]
- [All Contributors][5]

## License
Harbor Crane is open-sourced software licensed under the [MIT license][6].

[1]: https://github.com/Mahmoudz/Porto
[2]: CONTRIBUTING.md
[3]: CODE_OF_CONDUCT.md
[4]: https://github.com/Jampire
[5]: https://github.com/skavys/harbor-crane/graphs/contributors
[6]: LICENSE
[7]: https://github.com/skavys/harbor-crane/releases
