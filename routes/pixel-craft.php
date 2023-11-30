<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Leeto\PixelCraft\Enums\Methods;
use Leeto\PixelCraft\Http\Controllers\ImageGeneratorController;

$path = parse_url(
    Storage::disk(config('pixel-craft.disk', 'public'))
        ->url('/'),
    PHP_URL_PATH
);

Route::get($path . '{dir}/{method}/{size}/{file}', ImageGeneratorController::class)
    ->where('method', collect(Methods::cases())->implode('value', '|'))
    ->where('size', '\d+x\d+')
    ->where('file', '.+\.(png|jpg|gif|bmp|jpeg)$')
    ->name('pixel-craft.generator');
