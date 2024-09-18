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
        $this->user= new UserRepository(new DatabaseService);
    }

    public function logIn(): void
    {
        $twigService = new TwigService(); 
        $email = $_POST['email'];
        /** @var object|false  $user  **/
        $user = $this->user->getUserByEmail($email); 

         //Initialiser le nombre de tentative de connexion dans une variable de session
         if (!isset($_SESSION['login_attempts'])) 
            {
                $_SESSION['login_attempts'] = 0;
            }
            $message = '';
         if ($user !== null && $user !==false) {
            $hashedPassword = password_hash($user->password, PASSWORD_DEFAULT);
            if(password_verify($_POST['password'],  $hashedPassword))
            {
                echo "reussite !";
                $_SESSION['status'] = true;
                $_SESSION['user'] = new UserSessionModel($user->userId,$user->email,$user->role, $user->nickname);
                $_SESSION['login_attempts'] = 0; // Reset login attempts
                header("Location: {$_SESSION['previous_url']}");
                exit();
            }
            else
            {
                echo  "echec de connexion";
                // $message = MessageService::getMessage("echec de connexion !", MessageService::ALERT_WARNING, $twigService);              
                  $_SESSION['login_attempts']++;
                if ($_SESSION['login_attempts'] >= 3) {
                     $this->logOut();
                } else {
                    echo  "echec de connexion";
                    // $message = MessageService::getMessage( "Echec d'authentification. Tentative " . $_SESSION['login_attempts'] . " / 3.", MessageService::ALERT_WARNING, $twigService);              
                    // header("Location: /auth");
                    // exit();
                }
                    // Afficher la page de connexion avec le message d'erreur
                    echo $twigService->render('message.twig', ['message' => $message, 'origin' => $_SERVER['REQUEST_URI'] ]);
            }     
        }
        else
        {
            echo  "echec de connexion";
            // $message = MessageService::getMessage("echec de connexion !", MessageService::ALERT_WARNING, $twigService);              
            // echo $twigService->render('message.twig', ['message' => $message, 'origin' => $_SERVER['REQUEST_URI'] ]);

        }
    }

    public function register():void
    {
        $email = $_POST['email'];
        /** @var object|false  $user  **/
        $user = $this->user->getUserByEmail($email); 
        if($user == null && $user == false)
        {
            //filtrer les données et crypter le mot de passe
            $name = $_POST['name'];
            $firstName = $_POST['firstName'];
            $nickname = $_POST['nickname'];
            $password = $_POST['password'];
           
            // 5var_dump( $name, $firstName, $nickname, $password);
            $this->user->insertUser($name, $firstName,$email, $password, $nickname);
            echo "création de compte possible";
            header("Location: {$_SESSION['previous_url']}");
            exit();
        }
        else
        {
            echo "création de compte impossible";
        }
       
    }

    public function getEnvironnement($environnement) 
    {
       return $this->environnement = $environnement;
    }

    private function isConnected() : bool
    {
        if (isset($_SESSION['status']) && $_SESSION['status'] === true) {
            return true;
        }else{
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

    public function logOut():void
    {
        session_unset(); 
        session_destroy(); 
        header("Location: {$_SESSION['previous_url']}");
        exit();
    }


    public function getUserSession(): UserSessionModel | null 
    {
        if (isset($_SESSION['user']) && $_SESSION['user'] instanceof UserSessionModel) 
        {            
            return $_SESSION['user'];
        }
        else
        {
            return null; // Retourner null si aucun utilisateur n'est connecté
        }
    }


}
