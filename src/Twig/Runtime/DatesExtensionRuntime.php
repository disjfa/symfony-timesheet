<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class DatesExtensionRuntime implements RuntimeExtensionInterface
{
    public function asHours(int $seconds)
    {
        $hours = floor($seconds / 3600) + ($seconds % 3600 / 900 * .15);

        return number_format($hours, 2, ',');
    }
}
