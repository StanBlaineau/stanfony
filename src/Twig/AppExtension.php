<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

//https://symfony.com/doc/current/templating/twig_extension.html
class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('strToImg', [$this, 'strToImg']),
        ];
    }

    public function strToImg(string $imagePath, string $alt=''): string
    {
       return '<img src="'.$imagePath.'" alt="'.$alt.'"/>';
    }
}
