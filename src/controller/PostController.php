<?php

namespace App\controller;

use App\manager\CommentManager;
use App\service\TwigService;
use App\manager\PostManager;
use App\manager\UserManager;


class PostController
{
    private ElementsController $element;

    public function __construct(
        private readonly PostManager $postManager,
        private readonly CommentManager $commentManager,
        private readonly TwigService $twigService,
        private readonly UserManager $userManager
    ) {
        $this->element = new ElementsController($this->twigService);
    }

    public function displayGallery()
    {
        /**@var PostModel[] $posts */
        $posts = $this->postManager->getAll();
        $this->element->renderTemplate('gallery.twig', ['posts' => $posts]);
    }

    public function displayOnePost(int $postId)
    {
        $articleModel =  $this->postManager->getOne($postId);
        $commentModels = $this->commentManager->getCommentByPost($articleModel->getPostId());
        // Utilisation de UserManager pour obtenir la session utilisateur
        $userSession = $this->userManager->getUserSession();
        $isCommentOwner = false;
        $isPostOwner = false;
        if ($userSession !== null) {
            // Vérifier si l'utilisateur connecté est l'auteur du post
            $isPostOwner = $this->postManager->isOwner($postId, $userSession);

            // Mettre à jour l'objet UserSessionModel avec le boolean
            $userSession->setIsOwner($isPostOwner);

            // Vérifier si l'utilisateur connecté est l'auteur de chaque commentaire
            foreach ($commentModels as $commentModel) {
                $id = $commentModel->commentId;
                // Vérifier si l'utilisateur connecté est l'auteur du commentaire
                $isCommentOwner = $this->commentManager->isOwner($id, $userSession);

                //Ajouter au model du commentaire une valeur IsOwner (pour chaque commentaire)
                $commentModel->isOwner = $isCommentOwner;
            }
            // Mettre à jour la session avec l'objet modifié
            $_SESSION['user'] = $userSession;
            $this->element->renderTemplate(
                'post.twig',
                ['post' => $articleModel, "comments" => $commentModels, "isAuthor" => $isPostOwner]
            );
        } else {
            $this->element->renderTemplate(
                'post.twig',
                ['post' => $articleModel, "comments" => $commentModels]
            );
        }
    }

    public function createOnePost(): void
    {
        $environnement = "/admin";

        // Utilisation de filter_input pour récupérer les entrées sans les échapper
        $title = strip_tags(filter_input(INPUT_POST, 'title', FILTER_DEFAULT));
        $message = strip_tags(filter_input(INPUT_POST, 'content', FILTER_DEFAULT));
        $userId = strip_tags(filter_input(INPUT_POST, 'userId', FILTER_VALIDATE_INT));

        // Validation des données
        if (empty($title) || empty($message)) {
            $message = 'Le titre et le contenu sont obligatoires.';
            $this->element->showDialog($message);
            return;
        } else {
            $date = new \DateTime();
            $createdAt = $date->format('Y-m-d H:i:s');
            $this->postManager->createOnePost($title, $message, $userId, $createdAt);
            $textMessage = "Article ajouté";
            $this->element->showDialog($textMessage, $environnement);
        }
    }

    public function deleteOnePost(): void
    {
        $environnement = "/blog";

        // Utilisation de filter_input pour valider l'ID du post
        $postId = strip_tags(filter_input(INPUT_POST, 'postId', FILTER_VALIDATE_INT));

        if ($postId !== false && $postId !== null) {
            $message = "L'article a été supprimé";
            $this->postManager->deletePostById($postId);
        } else {
            $message = "Erreur: référence article introuvable.";
        }
        $this->element->showDialog($message, $environnement);
    }

    public function updateOnePost(): void
    {
        // Récupérer les données POST sans échapper les caractères
        $postId = strip_tags(filter_input(INPUT_POST, 'postId', FILTER_VALIDATE_INT));
        $title = strip_tags(filter_input(INPUT_POST, 'title', FILTER_DEFAULT));
        $message = strip_tags(filter_input(INPUT_POST, 'content', FILTER_DEFAULT));

        if ($postId && $title && $message) {
            $this->postManager->updateOnePostById($postId, $title, $message);
            $message = "Article mis à jour avec succès.";
        } else {
            $message = "Echec de la requête.";
        }
        $this->element->showDialog($message);
    }
}
