<?php
namespace App\controller;

use App\service\TwigService;
use App\service\UserService;

class ElementsController
{
    private UserService $userService;
    
    //constructeur de la class 
    public function __construct(private readonly TwigService $twigService)
    {

        $this->userService = new UserService();
    }

    public function showLoginDialogue(string $previous_url)
    {
        $environnement = $this->userService->getEnvironnement($_SESSION['previous_url']);
   
        echo $this->twigService->render('formConnexion.twig',["origin"=>$environnement]);
    }

    public function showDynamicDialog()
    {   
        $environnement = $this->userService->getEnvironnement($_SESSION['previous_url']);
        $params = [  
            'origine'=> $environnement ? : null,    
            'type' => isset($_POST['type']) ? $_POST['type'] : null,
            'postId' => isset($_POST['postId']) ? $_POST['postId'] : null,
            'userId' => isset($_POST['userId']) ? $_POST['userId'] : null,
            'commentId' => isset($_POST['commentId']) ? $_POST['commentId'] : null,
            'comment' => isset($_POST['content']) ? $_POST['content'] : null,
            'title' => isset($_POST['title']) ? $_POST['title'] : null
        ];
        echo $this->twigService->render('forms.twig', $params);
    }
}