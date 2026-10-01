<?php

namespace Chadvangaalen\Seat\Cavalry;

use Seat\Services\AbstractSeatPlugin;

class CavalryServiceProvider extends AbstractSeatPlugin
{
    public function boot(): void
    {
        $this->addRoutes();
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'cavalry');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'cavalry');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/cavalry.ships.php', 'cavalry.ships');
        $this->mergeConfigFrom(__DIR__ . '/Config/cavalry.sidebar.php', 'package.sidebar');
        $this->registerPermissions(__DIR__ . '/Config/cavalry.permissions.php', 'cavalry');
    }

    private function addRoutes(): void
    {
        if (! $this->app->routesAreCached()) {
            include __DIR__ . '/Http/routes.php';
        }
    }

    public function getName(): string
    {
        return 'SeAT Cavalry';
    }

    public function getPackageRepositoryUrl(): string
    {
        return 'https://github.com/chadvangaalen/seat-cavalry';
    }

    public function getPackagistPackageName(): string
    {
        return 'seat-cavalry';
    }

    public function getPackagistVendorName(): string
    {
        return 'chadvangaalen';
    }

    public function getDescription(): ?string
    {
        return 'At-a-glance corporation capital and black ops fleet status';
    }
}
