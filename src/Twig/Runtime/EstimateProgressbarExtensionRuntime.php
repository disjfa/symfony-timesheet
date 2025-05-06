<?php

namespace App\Twig\Runtime;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\RuntimeExtensionInterface;

class EstimateProgressbarExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(private readonly Environment $twig)
    {
        // Inject dependencies if needed
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function generateEstimateProgress(int $estimate, int $spent): string
    {
        return $this->twig->render('extensions/estimate_progress.html.twig', [
            'estimate' => $estimate,
            'spent' => $spent,
            'bars' => $this->calculateBars($estimate, $spent),
        ]);
    }

    public function calculateBars(int $estimate, int $spent): array
    {
        $defaults = [
            'width' => 0,
            'class' => '',
            'label' => '',
        ];

        $bars = [];
        if (0 === $estimate) {
            $bars[] = [
                ...$defaults,
            ];

            return $bars;
        }

        if ($estimate > $spent) {
            $bars[] = [
                ...$defaults,
                'width' => number_format($spent / $estimate * 100, 2),
                'class' => 'bg-success',
            ];

            return $bars;
        }

        $calcEstimate = $estimate / $spent * 100;

        $bars[] = [
            ...$defaults,
            'width' => number_format($calcEstimate, 2),
            'class' => 'bg-success',
        ];
        $bars[] = [
            ...$defaults,
            'width' => number_format(100 - $calcEstimate, 2),
            'class' => 'bg-danger',
        ];

        return $bars;
    }
}
