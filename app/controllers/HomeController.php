<?php

class HomeController
{
    public function index()
    {
        // Aquí puedes simplemente cargar tu vista principal
        require_once __DIR__ . '/../views/home/index.php';
    }
}
