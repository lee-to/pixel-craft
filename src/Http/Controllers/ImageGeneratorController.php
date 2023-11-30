<?php

declare(strict_types=1);

namespace Leeto\PixelCraft\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class ImageGeneratorController extends Controller
{
    public function __invoke(
        string $dir,
        string $method,
        string $size,
        string $file
    ): BinaryFileResponse {
        abort_if(
            ! in_array($size, config('pixel-craft.allowed_sizes', []), true),
            403,
            'Size not allowed'
        );

        $storage = Storage::disk(config('pixel-craft.disk', 'public'));

        $realPath = "$dir/$file";
        $newDirPath = "$dir/$method/$size";
        $resultPath = "$newDirPath/$file";

        if (!$storage->exists($newDirPath)) {
            $storage->makeDirectory($newDirPath);
        }

        if (!$storage->exists($resultPath)) {
            $image = Image::make($storage->path($realPath));
            [$w, $h] = explode('x', $size);

            $image->{$method}($w, $h);

            $image->save($storage->path($resultPath));
        }

        return response()->file($storage->path($resultPath));
    }
}
