<?php

declare(strict_types=1);

namespace App\manager;

use App\repository\UserRepository;
use App\model\UserSessionModel;
use App\Service\DatabaseService;

class UserManager
{
    private UserRepository $user;

    public function __construct()
    {
        $this->user = new UserRepository(new DatabaseService());
    }

    public function logIn(string $email, string $password): bool
    {
        $user = $this->user->getUserByEmail($email);

        if ($user && password_verify($password, $user->password)) {
            $_SESSION['status'] = true;
            $_SESSION['user'] = new UserSessionModel($user->userId, $user->email, $user->role, $user->nickname);
            $_SESSION['login_attempts'] = 0;
            return true;
        } else {
            $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
            return false;
        }
    }

    public function register(string $name, string $firstName, string $email, string $password, string $nickname): bool
    {
        $user = $this->user->getUserByEmail($email);

        if (!$user) {
            $this->user->insertUser($name, $firstName, $email, $password, $nickname);
            return true;
        }

        return false;
    }

    public function logOut(): void
    {
        $_SESSION['previous_url'] = $_SERVER['HTTP_REFERER'] ?? '/';
        $previousUrl = $_SESSION['previous_url'] ?? '/';
        session_unset();
        session_destroy();
        header("Location: $previousUrl");
    }

    public function getUserSession(): ?UserSessionModel
    {
        return $_SESSION['user'] ?? null;
    }

    public function getLoginAttempts(): int
    {
        return $_SESSION['login_attempts'] ?? 0;
    }

    public function resetLoginAttempts(): void
    {
        $_SESSION['login_attempts'] = 0;
    }
}
