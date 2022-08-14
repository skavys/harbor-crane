<?php

namespace App\Support;

/**
 * Class Harbor
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 * @package App\Support
 */
class Harbor
{
    /**
     * Root application path where the package is installed.
     *
     * @return string
     */
    public static function path(): string
    {
        return (string)getcwd();
    }
}
