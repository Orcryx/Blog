<?php

namespace App\controller;

use App\service\TwigService;
use App\manager\CommentManager;
use App\manager\UserManager;
// use App\model\CommentModel;

class AdminController
{
    private ElementsController $element;
    public function __construct(
        private readonly CommentManager $commentManager,
        private readonly TwigService $twigService,
        private readonly UserManager $userManager
    ) {
        $this->element = new ElementsController($this->twigService);
    }

    public function dashboardAdmin()
    {
        $userSession = $this->userManager->getUserSession();
        if ($userSession !== null) {
            $unvalidatedComments = $this->commentManager->getNoValidatedComment();
            // Rendre la vue admin.twig en passant les commentaires non validés
            $this->element->renderTemplate(
                'admin/admin.twig',
                ['comments' => $unvalidatedComments]
            );
        } else {
            $this->element->showIndex();
        }
    }
}
