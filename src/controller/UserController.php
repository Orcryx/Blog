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
    $message = '';
    $url = $this->element->getUrl();
    if ($formType === 'login' && isset($_POST['email'], $_POST['password'])) {
      $email = $_POST['email'];
      $password = $_POST['password'];
      if ($this->userManager->logIn($email, $password)) {
        header("Location: $url");
      } else {
        $attempts = $this->userManager->getLoginAttempts();
        $message = "Échec de connexion. Tentative $attempts / 3";
        if ($attempts >= 3) {
          $this->userManager->logOut();
          $message = "Compte bloqué après 3 tentatives échouées";
        }
      }
    }
    $this->element->renderTemplate('info.twig', ['message' => $message]);
  }

  public function addOneUser(): void
  {
    $formType = $_POST['formType'] ?? '';
    $textMessage = "Échec d'enregistrement";
    if ($formType === 'register' && isset($_POST['name'], $_POST['firstName'], $_POST['nickname'], $_POST['email'], $_POST['password'])) {
      $name = $_POST['name'];
      $firstName = $_POST['firstName'];
      $nickname = $_POST['nickname'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      if ($this->userManager->register($name, $firstName, $email, $password, $nickname)) {
        $textMessage = "Inscription réussie";
      }
    }
    $this->element->showDialog($textMessage, "/auth");
  }
}
