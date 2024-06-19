<?php
namespace App\controller;

use App\manager\CommentManager;
use App\service\TwigService;
use App\manager\PostManager;



class PostController
{


    private TwigService $twigService;
 


    //constructeur de la class 
    public function __construct(private readonly PostManager $postManager, private readonly CommentManager $commentManager)
    {
        $this->twigService = new TwigService();
    }

    public function displayGallery()
    {
        /**@var PostModel[] $posts */
        $posts = $this->postManager->getAll();
        echo $this->twigService->twigEnvironnement->render('gallery.twig',['posts' => $posts]);

    }

    public function displayOnePost(int $postId)
     {
        $articleModel =  $this->postManager->getOne($postId);
       //var_dump($articleModel);
       var_dump($articleModel->getPostId());
        $commentModels = $this->commentManager->getCommentByPost($articleModel->getPostId());
       
        echo $this->twigService->twigEnvironnement->render('post.twig',['post' => $articleModel, "comments"=>$commentModels]);

     }



  

}