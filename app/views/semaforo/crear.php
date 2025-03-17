<?php
/** @var array $intersecciones */
require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Agregar Nuevo Semáforo</h2>

    <!-- ✅ Mensaje de error si ya hay 4 semáforos -->
    <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
        <div class="alert alert-danger text-center">
            <strong>Error:</strong> No puedes agregar más de 4 semáforos a una intersección.
        </div>
    <?php endif; ?>

    <form action="index.php?controller=Semaforo&action=store" method="POST">
        <div class="mb-3">
            <label for="idInterseccion" class="form-label">Intersección</label>
            <select name="idInterseccion" class="form-select" required>
                <?php foreach ($intersecciones as $interseccion): ?>
                    <option value="<?php echo $interseccion['Id']; ?>"><?php echo $interseccion['Descripcion']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="tiempoVerde" class="form-label">Tiempo Verde (segundos)</label>
            <input type="number" name="tiempoVerde" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tiempoAmarillo" class="form-label">Tiempo Amarillo (segundos)</label>
            <input type="number" name="tiempoAmarillo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tiempoRojo" class="form-label">Tiempo Rojo (segundos)</label>
            <input type="number" name="tiempoRojo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="estadoActual" class="form-label">Estado Actual del Semáforo</label>
            <select name="estadoActual" class="form-select" required>
                <option value="VERDE">Verde</option>
                <option value="AMARILLO">Amarillo</option>
                <option value="ROJO">Rojo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="index.php?controller=Semaforo&action=index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
