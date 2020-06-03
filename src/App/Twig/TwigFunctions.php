<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class MyTwigExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [new TwigFunction('seatsLeftColor', array($this, 'seatsLeftColor'))];
    }

    public function seatsLeftColor($number, $max)
    {
        $percentage = 100 * $number / $max;
        if ($percentage == 100)
            return "red-seat";
        if ($percentage > 80 || ($max - $number < 3))
            return "orange-seat";
        return "green-seat";
    }
}