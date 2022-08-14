<?php

it('can make Containers Section', function () {
    $this->artisan('make:section --help')->assertExitCode(0);
});
