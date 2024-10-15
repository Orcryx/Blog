<?php
namespace App\controller;
use App\service\TwigService;

class HomeController
{

    //constructeur de la class 
    public function __construct(private readonly TwigService $twigService)
    {

    }

    public function displayHome()
    {
        return $this->twigService->render('index.twig');
    }
}