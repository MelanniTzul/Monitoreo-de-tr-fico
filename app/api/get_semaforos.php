<?php
require_once __DIR__ . '/../config/config.php';
header('Content-Type: application/json');

global $mysqli;

if (!isset($_GET['idInterseccion'])) {
    echo json_encode(["error" => "ID de intersección requerido"]);
    exit();
}

$idInterseccion = intval($_GET['idInterseccion']);
$query = $mysqli->prepare("SELECT Id, EstadoActual, TiempoVerde, TiempoAmarillo, TiempoRojo FROM Semaforo WHERE IdInterseccion = ?");
$query->bind_param("i", $idInterseccion);
$query->execute();
$result = $query->get_result();

$semaforos = [];

while ($row = $result->fetch_assoc()) {
    $semaforos[] = [
        "Id" => $row["Id"],
        "EstadoActual" => strtolower($row["EstadoActual"]), // Verde, Amarillo, Rojo
        "TiempoVerde" => $row["TiempoVerde"],
        "TiempoAmarillo" => $row["TiempoAmarillo"],
        "TiempoRojo" => $row["TiempoRojo"]
    ];
}

echo json_encode($semaforos);
