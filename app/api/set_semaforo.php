<?php
require_once __DIR__ . '/../config/config.php';
header('Content-Type: application/json');

global $mysqli;

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['idSemaforo']) || !isset($data['estado'])) {
    echo json_encode(["error" => "ID de semáforo y estado requerido"]);
    exit();
}

$idSemaforo = intval($data['idSemaforo']);
$estado = strtoupper($data['estado']); // Normalizar a MAYÚSCULAS (VERDE, AMARILLO, ROJO)

// Validar estado permitido
$estadosPermitidos = ["VERDE", "AMARILLO", "ROJO"];
if (!in_array($estado, $estadosPermitidos)) {
    echo json_encode(["error" => "Estado inválido"]);
    exit();
}

// Actualizar estado en la BD con marca de tiempo
$query = $mysqli->prepare("UPDATE Semaforo SET EstadoActual = ?, UltimaActualizacion = NOW() WHERE Id = ?");
$query->bind_param("si", $estado, $idSemaforo);
$success = $query->execute();

echo json_encode(["success" => $success]);
?>
