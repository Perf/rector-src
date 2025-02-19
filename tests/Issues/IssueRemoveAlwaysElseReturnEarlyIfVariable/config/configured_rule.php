<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector;
use Rector\EarlyReturn\Rector\StmtsAwareInterface\ReturnEarlyIfVariableRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rules([RemoveAlwaysElseRector::class, ReturnEarlyIfVariableRector::class]);
};
