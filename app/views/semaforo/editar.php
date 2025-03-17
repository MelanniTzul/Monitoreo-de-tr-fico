<?php
/** @var array $intersecciones  */
require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Editar Semáforo</h2>

    <form action="index.php?controller=Semaforo&action=update" method="POST">
        <input type="hidden" name="id" value="<?php echo $semaforo['Id']; ?>">

        <div class="mb-3">
            <label for="idInterseccion" class="form-label">Intersección</label>
            <select name="idInterseccion" class="form-select" required>
                <?php foreach ($intersecciones as $interseccion): ?>
                    <option value="<?php echo $interseccion['Id']; ?>"
                        <?php echo ($interseccion['Id'] == $semaforo['IdInterseccion']) ? 'selected' : ''; ?>>
                        <?php echo $interseccion['Descripcion']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="tiempoVerde" class="form-label">Tiempo Verde (segundos)</label>
            <input type="number" name="tiempoVerde" class="form-control" value="<?php echo $semaforo['TiempoVerde']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="tiempoAmarillo" class="form-label">Tiempo Amarillo (segundos)</label>
            <input type="number" name="tiempoAmarillo" class="form-control" value="<?php echo $semaforo['TiempoAmarillo']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="tiempoRojo" class="form-label">Tiempo Rojo (segundos)</label>
            <input type="number" name="tiempoRojo" class="form-control" value="<?php echo $semaforo['TiempoRojo']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="estadoActual" class="form-label">Estado Actual del Semáforo</label>
            <select name="estadoActual" class="form-select" required>
                <option value="VERDE" <?php echo ($semaforo['EstadoActual'] == 'VERDE') ? 'selected' : ''; ?>>VERDE</option>
                <option value="AMARILLO" <?php echo ($semaforo['EstadoActual'] == 'AMARILLO') ? 'selected' : ''; ?>>AMARILLO</option>
                <option value="ROJO" <?php echo ($semaforo['EstadoActual'] == 'ROJO') ? 'selected' : ''; ?>>ROJO</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar Cambios</button>
        <a href="index.php?controller=Semaforo&action=index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
