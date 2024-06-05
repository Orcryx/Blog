<?php

namespace App\controller;

use App\service\TwigService;

class PostController
{
private TwigService $twigService;

//constructeur de la class 
public function __construct()
{
    $this->twigService = new TwigService();
}


public function displayPost()
{ 
 
    return $this->twigService->twigEnvironnement->render('post.twig',['posts' => $posts]);
}
}