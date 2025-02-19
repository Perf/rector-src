<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\DowngradePhp80\Rector\Expression\DowngradeMatchToSwitchRector;
use Rector\DowngradePhp81\Rector\StmtsAwareInterface\DowngradeSetAccessibleReflectionPropertyRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rules([
        DowngradeSetAccessibleReflectionPropertyRector::class,
        DowngradeMatchToSwitchRector::class,
    ]);
};
