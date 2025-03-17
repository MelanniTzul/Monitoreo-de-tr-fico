<?php
/** @var array $sentidos */
require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Editar Avenida</h2>

    <form action="index.php?controller=Avenida&action=update" method="POST">
        <input type="hidden" name="id" value="<?php echo $avenida['Id']; ?>">

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la Avenida</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo $avenida['Nombre']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="numeroCarriles" class="form-label">Número de Carriles</label>
            <input type="number" name="numeroCarriles" class="form-control" value="<?php echo $avenida['NumeroCarriles']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="idSentido" class="form-label">Sentido</label>
            <select name="idSentido" class="form-select" required>
                <?php foreach ($sentidos as $sentido): ?>
                    <option value="<?php echo $sentido['Id']; ?>"
                        <?php echo ($sentido['Id'] == $avenida['IdSentido']) ? 'selected' : ''; ?>>
                        <?php echo $sentido['Tipo']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar Cambios</button>
        <a href="index.php?controller=Avenida&action=index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
