<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\EstimateProgressbarExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class EstimateProgressbarExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('estimate_progress', [EstimateProgressbarExtensionRuntime::class, 'generateEstimateProgress'], [
                'is_safe' => ['html'],
            ]),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('estimate_progress', [EstimateProgressbarExtensionRuntime::class, 'generateEstimateProgress']),
        ];
    }
}
