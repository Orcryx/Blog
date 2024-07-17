<?php
namespace App\controller;

use App\service\TwigService;
use App\service\UserService;



class ElementsController
{


    private TwigService $twigService;
    private UserService $userService;


    //constructeur de la class 
    public function __construct()
    {
        $this->twigService = new TwigService();
        $this->userService = new UserService();
    }

    public function showLoginDialogue(): void
    {

        echo $this->twigService->twigEnvironnement->render('formConnexion.twig',["session"=>$_SESSION]);

    }



}