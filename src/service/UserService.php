<?php

declare(strict_types=1);

namespace App\service;
use App\repository\UserRepository;

class UserService{

    private UserRepository $user;
    private $environnement;

    public function __construct()
    {
        $this->user= new UserRepository(new DatabaseService);
    }

    public function logIn(): void
    {
      
        $email = $_POST['email'];
        /** @var object|null  $user  **/
        $user = $this->user->getUserByEmail($email); 
        if ($user !== null) {
            $hashedPassword = password_hash($user->password, PASSWORD_DEFAULT);
            if(password_verify($_POST['password'],  $hashedPassword))
            {
                echo "reussite !";
                $_SESSION['status'] = true;
                $_SESSION['user']['id'] =$user->userId;
                $_SESSION['user']['email'] =$user->email;
                $_SESSION['user']['role']= $user->role;
                $_SESSION['user']['nickname'] = $user->nickname;
                // $_SESSION['environnement'] = $this->getEnvironnement();
                // header("Location:".$_SESSION['environnement']);
             
            }
            else
            {
                echo "echec de connexion";
               $this->signOut();
        
            }
        }else
        {
            echo "echec de connexion";
        }
     
    }

    public function setEnvironnement($environnement) {
        $this->environnement = $environnement;
        echo  $this->environnement;
    }

    public function getEnvironnement() {
        return $this->environnement;
    }

    private function isConnected() : void
    {
        if (isset($_SESSION['status']) && $_SESSION['status'] === true) {
            header("Location:".$this->getEnvironnement());
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

          // $_SESSION['user']['id'] =$user["userId"];
                // $_SESSION['user']['email'] =$user["email"];
                // $_SESSION['user']['role'] =$user["role"];
                // $_SESSION['user']['nickname'] =$user["nickname"];