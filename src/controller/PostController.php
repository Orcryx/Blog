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
    
        if ($userSession !== null) {
        // Vérifier si l'utilisateur connecté est l'auteur du post
        $isAuthor = $this->postManager->isOwner($postId, $userSession);

        // Mettre à jour l'objet UserSessionModel avec le boolean isOwner
        $userSession->setIsOwner($isAuthor);
         
        // Mettre à jour la session avec l'objet modifié
         $_SESSION['user'] = $userSession;
        
        }

        echo $this->twigService->render('post.twig',['post' => $articleModel, "comments"=>$commentModels, "isAuthor"=> $isAuthor ]);

     }


  

}