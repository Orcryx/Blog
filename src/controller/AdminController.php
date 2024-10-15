<?php

namespace App\controller;

use App\service\TwigService;
use App\manager\CommentManager;
use App\service\UserService;
use App\model\CommentModel;

class AdminController
{
    public function __construct(
        private readonly CommentManager $commentManager,
        private readonly TwigService $twigService,
        private readonly UserService $userService
    ) {
        //contenu du constructeur
    }

    public function dashboardAdmin()
    {
        $unvalidatedComments = $this->commentManager->getNoValidatedComment();
        // Rendre la vue admin.twig en passant les commentaires non validés
        echo $this->twigService->render('admin/admin.twig', ['comments' => $unvalidatedComments]);
    }
}
