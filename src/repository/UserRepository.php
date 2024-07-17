<?php

namespace App\repository;
use App\service\DatabaseService;

class UserRepository{

    private DatabaseService $databaseService; 

    public function __construct(DatabaseService $databaseService)
    {
        //initialiser la connexion à la bse de données dans l'objet
        $this->databaseService = $databaseService;
    }


      /**
     * @return object|false
     */
    public function getUserByEmail(string $email) : object|false
    {
        $user = $this->databaseService->prepareAndExecuteOne('SELECT * FROM user WHERE email = :email' , ['email' => $email] );
        return $user;
    }
}