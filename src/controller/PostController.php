<?php
namespace App\controller;
use App\service\TwigService;
use App\manager\PostManager;
use App\model\PostModel;


class PostController
{


    private TwigService $twigService;
    private PostManager $postManager;

    //constructeur de la class 
    public function __construct(PostManager $postManager)
    {
        $this->twigService = new TwigService();
        $this->postManager = $postManager;
    }

    public function displayGallery()
    {
        /**@var PostModel[] $posts */
        $posts = $this->postManager->getAll();
        echo $this->twigService->twigEnvironnement->render('gallery.twig',['posts' => $posts]);

    }


}