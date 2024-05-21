<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class MovieDecades
{
    public array $decades = [
        ['year' => 1970],
        ['year' => 1980],
        ['year' => 1990],
        ['year' => 2000],
    ];
}
