<?php
// Definir la base del proyecto dentro de `app/`
define("APP_PATH", __DIR__ . "/");

// Obtener el controlador y la acción de la URL
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'Home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Cargar el archivo del controlador desde `app/controllers/`
$controllerFile = APP_PATH . "controllers/{$controller}Controller.php";

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controllerClass = $controller . 'Controller';
    $controllerInstance = new $controllerClass();

    if (method_exists($controllerInstance, $action)) {
        $controllerInstance->$action();
    } else {
        echo "Error: Acción no encontrada";
    }
} else {
    echo "Error: Controlador no encontrado";
}
