<?php

declare(strict_types=1);

namespace ParcelTrap\Skeleton\Tests;

use ParcelTrap\ParcelTrapServiceProvider;
use ParcelTrap\Skeleton\SkeletonServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app): array
    {
        return [ParcelTrapServiceProvider::class, SkeletonServiceProvider::class];
    }
}
