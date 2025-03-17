<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Editar Usuario</h2>

    <form action="index.php?controller=Usuario&action=update" method="POST">
        <input type="hidden" name="id" value="<?php echo $usuario['Id']; ?>">

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo $usuario['Nombre']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" name="apellido" class="form-control" value="<?php echo $usuario['Apellido']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo $usuario['Username']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Nueva Contraseña (opcional)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label for="idRol" class="form-label">Rol</label>
            <select name="idRol" class="form-select" required>
                <?php foreach ($roles as $rol): ?>
                    <option value="<?php echo $rol['Id']; ?>" <?php echo ($rol['Id'] == $usuario['IdRol']) ? 'selected' : ''; ?>>
                        <?php echo $rol['Nombre']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar Cambios</button>
        <a href="index.php?controller=Usuario&action=index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
