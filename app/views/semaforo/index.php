<?php
/** @var array $semaforos */
require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Gestión de Semáforos</h2>

    <a href="index.php?controller=Semaforo&action=crear" class="btn btn-primary mb-3">Agregar Nuevo Semáforo</a>

    <table class="table table-striped">
        <thead class="table-dark">
        <tr>
            <th>Intersección</th>
            <th>Verde (s)</th>
            <th>Amarillo (s)</th>
            <th>Rojo (s)</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($semaforos as $semaforo): ?>
            <tr>
                <td><?php echo $semaforo['Interseccion']; ?></td>
                <td><?php echo $semaforo['TiempoVerde']; ?></td>
                <td><?php echo $semaforo['TiempoAmarillo']; ?></td>
                <td><?php echo $semaforo['TiempoRojo']; ?></td>
                <td><?php echo $semaforo['EstadoActual']; ?></td>
                <td>
                    <a href="index.php?controller=Semaforo&action=edit&id=<?php echo $semaforo['Id']; ?>" class="btn btn-warning">Editar</a>
                    <a href="index.php?controller=Semaforo&action=delete&id=<?php echo $semaforo['Id']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este semáforo?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
