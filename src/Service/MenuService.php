<?php

namespace App\Service;

use App\Repository\PageRepository;

class MenuService
{
    private $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function getPageMenu(): array
    {
        return $this->pageRepository->findByActive(true, ['ordre' => 'asc']);
    }
}
