<?php
/** @var array $calles */
/** @var array $avenidas */
require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Crear Nueva Intersección</h2>

    <form action="index.php?controller=Interseccion&action=store" method="POST">
        <div class="mb-3">
            <label for="idCalle" class="form-label">Seleccionar Calle</label>
            <select name="idCalle" class="form-select" required>
                <?php
                foreach ($calles as $calle): ?>
                    <option value="<?php echo $calle['Id']; ?>"><?php echo $calle['Nombre']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="idAvenida" class="form-label">Seleccionar Avenida</label>
            <select name="idAvenida" class="form-select" required>
                <?php
                foreach ($avenidas as $avenida): ?>
                    <option value="<?php echo $avenida['Id']; ?>"><?php echo $avenida['Nombre']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <input type="text" name="descripcion" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="index.php?controller=Interseccion&action=index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
