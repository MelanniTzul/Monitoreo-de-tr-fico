<?php
/** @var array $avenidas */
require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Gestión de Avenidas</h2>

    <a href="index.php?controller=Avenida&action=crear" class="btn btn-primary mb-3">Agregar Nueva Avenida</a>

    <table class="table table-striped">
        <thead class="table-dark">
        <tr>
            <th>Nombre</th>
            <th>Número de Carriles</th>
            <th>Sentido</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($avenidas as $avenida): ?>
            <tr>
                <td><?php echo $avenida['Nombre']; ?></td>
                <td><?php echo $avenida['NumeroCarriles']; ?></td>
                <td><?php echo $avenida['Sentido']; ?></td>
                <td>
                    <a href="index.php?controller=Avenida&action=edit&id=<?php echo $avenida['Id']; ?>" class="btn btn-warning">Editar</a>
                    <a href="index.php?controller=Avenida&action=delete&id=<?php echo $avenida['Id']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta avenida?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
