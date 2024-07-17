<?php
namespace App\controller;

use App\manager\CommentManager;
use App\service\TwigService;
use App\manager\PostManager;


class PostController
{

    //constructeur de la class 
    public function __construct(private readonly PostManager $postManager, private readonly CommentManager $commentManager, private readonly TwigService $twigService)
    {

    }

    public function displayGallery()
    {
        /**@var PostModel[] $posts */
        $posts = $this->postManager->getAll();
        echo $this->twigService->render('gallery.twig',['posts' => $posts]);

    }

    public function displayOnePost(int $postId)
     {
        $articleModel =  $this->postManager->getOne($postId);
        $commentModels = $this->commentManager->getCommentByPost($articleModel->getPostId());
        echo $this->twigService->render('post.twig',['post' => $articleModel, "comments"=>$commentModels]);

     }


  

}