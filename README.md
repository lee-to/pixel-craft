### PixelCraft

Image generator via router in Laravel

### Installation

```shell
composer require lee-to/pixel-craft
```

```shell
php artisan vendor:publish --provider="Leeto\PixelCraft\PixelCraftServiceProvider"
```
### Usage

#### 1. Set disk and available sized in config

#### 2. Add trait HasGeneratedImage to Model

```php
<?php

namespace App\Models;

use Leeto\PixelCraft\Traits\HasGeneratedImage;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasGeneratedImage;

    // ..

    protected function imageDir(): string
    {
        return 'articles';
    }

    protected function imageColumn(): string
    {
        return 'thumbnail';
    }

    // ..
}
```

#### 3. Get image

```php
$model->makeImage('200x200')
```

```php
$model->makeImages('200x200')
```

```php
$model->makeImage('200x200', 'fit')
```
