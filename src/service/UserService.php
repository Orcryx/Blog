<?php

declare(strict_types=1);

namespace App\service;
use App\repository\UserRepository;

class UserService{

    private UserRepository $user;

    public function __construct()
    {
        $this->user= new UserRepository(new DatabaseService);
    }

    public function logIn($environnement): void
    {
        //$this->isConnected();
        $email = $_POST['email'];
        /** @var array|null  $user  **/
        $user = $this->user->getUserByEmail($email); 
        if ($user !== null) {
            $hashedPassword = password_hash($user["password"], PASSWORD_DEFAULT);
            if(password_verify($_POST['password'],  $hashedPassword))
            {
                //echo "reussite !";
                $_SESSION['status'] = true;
                $_SESSION['userId'] =$user["userId"];
                $_SESSION['email'] =$user["email"];
                $_SESSION['role'] = $user["role"];
                $_SESSION['nickname'] = $user["nickname"];
                // $_SESSION['user']['id'] =$user["userId"];
                // $_SESSION['user']['email'] =$user["email"];
                // $_SESSION['user']['role'] =$user["role"];
                // $_SESSION['user']['nickname'] =$user["nickname"];
                $_SESSION['environnement'] = $environnement;
                header("Location:".$_SESSION['environnement']);
            }
            else
            {
                $this->signOut();
                echo "echec de connexion";
            }
        }else
        {
            echo "echec de connexion";
        }
     
    }

    private function isConnected() : void
    {
        if (isset($_SESSION['status']) && $_SESSION['status'] === true) {
            header("Location:".$_SESSION['environnement']);
        }
    }


    public function checkSessionExpiration(): void
{
    if (isset($_SESSION['start']) && (time() - $_SESSION['start'] > 600)) {
        // Si durée session >= 10 minutes, détruire la session.
        session_unset(); 
        session_destroy();
    }
}

    public function signOut():void
    {
        session_unset(); 
        session_destroy(); 
    }

}