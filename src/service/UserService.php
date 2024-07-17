<?php

declare(strict_types=1);

namespace App\service;
use App\repository\UserRepository;

class UserService{

    private UserRepository $user;
    private $environnement;
    private $session;

    public function __construct()
    {
        $this->user= new UserRepository(new DatabaseService);
    }

    public function logIn(): void
    {
        $email = $_POST['email'];
        /** @var object|false  $user  **/
        $user = $this->user->getUserByEmail($email); 
        if ($user !== null && $user !==false) {
            $hashedPassword = password_hash($user->password, PASSWORD_DEFAULT);
            if(password_verify($_POST['password'],  $hashedPassword))
            {
                //echo "reussite !";
                $_SESSION['status'] = true;
                $_SESSION['user']['id'] =$user->userId;
                $_SESSION['user']['email'] =$user->email;
                $_SESSION['user']['role']= $user->role;
                $_SESSION['user']['nickname'] = $user->nickname;
            }
            else
            {
               //echo "echec de connexion";
                $this->logOut();
            }
        }else
        {
            echo "echec de connexion";
        }
    }

    public function getEnvironnement($environnement) {
       return $this->environnement = $environnement;
    }

    
    // private function isConnected() : void
    // {
    //     if (isset($_SESSION['status']) && $_SESSION['status'] === true) {
    //         header("Location:".$this->getEnvironnement());
    //     }
    // }

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
    }

}
