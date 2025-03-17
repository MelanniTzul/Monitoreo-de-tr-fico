<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Proyecto Semáforos</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Íconos de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Estilos personalizados -->
    <style>
        body {
            background: linear-gradient(to right, #0062E6, #33AEFF);
            color: white;
            font-family: Arial, sans-serif;
        }
        .login-container {
            margin-top: 5%;
            background: rgba(255, 255, 255, 0.2);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-custom {
            background-color: #33AEFF;
            border: none;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .info-container {
            background: rgba(0, 0, 0, 0.2);
            padding: 30px;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<!-- Contenedor Principal -->
<div class="container">
    <div class="row justify-content-center align-items-center vh-100">
        <!-- Sección Izquierda: Información del Proyecto -->
        <div class="col-md-6">
            <div class="info-container text-center p-4">
                <h1><i class="bi bi-traffic-light"></i> Proyecto Semáforos Inteligentes</h1>
                <p class="mt-3">
                    Este sistema permite el análisis y modificación del comportamiento de los semáforos en tiempo real,
                    mediante el uso de sensores y procesamiento de datos.
                </p>
                <ul class="list-unstyled">
                    <li><i class="bi bi-check-circle-fill"></i> Visualización de intersecciones</li>
                    <li><i class="bi bi-check-circle-fill"></i> Control en tiempo real</li>
                    <li><i class="bi bi-check-circle-fill"></i> Reportes de tráfico</li>
                </ul>
            </div>
        </div>

        <!-- Sección Derecha: Login -->
        <div class="col-md-5">
            <div class="login-container text-center">
                <h3><i class="bi bi-person-circle"></i> Iniciar Sesión</h3>
                <form action="index.php?controller=Auth&action=login" method="POST" class="mt-4">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="username" placeholder="Usuario" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-custom w-100">Ingresar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
