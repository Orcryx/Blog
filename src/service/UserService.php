<?php

declare(strict_types=1);

namespace App\service;

use App\repository\UserRepository;
use App\model\UserSessionModel;
use App\Service\MessageService;

class UserService
{
    private UserRepository $user;
    private $environnement;
    private $session;

    public function __construct()
    {
        $this->user = new UserRepository(new DatabaseService());
    }

    public function logIn(): void
    {
        $twigService = new TwigService();
        $email = $_POST['email'];
        /** @var object|false  $user  **/
        $user = $this->user->getUserByEmail($email);
        $origin = $this->backUrl();
        //Initialiser le nombre de tentative de connexion dans une variable de session
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 0;
        }
        $message = '';
        if ($user !== null && $user !== false) {
            $hashedPassword = password_hash($user->password, PASSWORD_DEFAULT);
            if (password_verify($_POST['password'], $hashedPassword)) {
                echo "reussite !";
                $_SESSION['status'] = true;
                $_SESSION['user'] = new UserSessionModel($user->userId, $user->email, $user->role, $user->nickname);
                $_SESSION['login_attempts'] = 0; // Reset login attempts
                header("Location: $origin");
                exit();
            } else {
                $message = "echec de connexion";
                $_SESSION['login_attempts']++;
                if ($_SESSION['login_attempts'] >= 3) {
                    $this->logOut();
                } else {
                    $message =  "echec de connexion " . $_SESSION['login_attempts'] . "/ 3";
                }
            }
        } else {
            $message =  "echec de connexion";
        }
        // Afficher la page de connexion avec le message d'erreur
        echo $twigService->render('info.twig', ['message' => $message]);
    }

    public function register(): void
    {
        $email = $_POST['email'];
        /** @var object|false  $user  **/
        $user = $this->user->getUserByEmail($email);
        if ($user == null && $user == false) {
            //filtrer les données et crypter le mot de passe
            $name = $_POST['name'];
            $firstName = $_POST['firstName'];
            $nickname = $_POST['nickname'];
            $password = $_POST['password'];

            // 5var_dump( $name, $firstName, $nickname, $password);
            $this->user->insertUser($name, $firstName, $email, $password, $nickname);
            echo "création de compte possible";
            header("Location: {$_SESSION['previous_url']}");
            exit();
        } else {
            echo "création de compte impossible";
        }
    }

    public function getEnvironnement($environnement)
    {
        return $this->environnement = $environnement;
    }

    private function isConnected(): bool
    {
        if (isset($_SESSION['status']) && $_SESSION['status'] === true) {
            return true;
        } else {
            return false;
        }
    }

    public function checkSessionExpiration(): void
    {
        if (isset($_SESSION['start']) && (time() - $_SESSION['start'] > 600)) {
            // Si durée session >= 10 minutes, détruire la session.
            $this->logOut();
        }
    }

    public function logOut(): void
    {
        $previousUrl = $_SESSION['previous_url'] ?? '/';

        session_unset();
        session_destroy();
        header("Location: $previousUrl");
        exit();
    }


    public function getUserSession(): UserSessionModel | null
    {
        if (isset($_SESSION['user']) && $_SESSION['user'] instanceof UserSessionModel) {
            return $_SESSION['user'];
        } else {
            return null; // Retourner null si aucun utilisateur n'est connecté
        }
    }

    public function getPreviousUrl(): ?string
    {
        return $_SESSION['previous_url'] ?? null;
    }

    public function backUrl()
    {
        // Stocker l'URL actuelle dans une variable PHP
        $current_url = $_SERVER['HTTP_REFERER'];
        // Si le formulaire est soumis, stockez l'URL dans la session
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['last_url'] = $_POST['current_url'];
            $current_url = $_SESSION['last_url'];
        }
        return $current_url;
    }
}
