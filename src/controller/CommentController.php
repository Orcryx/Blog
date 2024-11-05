<?php

namespace App\controller;

use App\service\TwigService;
use App\manager\CommentManager;
// use App\manager\UserManager;
use App\controller\ElementsController;

class CommentController
{
    private CommentManager $commentManager;
    private TwigService $twigService;
    // private UserManager $userManager;
    private ElementsController $element;

    public function __construct(CommentManager $commentManager, TwigService $twigService)
    {
        $this->commentManager = $commentManager;
        $this->twigService = $twigService;
        // $this->userManager = new UserManager();
        $this->element = new ElementsController($this->twigService);
    }

    public function addComment(): void
    {
        // Utiliser FILTER_DEFAULT pour récupérer les données sans les échapper
        $input = filter_input_array(INPUT_POST, [
            'content' => FILTER_DEFAULT, // On n'échappe pas ici
            'postId'  => FILTER_VALIDATE_INT,
            'userId'  => FILTER_VALIDATE_INT,
        ]);

        // Vérifier si les champs requis sont définis et valides
        if ($input['content'] !== null && $input['postId'] !== null && $input['userId'] !== null) {
            $comment = strip_tags($input['content']);
            $postId = strip_tags($input['postId']);
            $userId = strip_tags($input['userId']);
            if (!empty($comment)) {
                $isValidated = 0;
                $message = "Votre commentaire est en attente de validation";
                // Ajouter le commentaire
                $this->commentManager->addCommentByPostId($postId, $comment, $userId, $isValidated);
            } else {
                $message = "Erreur: le commentaire ne peut pas être vide.";
            }
        } else {
            $message = "Erreur: tous les champs ne sont pas remplis.";
        }
        $this->element->showDialog($message);
    }

    public function deleteComment(): void
    {
        // Utiliser FILTER_VALIDATE_INT sans échappement
        $commentId = strip_tags(filter_input(INPUT_POST, 'commentId', FILTER_VALIDATE_INT));
        if ($commentId !== null) {
            $this->commentManager->deleteCommentById($commentId);
            $message = "Le commentaire a été supprimé.";
        } else {
            $message = "Échec de la suppression du commentaire";
        }
        $this->element->showDialog($message);;
    }

    public function publishComment(): void
    {
        // Utiliser FILTER_VALIDATE_INT sans échappement
        $commentId = strip_tags(filter_input(INPUT_POST, 'commentId', FILTER_VALIDATE_INT));

        if ($commentId !== null) {
            $this->commentManager->publishCommentById($commentId);
            $message = "Le commentaire est publié.";
        } else {
            $message = "Échec de la publication du commentaire";
        }
        $this->element->showDialog($message);
    }
}
