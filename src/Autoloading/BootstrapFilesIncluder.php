<?php

declare(strict_types=1);

namespace Rector\Autoloading;

use FilesystemIterator;
use Phar;
use Rector\Configuration\Option;
use Rector\Configuration\Parameter\SimpleParameterProvider;
use Rector\Exception\ShouldNotHappenException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use Webmozart\Assert\Assert;

/**
 * @see \Rector\Tests\Autoloading\BootstrapFilesIncluderTest
 */
final class BootstrapFilesIncluder
{
    /**
     * Inspired by
     * @see https://github.com/phpstan/phpstan-src/commit/aad1bf888ab7b5808898ee5fe2228bb8bb4e4cf1
     */
    public function includeBootstrapFiles(): void
    {
        $bootstrapFiles = SimpleParameterProvider::provideArrayParameter(Option::BOOTSTRAP_FILES);

        Assert::allString($bootstrapFiles);

        $isLoadPHPUnitPhar = false;

        /** @var string[] $bootstrapFiles */
        foreach ($bootstrapFiles as $bootstrapFile) {
            if (! is_file($bootstrapFile)) {
                throw new ShouldNotHappenException(sprintf('Bootstrap file "%s" does not exist.', $bootstrapFile));
            }

            // load phar file
            if (str_ends_with($bootstrapFile, '.phar')) {
                Phar::loadPhar($bootstrapFile);

                if (str_ends_with($bootstrapFile, 'phpunit.phar')) {
                    $isLoadPHPUnitPhar = true;
                }

                continue;
            }

            require $bootstrapFile;
        }

        $this->requireRectorStubs($isLoadPHPUnitPhar);
    }

    private function requireRectorStubs(bool $isLoadPHPUnitPhar): void
    {
        /** @var false|string $stubsRectorDirectory */
        $stubsRectorDirectory = realpath(__DIR__ . '/../../stubs-rector');
        if ($stubsRectorDirectory === false) {
            return;
        }

        $dir = new RecursiveDirectoryIterator(
            $stubsRectorDirectory,
            RecursiveDirectoryIterator::SKIP_DOTS | FilesystemIterator::SKIP_DOTS
        );
        /** @var SplFileInfo[] $stubs */
        $stubs = new RecursiveIteratorIterator($dir);

        foreach ($stubs as $stub) {
            $realPath = $stub->getRealPath();

            if ($isLoadPHPUnitPhar && str_ends_with($realPath, 'TestCase.php')) {
                continue;
            }

            require_once $realPath;
        }
    }
}
