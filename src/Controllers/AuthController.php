<?php

namespace App\Controllers;

use App\Core\Database;

class AuthController
{
    public function loginForm()
    {
        require __DIR__ . '/../Views/login.php';
    }

    public function login()
    {
        $db = Database::connect();

        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$_POST['username']]);

        $user = $stmt->fetch();

        if ($user && $user['password'] === $_POST['password']) {
            $_SESSION['user'] = $user['username'];
            header("Location: /");
        } else {
            echo "Login incorrect";
        }
    }

    public function logout()
    {
        session_destroy();
        header("Location: /login");
    }
}