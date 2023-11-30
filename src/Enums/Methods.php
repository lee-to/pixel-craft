<?php

declare(strict_types=1);

namespace Leeto\PixelCraft\Enums;

enum Methods: string
{
    case CROP = 'crop';

    case RESIZE = 'resize';

    case FIT = 'fit';
}
