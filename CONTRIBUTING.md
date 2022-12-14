# Contributing

Contributions are **welcome** and will be fully **credited**.

We accept contributions via Pull Requests on [Github][1].

## Pull Requests

- **[PSR-12 Coding Standard][2]** - We use [Laravel Pint][3] with `psr12` preset to apply the conventions.

- **Analyse your code!** We use [PHPStan][5] with `level 9` to perform static analyse.

- **Add tests!** - Your patch won't be accepted if it doesn't have tests. We use [Pest][4] to write tests.

- **Document any change in behaviour** - Make sure the README and any other relevant documentation are kept up-to-date.

- **Consider our release cycle** - We try to follow SemVer. Randomly breaking public APIs is not an option.

- **Create topic branches** - Don't ask us to pull from your master branch.

- **One pull request per feature** - If you want to do more than one thing, send multiple pull requests.

- **Send coherent history** - Make sure each individual commit in your pull request is meaningful. 
If you had to make multiple intermediate commits while developing, please squash them before submitting.

- **Ensure jobs pass!** - Please run all jobs (see below) before submitting your pull request, 
and make sure they pass. We won't accept a patch until all jobs pass.

## Jobs

### Run all Jobs

``` bash
composer all
```

### Run Style check

``` bash
composer style
```

### Run Style fix

``` bash6
composer fix-style
```

### Run Static analyse

``` bash6
composer analyse
```

### Run Tests

``` bash6
composer tests-coverage
```

**Happy coding**!

[1]: https://github.com/skavys/harbor-crane/pulls
[2]: https://www.php-fig.org/psr/psr-12/
[3]: https://github.com/laravel/pint
[4]: https://pestphp.com/
[5]: https://phpstan.org/
