<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\TypeDeclaration\Rector\ClassMethod\StrictArrayParamDimFetchRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(StrictArrayParamDimFetchRector::class);
};
