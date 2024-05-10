<?php

declare(strict_types=1);

use Symplify\MonorepoBuilder\Config\MBConfig;

return static function (MBConfig $mbConfig): void {
    // Component location
    $mbConfig->packageDirectories([__DIR__ . '/components']);

    // This has to be relative to the directory above
    $mbConfig->packageDirectoriesExcludes(['_template']);
};
