<?php

declare(strict_types=1);

namespace Leeto\PixelCraft;

use Illuminate\Support\ServiceProvider;

final class PixelCraftServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/pixel-craft.php' => config_path('pixel-craft.php'),
        ]);

        $this->loadRoutesFrom(__DIR__.'/../routes/pixel-craft.php');
    }
}
