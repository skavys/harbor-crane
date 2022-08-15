<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;

/**
 * Trait CreateDirectory
 *
 * @author Dzianis Kotau <me@dzianiskotau.com>
 * @package App\Traits
 */
trait CreateDirectory
{
    /**
     * @param string $path Directory path
     * @param string $name Directory name
     * @param string|null $entity Message entity name
     * @return bool True if directory has been created, exception otherwise
     */
    public function makeDirectory(string $path, string $name, string $entity = null): bool
    {
        if ($entity === null) {
            $entity = 'Directory';
        }

        if (File::isDirectory($path)) {
            abort(1, sprintf('%s [%s] already exists.', $entity, $name));
        }

        try {
            if (File::makeDirectory($path) === false) {
                abort(1, sprintf('%s [%s] could not be created.', $entity, $name));
            }
        } catch (\Exception $exception) {
            abort(1, sprintf('%s [%s] could not be created.', $entity, $name));
        }

        return true;
    }
}
