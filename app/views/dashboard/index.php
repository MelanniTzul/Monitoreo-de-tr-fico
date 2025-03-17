<?php
require_once __DIR__ . '/../layouts/header.php';


if (!isset($_SESSION['usuario'])) {
    header("Location: index.php?controller=Auth&action=login");
    exit();
}

$usuario = $_SESSION['usuario'];
?>

<div class="container mt-5">
    <h2 class="text-center">Bienvenido al Dashboard</h2>

    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title">Hola, <?php echo $usuario['Nombre'] . ' ' . $usuario['Apellido']; ?> 👋</h4>
            <p class="card-text">Tu rol actual es: <strong><?php echo $usuario['Rol']; ?></strong></p>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
