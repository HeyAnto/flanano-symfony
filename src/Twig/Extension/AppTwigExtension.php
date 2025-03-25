<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\AppTwigExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppTwigExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('formatPrice', [AppTwigExtensionRuntime::class, 'formatPrice']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getCategories', [AppTwigExtensionRuntime::class, 'getCategories']),
        ];
    }
}
