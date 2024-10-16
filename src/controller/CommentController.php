<?php

namespace App\controller;

use App\service\TwigService;
use App\manager\CommentManager;
use App\service\UserService;
use App\controller\ElementsController;

class CommentController
{
    private CommentManager $commentManager;
    private TwigService $twigService;
    private UserService $userService;
    private ElementsController $element;

    public function __construct(CommentManager $commentManager, TwigService $twigService)
    {
        $this->commentManager = $commentManager;
        $this->twigService = $twigService;
        $this->userService = new UserService();
        $this->element = new ElementsController($this->twigService);;
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
            $comment = $input['content'];
            $postId = $input['postId'];
            $userId = $input['userId'];
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
        $commentId = filter_input(INPUT_POST, 'commentId', FILTER_VALIDATE_INT);
        if ($commentId !== null) {
            $this->commentManager->deleteCommentById($commentId);
            $message = "Le commentaire a été supprimé.";
        } else {
            $message = "Échec de la suppression du commentaire";
        }
        $this->element->showDialog($message);;
    }

    public function updateComment(): void
    {
        // Utiliser FILTER_DEFAULT pour le contenu sans échappement
        $commentId = filter_input(INPUT_POST, 'commentId', FILTER_VALIDATE_INT);
        $comment = filter_input(INPUT_POST, 'content', FILTER_DEFAULT);  // Pas d'échappement ici

        if ($commentId !== null && $comment !== null) {
            $message = "Le commentaire est mis à jour.";
            $this->commentManager->updateCommentById($commentId, $comment);
        } else {
            $message = "Échec de la mise à jour du commentaire";
        }
        $this->element->showDialog($message);
    }

    public function publishComment(): void
    {
        // Utiliser FILTER_VALIDATE_INT sans échappement
        $commentId = filter_input(INPUT_POST, 'commentId', FILTER_VALIDATE_INT);

        if ($commentId !== null) {
            $this->commentManager->publishCommentById($commentId);
            $message = "Le commentaire est publié.";
        } else {
            $message = "Échec de la publication du commentaire";
        }
        $this->element->showDialog($message);
    }
}
