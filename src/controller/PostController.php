<?php
namespace App\controller;

use App\manager\CommentManager;
use App\service\TwigService;
use App\manager\PostManager;
use App\service\UserService;

class PostController
{

    //constructeur de la class 
    public function __construct(private readonly PostManager $postManager, private readonly CommentManager $commentManager, private readonly TwigService $twigService, private readonly UserService $userService)
    {
        // session_start();
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
        $isCommentOwner = false ;
        $isPostOwner = false;
        if ($userSession !== null) {
        // Vérifier si l'utilisateur connecté est l'auteur du post
        $isPostOwner = $this->postManager->isOwner($postId, $userSession);

        // Mettre à jour l'objet UserSessionModel avec le boolean
        $userSession->setIsOwner($isPostOwner);
         
        // Vérifier si l'utilisateur connecté est l'auteur de chaque commentaire
        foreach ($commentModels as $commentModel) 
        {
            $id = $commentModel->commentId;
             // Vérifier si l'utilisateur connecté est l'auteur du commentaire
            $isCommentOwner = $this->commentManager->isOwner($id, $userSession) ;

            //Ajouter au model du commentaire une valeur IsOwer (pour chaque commentaire)
            $commentModel->isOwner = $isCommentOwner; 
        }
         // Mettre à jour la session avec l'objet modifié
         $_SESSION['user'] = $userSession;
         echo $this->twigService->render('post.twig',['post' => $articleModel, "comments"=>$commentModels, "isAuthor"=> $isPostOwner ]);
        }
        else
        {
            echo $this->twigService->render('post.twig',['post' => $articleModel, "comments"=>$commentModels ]);
        }


     }


     public function createOnePost(string $title, string $message, int $userId, string $createdAt): void
     {
        $this->postManager->createOnePost($title, $message, $userId, $createdAt ); 
     }

     public function deleteOnePost(int $postId) : void
     {
         $this->postManager->deletePostById($postId); 
     }
  
     public function updateOnePost(int $postId, string $title, string $message) : void
     {
         $this->postManager->updateOnePostById($postId, $title, $message); 
     }
  

}