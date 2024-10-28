<?php

namespace App\controller;

use App\service\TwigService;
use App\manager\UserManager;

class UserController
{
  private UserManager $userManager;
  private ElementsController $element;


  public function __construct(private readonly TwigService $twigService)
  {
    $this->userManager = new UserManager();
    $this->element = new ElementsController($this->twigService);
  }

  public function showAuth(): void
  {
    $formType = $_POST['formType'] ?? '';
    if ($formType === 'login' && isset($_POST['email']) && isset($_POST['password'])) {
      // Action de connexion
      $this->userManager->logIn($_POST['email']);
    }
  }

  public function addOneUser(): void
  {
    $environnement = "/auth";
    $formType = $_POST['formType'] ?? '';
    if (
      $formType === 'register' && isset($_POST['name']) && isset($_POST['firstName'])
      && isset($_POST['nickname']) && isset($_POST['email']) && isset($_POST['password'])
    ) {
      $this->userManager->register();
    } else {
      $textMessage = "echec";
    }
    $this->element->showDialog($textMessage, $environnement);
  }
}
