<?php

use models\Usuario;

require_once __DIR__ . '/../models/Usuario.php';

class AuthController
{
    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->login($username, $password);

            if ($usuario) {
                session_start();
                $_SESSION['usuario'] = $usuario;
                header("Location: index.php?controller=Dashboard&action=index");
                exit();
            } else {
                header("Location: index.php?controller=Home&action=index&error=1");
                exit();
            }
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: index.php?controller=Home&action=index");
        exit();
    }
}
