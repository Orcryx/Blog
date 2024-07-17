<?php
namespace App\controller;

use App\service\TwigService;
use App\service\UserService;

class ElementsController
{
    private UserService $userService;
    
    //constructeur de la class 
    public function __construct(private readonly TwigService $twigService)
    {

        $this->userService = new UserService();
    }

    public function showLoginDialogue(string $previous_url)
    {
        $environnement = $this->userService->getEnvironnement($_SESSION['previous_url']);
        echo $this->twigService->render('formConnexion.twig',["origin"=>$environnement]);
    }
}