<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\DatesExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class DatesExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('as_hours', [DatesExtensionRuntime::class, 'asHours']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('as_hours', [DatesExtensionRuntime::class, 'asHours']),
        ];
    }
}
