<?php

namespace App\model;

class UserModel{
    public int $userId;
    public string $name;
    public string $firstname;
    public string $email;
    public string $role;
    public string $password;
    public bool $isValidated;
    public string $nickname;
}