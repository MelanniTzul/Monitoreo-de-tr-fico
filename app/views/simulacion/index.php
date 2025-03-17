<?php
/** @var array $simulaciones  */
require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Simulación de Tráfico</h2>

    <!-- Formulario para subir archivo JSON -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Subir Archivo JSON</h5>
            <form action="index.php?controller=Simulacion&action=cargarArchivo" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="archivo" class="form-label">Cargar archivo JSON:</label>
                    <input type="file" name="archivo" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="idSemaforo" class="form-label">ID del Semáforo:</label>
                    <input type="number" name="idSemaforo" class="form-control" placeholder="Ingrese el ID del Semáforo" required>
                </div>
                <button type="submit" class="btn btn-primary">Subir y procesar</button>
            </form>
        </div>
    </div>

    <!-- Botón para generar tráfico aleatorio -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Generar Tráfico Aleatorio</h5>
            <form action="index.php?controller=Simulacion&action=generarAleatorio" method="POST">
                <div class="mb-3">
                    <label for="idSemaforo" class="form-label">ID del Semáforo:</label>
                    <input type="number" name="idSemaforo" class="form-control" placeholder="Ingrese el ID del Semáforo" required>
                </div>
                <button type="submit" class="btn btn-warning">Generar tráfico aleatorio</button>
            </form>
        </div>
    </div>

    <!-- Tabla de simulaciones -->
    <div class="card">
        <div class="card-body">
            <h3 class="card-title text-center">Historial de Simulaciones</h3>
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Semáforo</th>
                    <th>Carga Vehicular</th>
                    <th>Tipo Generación</th>
                    <th>Fecha</th>
                    <th>Tipos de Vehículos</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($simulaciones as $sim): ?>
                    <tr>
                        <td><?php echo $sim['Id']; ?></td>
                        <td><?php echo $sim['IdSemaforo']; ?></td>
                        <td><?php echo $sim['CargaVehicular']; ?></td>
                        <td><?php echo $sim['TipoGeneracion']; ?></td>
                        <td><?php echo $sim['Fecha']; ?></td>
                        <td><?php echo $sim['DetalleVehiculos']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
