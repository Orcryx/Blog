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
            $hashedPassword = password_hash($user[0]["password"], PASSWORD_DEFAULT);
            if(password_verify($_POST['password'],  $hashedPassword))
            {
                echo "reussite !";
                $_SESSION['status'] = true;
                $_SESSION['userId'] =$user[0]["userId"];
                $_SESSION['email'] =$user[0]["email"];
                $_SESSION['role'] = $user[0]["role"];
                $_SESSION['nickname'] = $user[0]["nickname"];
                $_SESSION['environnement'] = $environnement;
                //header("Location:".$_SESSION['environnement']);
       
            }
            else
            {
                echo "echec de connexion";
            }
        }else
        {
            echo "echec de connexion";
        }
     
    }

    // private function isConnected() : void
    // {
    //     if (isset($_SESSION['status']) && $_SESSION['status'] === true) {
    //         header("Location:".$_SESSION['environnement']);
    //     }
    // }

    public function signOut():void
    {
        unset($_SESSION['userId']);
        unset($_SESSION['email']);
        unset($_SESSION['role']);
        unset($_SESSION['nickname']);
        unset($_SESSION['environnement'] );
    }

}