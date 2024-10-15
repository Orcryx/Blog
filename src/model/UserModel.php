<?php

namespace App\model;

class UserModel
{
    public const ROLE_ADMIN = "isAdmin";
    public const ROLE_USER = "isUser";
    public const ROLES = [
        self::ROLE_ADMIN,
        self::ROLE_USER
    ];
    public int $userId;
    public string $name;
    public string $firstname;
    public string $email;
    public string $role;
    public string $password;
    public bool $isValidated;
    public string $nickname;
}
