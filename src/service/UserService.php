<?php

declare(strict_types=1);

namespace App\service;
use App\repository\UserRepository;

class UserService{
    private UserRepository $user;

    public function __construct(UserRepository $user)
    {
        $this->user= $user;
    }

    public function logIn(): void
    {
        $email = $_POST['email'];
        echo  " je suis dans logIn : "; var_dump($email);
        /** @var array|null  $user  **/
        $user = $this->user->getUserByEmail($email);
     
    }
}