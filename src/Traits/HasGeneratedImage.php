<?php

declare(strict_types=1);

namespace Leeto\PixelCraft\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Leeto\PixelCraft\Enums\Methods;

trait HasGeneratedImage
{
    abstract protected function imageColumn(): string;

    public function makeImage(string $size, string|Methods $method = Methods::RESIZE): string
    {
        if(is_string($method)) {
            $method = Methods::tryFrom($method) ?? Methods::RESIZE;
        }

        $value = $this->{$this->imageColumn()};

        if($this->multipleImages()) {
            $value = Arr::first($value);
        }

        return $this->imageUrl($value, $size, $method);
    }

    public function makeImages(string $size, string|Methods $method = Methods::RESIZE): Collection
    {
        if(is_string($method)) {
            $method = Methods::tryFrom($method) ?? Methods::RESIZE;
        }

        return $this->{$this->imageColumn()}
            ->map(fn($value) => $this->imageUrl($value, $size, $method));
    }

    private function imageUrl(?string $file, string $size, Methods $method = Methods::RESIZE): string
    {
        if(empty($file)) {
            return $this->imageTemplate($size);
        }

        return route('pixel-craft.generator', [
            'size' => $size,
            'dir' => $this->imageDir(),
            'method' => $method,
            'file' => File::basename($file)
        ]);
    }

    protected function imageTemplate(string $size): string
    {
        return "https://via.placeholder.com/$size";
    }

    protected function imageDir(): ?string
    {
        return 'images';
    }

    protected function multipleImages(): bool
    {
        return false;
    }
}
