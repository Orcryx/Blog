<?php
namespace App\controller;
use App\service\TwigService;
// use App\model\repository;

class blog
{


    private TwigService $twigService;

    //constructeur de la class 
    public function __construct()
    {
        $this->twigService = new TwigService();
    }

    public function getGallery()
    {
        // Afficher le résultat de la requête
        // return $this->twigService->twigEnvironnement->render('gallery.twig',["posts"=>$post]);
        return $this->twigService->twigEnvironnement->render('gallery.twig');

    }

    public function getPost()
    { 
        return $this->twigService->twigEnvironnement->render('post.twig');
    }


}