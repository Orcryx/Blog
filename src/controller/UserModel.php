<?php

namespace App\controller;

use App\service\TwigService;
use App\manager\UserManager;

class UserModel
{
  private UserManager $userManager;
  public function __construct(private readonly TwigService $twigService)
  {
    $this->userManager = new UserManager();
  }

  public function renderTemplate(string $template, array $data): void
  {
    echo $this->twigService->render($template, $data);
  }

  public function showAuth(): void
  {
    $formType = $_POST['formType'] ?? '';
    if ($formType === 'login' && isset($_POST['email']) && isset($_POST['password'])) {
      // Action de connexion
      $this->userManager->logIn($_POST['email']);
    } elseif (
      $formType === 'register' && isset($_POST['name']) && isset($_POST['firstName'])
      && isset($_POST['nickname']) && isset($_POST['email']) && isset($_POST['password'])
    ) {
      // Action d'enregistrement
      $this->userManager->register();
    }
  }
}
