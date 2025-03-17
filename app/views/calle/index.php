<?php
/** @var array $calles  */
require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Gestión de Calles</h2>

    <a href="index.php?controller=Calle&action=crear" class="btn btn-primary mb-3">Agregar Nueva Calle</a>

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
        <?php
        foreach ($calles as $calle): ?>
            <tr>
                <td><?php echo $calle['Nombre']; ?></td>
                <td><?php echo $calle['NumeroCarriles']; ?></td>
                <td><?php echo $calle['Sentido']; ?></td>
                <td>
                    <a href="index.php?controller=Calle&action=edit&id=<?php echo $calle['Id']; ?>" class="btn btn-warning">Editar</a>
                    <a href="index.php?controller=Calle&action=delete&id=<?php echo $calle['Id']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta calle?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
