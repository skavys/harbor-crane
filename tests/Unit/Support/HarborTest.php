<?php

use App\Support\Harbor;

it('returns root application path', function () {
    expect(Harbor::path())->toBe(getcwd());
});
