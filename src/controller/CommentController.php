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

    public function addComment(): void
    {
        $environnement = $this->userService->getEnvironnement($this->userService->getPreviousUrl());

        // Utiliser filter_input_array pour récupérer et valider les données
        $input = filter_input_array(INPUT_POST, [
            'content' => [
                'filter' => FILTER_CALLBACK,
                'options' => function ($value) {
                    return htmlspecialchars(trim($value), ENT_QUOTES);
                },
            ],
            'postId' => FILTER_VALIDATE_INT,
            'userId' => FILTER_VALIDATE_INT,
        ]);

        // Vérifiez si les champs requis sont définis et valides
        if ($input['content'] !== null && $input['postId'] !== null && $input['userId'] !== null) {
            $comment = $input['content']; // Le commentaire est déjà nettoyé
            $postId = $input['postId']; // L'ID du post est déjà un entier valide
            $userId = $input['userId']; // L'ID de l'utilisateur est déjà un entier valide

            // Vérifiez si le commentaire n'est pas vide
            if (!empty($comment)) {
                $isValidated = 0; // Selon votre logique de validation par modération
                $message = "Votre commentaire est en attente de validation";

                // Ajoutez le commentaire si tout est valide
                $this->commentManager->addCommentByPostId($postId, $comment, $userId, $isValidated);
            } else {
                $message = "Erreur: le commentaire ne peut pas être vide.";
            }
        } else {
            $message = "Erreur: tous les champs ne sont pas remplis.";
        }

        // Renvoyer le message avec Twig
        echo $this->twigService->render('message.twig', [
            'message' => htmlspecialchars($message, ENT_QUOTES), // Explicitly escape the message
            'origin' => htmlspecialchars($environnement, ENT_QUOTES) // Explicitly escape the origin
        ]);
    }

    public function deleteComment(): void
    {
        $environnement = $this->userService->getEnvironnement($this->userService->getPreviousUrl());

        // Utiliser filter_input pour récupérer commentId
        $commentId = filter_input(INPUT_POST, 'commentId', FILTER_VALIDATE_INT);

        if ($commentId !== null) {
            $this->commentManager->deleteCommentById($commentId);
            $message = "Le commentaire a été supprimé.";
        } else {
            $message = "Echec de la suppression du commentaire";
        }

        // Renvoyer le message avec Twig
        echo $this->twigService->render('message.twig', [
            'message' => htmlspecialchars($message, ENT_QUOTES),
            'origin' => htmlspecialchars($environnement, ENT_QUOTES)
        ]);
    }

    public function updateComment(): void
    {
        $environnement = $this->userService->getEnvironnement($this->userService->getPreviousUrl());

        // Utiliser filter_input pour récupérer commentId et content
        $commentId = filter_input(INPUT_POST, 'commentId', FILTER_VALIDATE_INT);
        $comment = filter_input(INPUT_POST, 'content', FILTER_CALLBACK, [
            'options' => function ($value) {
                return htmlspecialchars(trim($value), ENT_QUOTES);
            },
        ]);

        if ($commentId !== null && $comment !== null) {
            $message = "Le commentaire est publié.";
            $this->commentManager->updateCommentById($commentId, $comment);
        } else {
            $message = "Echec de la publication du commentaire";
        }

        // Renvoyer le message avec Twig
        echo $this->twigService->render('message.twig', [
            'message' => htmlspecialchars($message, ENT_QUOTES),
            'origin' => htmlspecialchars($environnement, ENT_QUOTES)
        ]);
    }

    public function publishComment(): void //string si message
    {
        $environnement = $this->userService->getEnvironnement($this->userService->getPreviousUrl());

        // Utiliser filter_input pour récupérer commentId
        $commentId = filter_input(INPUT_POST, 'commentId', FILTER_VALIDATE_INT);

        if ($commentId !== null) {
            $this->commentManager->publishCommentById($commentId);
            $message = "Le commentaire est publié.";
        } else {
            $message = "Echec de la publication du commentaire";
        }

        // Renvoyer le message avec Twig
        echo $this->twigService->render('message.twig', [
            'message' => htmlspecialchars($message, ENT_QUOTES),
            'origin' => htmlspecialchars($environnement, ENT_QUOTES)
        ]);
    }
}
