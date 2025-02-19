<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Tests\Issues\ScopeNotAvailable\Variable\ArrayItemForeachValueRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(ArrayItemForeachValueRector::class);
};
