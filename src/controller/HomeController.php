<?php

namespace App\controller;

use App\service\TwigService;

class HomeController
{
    public function __construct(
        private readonly TwigService $twigService
    ) {
        //contenu du constructeur
    }

    public function displayHome()
    {
        return $this->twigService->render('index.twig');
    }
}
