<?php

namespace App\repository;

use App\service\DatabaseService;

class UserRepository
{
    private DatabaseService $databaseService;

    public function __construct(DatabaseService $databaseService)
    {
        //initialiser la connexion à la bse de données dans l'objet
        $this->databaseService = $databaseService;
    }


    /**
     * @return object|false
     */
    public function getUserByEmail(string $email): object|false
    {
        $user = $this->databaseService->prepareAndExecuteOne(
            'SELECT * FROM user WHERE email = :email',
            ['email' => $email]
        );
        return $user;
    }

    /**
     * @param string $name
     * @param string $firstName
     * @param string $email
     * @param string $password
     * @return void
     */
    public function insertUser(
        string $name,
        string $firstName,
        string $email,
        string $password,
        string $nickname
    ): void {
        // Définir les valeurs par défaut pour isValidated et role
        $isValidated = 0; // par exemple, 0 pour non validé
        $role = 'isUser'; // rôle par défaut, peut-être 'isUser'
        $params = [
            ':name' => $name,
            ':firstName' => $firstName,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_DEFAULT), // Utiliser le hashage de mot de passe
            ':isValidated' => $isValidated,
            ':nickname' => $nickname,
            ':role' => $role
        ];
        $newUser = $this->databaseService->prepareAndExecuteOne(
            'INSERT INTO user (name, firstName, email, password, isValidated, nickname, role) 
            VALUES (:name, :firstName, :email, :password, :isValidated, :nickname, :role)',
            $params
        );
        if ($newUser === false) {
            echo "Echec de la requête SQL Insert Into";
            exit;
        }
    }
}
