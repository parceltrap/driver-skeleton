<?php

declare(strict_types=1);

namespace ParcelTrap\Skeleton;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\ServiceProvider;
use ParcelTrap\Contracts\Factory;
use ParcelTrap\ParcelTrap;

class SkeletonServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        /** @var ParcelTrap $factory */
        $factory = $this->app->make(Factory::class);

        $factory->extend(Skeleton::IDENTIFIER, function () {
            /** @var Repository $config */
            $config = $this->app->make(Repository::class);

            return new Skeleton(
                /** @phpstan-ignore-next-line */
                apiKey: (string) $config->get('parceltrap.skeleton.api_key'),
            );
        });
    }
}
