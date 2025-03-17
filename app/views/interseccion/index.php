<?php
/** @var array $intersecciones  */
require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Intersecciones Registradas</h2>

    <a href="index.php?controller=Interseccion&action=create" class="btn btn-primary mb-3">Agregar Nueva Intersección</a>

    <table class="table table-striped">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Calle</th>
            <th>Avenida</th>
            <th>Descripción</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($intersecciones as $interseccion): ?>
            <tr>
                <td><?php echo $interseccion['Id']; ?></td>
                <td><?php echo $interseccion['Calle']; ?></td>
                <td><?php echo $interseccion['Avenida']; ?></td>
                <td><?php echo $interseccion['Descripcion']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
