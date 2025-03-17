<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$rolUsuario = isset($_SESSION['usuario']['Rol']) ? $_SESSION['usuario']['Rol'] : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoreo de Tráfico</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/views/assets/css/styles.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php?controller=Dashboard&action=index">Tráfico</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item"><a class="nav-link" href="index.php?controller=Dashboard&action=index">Inicio</a></li>

                <?php if ($rolUsuario === 'Administrador'): ?>
                    <li class="nav-item"><a class="nav-link" href="index.php?controller=Usuario&action=index">Gestionar Usuarios</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?controller=Interseccion&action=index">Gestionar Intersecciones</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?controller=Calle&action=index">Gestionar Calles</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?controller=Avenida&action=index">Gestionar Avenidas</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?controller=Semaforo&action=index">Gestionar Semáforos</a></li>
                <?php endif; ?>

                <?php if ($rolUsuario === 'Monitor'): ?>
                    <li class="nav-item"><a class="nav-link" href="index.php?controller=Simulacion&action=index">Simulación</a></li>
                <?php endif; ?>

                <?php if ($rolUsuario === 'Supervisor'): ?>
                    <li class="nav-item"><a class="nav-link" href="index.php?controller=Simulacion&action=interseccion">Visualizar Intersección</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?controller=Simulacion&action=grafica">Visualizar Gráfica</a></li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link btn btn-danger text-white ms-3" href="index.php?controller=Auth&action=logout">Cerrar Sesión</a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<main class="container mt-4">
