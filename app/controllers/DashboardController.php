<?php

class DashboardController
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?controller=Auth&action=login");
            exit();
        }

        require_once __DIR__ . '/../views/dashboard/index.php';
    }
}
