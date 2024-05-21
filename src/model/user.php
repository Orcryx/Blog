<?php

namespace model;

class User{
    public int $userId;
    public string $name;
    public string $firstname;
    public string $email;
    public int $role;
    public string $password;
    public bool $isValidated;
    public string $nickname;
}