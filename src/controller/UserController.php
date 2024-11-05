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
    $input = filter_input_array(INPUT_POST, [
      'formType' => FILTER_DEFAULT,
      'email'    => FILTER_VALIDATE_EMAIL,
      'password' => FILTER_DEFAULT // Mot de passe sans échappement
    ]);

    $message = '';
    $url = $this->element->getUrl();
    if ($input['formType'] === 'login' && $input['email'] && $input['password']) {
      $email = $input['email'];
      $password = $input['password'];

      if ($this->userManager->logIn($email, $password)) {
        header("Location: $url");
        exit;
      } else {
        $attempts = $this->userManager->getLoginAttempts();
        $message = "Échec de connexion. Tentative $attempts / 3";
        if ($attempts >= 3) {
          $this->userManager->logOut();
          $message = "Compte bloqué après 3 tentatives échouées";
        }
      }
    } else {
      $message = "Erreur : tous les champs sont obligatoires pour la connexion.";
    }

    $this->element->renderTemplate('info.twig', ['message' => $message]);
  }

  public function addOneUser(): void
  {
    $input = filter_input_array(INPUT_POST, [
      'formType'  => FILTER_DEFAULT,
      'name'      => FILTER_DEFAULT,
      'firstName' => FILTER_DEFAULT,
      'nickname'  => FILTER_DEFAULT,
      'email'     => FILTER_VALIDATE_EMAIL,
      'password'  => FILTER_DEFAULT // Mot de passe sans échappement
    ]);

    $textMessage = "Échec d'enregistrement";
    if ($input['formType'] === 'register' && $input['name'] && $input['firstName'] && $input['nickname'] && $input['email'] && $input['password']) {
      $name = strip_tags($input['name']);
      $firstName = strip_tags($input['firstName']);
      $nickname = strip_tags($input['nickname']);
      $email = $input['email'];
      $password = $input['password']; // Pas de strip_tags sur le mot de passe

      if ($this->userManager->register($name, $firstName, $email, $password, $nickname)) {
        $textMessage = "Inscription réussie";
      }
    } else {
      $textMessage = "Erreur : tous les champs requis pour l'inscription ne sont pas remplis ou sont invalides.";
    }

    $this->element->showDialog($textMessage, "/auth");
  }
}
