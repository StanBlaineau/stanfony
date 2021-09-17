<?php

namespace App\Service;

class ChookieService
{
    private $chuckService;

    public function __construct(ChuckService $chuckService)
    {
        $this->chuckService = $chuckService;
    }

    public function getChookieLabel($category = 'food')
    {
        $result = $this->chuckService->getCategory($category);
        $label  = 'J\'accepte les cookies';

        if (!$result['error']) {
            $label = $result['content']->value;
        }

        return $label;
    }
}