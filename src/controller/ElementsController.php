<?php

namespace App\controller;

use App\service\TwigService;
use App\service\UserService;

class ElementsController
{
    private UserService $userService;
    public function __construct(private readonly TwigService $twigService)
    {
        $this->userService = new UserService();
    }

    public function showLoginDialogue(string $previous_url)
    {
        echo $this->twigService->render('formConnexion.twig', ["origin" => $previous_url]);
    }

    public function showDynamicDialog()
    {
        $environnement = $this->userService->getEnvironnement($this->userService->getPreviousUrl());
        $params = [
            'origine' => $environnement ?: null,
            'type' => isset($_POST['type']) ? $_POST['type'] : null,
            'postId' => isset($_POST['postId']) ? $_POST['postId'] : null,
            'userId' => isset($_POST['userId']) ? $_POST['userId'] : null,
            'commentId' => isset($_POST['commentId']) ? $_POST['commentId'] : null,
            'comment' => isset($_POST['content']) ? $_POST['content'] : null,
            'title' => isset($_POST['title']) ? $_POST['title'] : null
        ];
        echo $this->twigService->render('forms.twig', $params);
    }

    public function showDialog(string $message)
    {
        echo $this->twigService->render('message.twig', [
            'message' => htmlspecialchars($message, ENT_QUOTES, 'UTF-8'),
            'origin' => htmlspecialchars($this->userService->getEnvironnement($this->userService->getPreviousUrl()), ENT_QUOTES, 'UTF-8')
        ]);
    }
}
