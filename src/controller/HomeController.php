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
        echo $this->twigService->render('index.twig');
    }
}
