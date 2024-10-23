<?php

namespace App\controller;

use App\service\TwigService;
use App\manager\UserManager;
//rename ElementsController en DialogController

class ElementsController extends AbstractController
{

    private UserManager $userManager;
    public function __construct(TwigService $twigService)
    {
        //indiquer comment est construite le constructeur de la class Parent
        parent::__construct($twigService);
        $this->userManager = new UserManager();
    }

    public function showLoginDialogue(string $previous_url)
    {
        $this->renderTemplate('formConnexion.twig', ["origin" => $previous_url]);
    }

    public function showDynamicDialog()
    {
        $environnement = $this->userManager->getEnvironnement($this->userManager->getPreviousUrl());
        $params = [
            'origine' => $environnement ?: null,
            'type' => isset($_POST['type']) ? $_POST['type'] : null,
            'postId' => isset($_POST['postId']) ? $_POST['postId'] : null,
            'userId' => isset($_POST['userId']) ? $_POST['userId'] : null,
            'commentId' => isset($_POST['commentId']) ? $_POST['commentId'] : null,
            'comment' => isset($_POST['content']) ? $_POST['content'] : null,
            'title' => isset($_POST['title']) ? $_POST['title'] : null
        ];
        $this->renderTemplate('forms.twig', $params);
    }

    public function showDialog(string $message, ?string $origin = null)
    {
        $escapedMessage = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

        // Si $origin est défini, échappe-le, sinon échappe la valeur retournée par getEnvironnement()
        $escapedOrigin = $origin !== null
            ? htmlspecialchars($origin, ENT_QUOTES, 'UTF-8')
            : htmlspecialchars($this->userManager->getEnvironnement($this->userManager->getPreviousUrl()), ENT_QUOTES, 'UTF-8');

        // Utilisation de Twig pour rendre le template avec les variables échappées
        $this->renderTemplate('message.twig', [
            'message' => $escapedMessage,
            'origin' => $escapedOrigin
        ]);
    }
}
