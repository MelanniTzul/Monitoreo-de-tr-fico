<?php
/** @var array $usuarios  */
require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Gestión de Usuarios</h2>

    <a href="index.php?controller=Usuario&action=createForm" class="btn btn-primary mb-3">Agregar Usuario</a>

    <table class="table table-striped">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Username</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?php echo $usuario['Id']; ?></td>
                <td><?php echo $usuario['Nombre']; ?></td>
                <td><?php echo $usuario['Apellido']; ?></td>
                <td><?php echo $usuario['Username']; ?></td>
                <td><?php echo $usuario['IdRol']; ?></td>
                <td>
                    <a href="index.php?controller=Usuario&action=edit&id=<?php echo $usuario['Id']; ?>" class="btn btn-warning">Editar</a>
                    <a href="index.php?controller=Usuario&action=delete&id=<?php echo $usuario['Id']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
