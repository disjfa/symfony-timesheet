<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('estimate_progress')]
class EstimateProgress
{
    public int $estimate;
    public int $spent;

    public function getBars(): array
    {
        $defaults = [
            'width' => 0,
            'class' => '',
            'label' => '',
        ];

        $bars = [];
        if (0 === $this->estimate) {
            $bars[] = [
                ...$defaults,
            ];

            return $bars;
        }

        if ($this->estimate > $this->spent) {
            $bars[] = [
                ...$defaults,
                'width' => number_format($this->spent / $this->estimate * 100, 2),
                'class' => 'bg-success',
            ];

            return $bars;
        }

        $calcEstimate = $this->estimate / $this->spent * 100;

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
