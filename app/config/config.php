<?php
$servidor = "localhost";
$usuario = "root";
$password = "admin";
$base_datos = "simulacionSemaforo";

// Usar $mysqli en lugar de $conn para coincidir con lo que usa la clase Simulacion
$mysqli = new mysqli($servidor, $usuario, $password, $base_datos);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
} else {
    error_log("Connected successfully");
}
