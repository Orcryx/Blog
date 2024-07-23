<?php
namespace App\controller;

use App\manager\CommentManager;
use App\service\TwigService;
use App\manager\PostManager;
use App\model\UserSessionModel;
use App\service\UserService;

class PostController
{

    //constructeur de la class 
    public function __construct(private readonly PostManager $postManager, private readonly CommentManager $commentManager, private readonly TwigService $twigService, private readonly UserService $userService)
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
        // Utilisation de UserService pour obtenir la session utilisateur
        $userSession = $this->userService->getUserSession();

        // Vérifier si l'utilisateur connecté est l'auteur du post
        $isOwner = $this->postManager->isOwner($postId, $userSession);

      // Mettre à jour l'objet UserSessionModel avec le boolean isOwner
        $userSession->setIsOwner($isOwner);
        var_dump(  $isOwner);
        
        echo $this->twigService->render('post.twig',['post' => $articleModel, "comments"=>$commentModels]);

     }


  

}