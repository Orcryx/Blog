<?php

namespace App\model;


class UserSessionModel{
    // public int $userId;
    // public string $email;
    // public string $role;
    // public string $nickname;

    public function __construct(public readonly int $userId, public readonly string $email, public readonly string $role, public readonly string $nickname)
    {
     
    }
    // public function isOwer() : 
    // {
        
    // }
}