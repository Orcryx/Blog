<?php

declare(strict_types=1);

namespace App\manager;

use App\repository\UserRepository;
use App\model\UserSessionModel;
use App\Service\DatabaseService;
use App\service\TwigService;
use App\service\RouterService;

class UserManager
{
    private UserRepository $user;
    private RouterService $url;

    public function __construct()
    {
        $this->user = new UserRepository(new DatabaseService());
        $this->url = new RouterService();
    }

    public function logIn(string $email): void
    {
        $twigService = new TwigService();
        // $email = $_POST['email'];
        /** @var object|false  $user  **/
        $user = $this->user->getUserByEmail($email);
        $origin = $this->url->backUrl();
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
        // return $message
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

    // private function isConnected(): bool
    // {
    //     if (isset($_SESSION['status']) && $_SESSION['status'] === true) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    public function checkSessionExpiration(): void
    {
        if (isset($_SESSION['start']) && (time() - $_SESSION['start'] > 600)) {
            $this->logOut();
        }
    }

    public function logOut(): void
    {
        $_SESSION['previous_url'] = $_SERVER['HTTP_REFERER'] ?? '/';
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
}
