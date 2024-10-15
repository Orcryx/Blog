<?php
namespace App\controller;
use App\service\TwigService;
use App\manager\CommentManager;
use App\service\UserService;

class CommentController
{
    private CommentManager $commentManager;
    private TwigService $twigService;
    private UserService $userService;

    public function __construct(CommentManager $commentManager, TwigService $twigService)
    {
        $this->commentManager = $commentManager;
        $this->twigService = $twigService;
        $this->userService = new UserService();

    }

    public function addComment():  void
    {
        $environnement = $this->userService->getEnvironnement($_SESSION['previous_url']);

        // Vérifiez si les champs requis sont définis dans le tableau $_POST
        if (isset($_POST['content'], $_POST['postId'], $_POST['userId'])) {
            $comment = trim($_POST['content']); // Nettoyer le commentaire pour éviter les espaces superflus
            $postId = intval($_POST['postId']); // Convertir l'ID du post en entier
            $userId = intval($_POST['userId']); // Convertir l'ID de l'utilisateur en entier
    
            // Vérifiez si les champs sont valides (par exemple, le commentaire n'est pas vide)
            if (!empty($comment)) {
                $isValidated = 0; // Selon votre logique de validation par modération
                $message = "Votre commentaire est en attente de validation";
                
                // Ajoutez le commentaire si tout est valide
                $this->commentManager->addCommentByPostId($postId, $comment, $userId, $isValidated);
            } else {
                // Affichez un message d'erreur si le commentaire est vide
                $message = "Erreur: le commentaire ne peut pas être vide.";
            }
        } else {
            // Affichez un message d'erreur si tous les champs requis ne sont pas remplis
            $message = "Erreur: tous les champs ne sont pas remplis.";
        }
    
        // Renvoyer le message avec Twig
        echo $this->twigService->render('message.twig', ['message' => $message, 'origin'=>$environnement]);
    }
    


    public function deleteComment(int $commentId) : void
    {
         $this->commentManager->deleteCommentById($commentId);
        // return $this->twigService->render('message.twig', ['message' => $deleteComment]);
    }

    public function updateComment(int $commentId, string $comment) : void
    {
       $this->commentManager->updateCommentById($commentId, $comment);
        // return $this->twigService->render('message.twig', ['message' => $updateComment]);
    }

    public function publishComment(int $commentId) : void //string si message
    {
         $this->commentManager->publishCommentById($commentId);
        // return $this->twigService->render('message.twig', ['message' => $publishComment]);
    }
}