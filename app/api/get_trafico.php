<?php
require_once __DIR__ . '/../config/config.php';
header('Content-Type: application/json');

global $mysqli;

if (!isset($_GET['idInterseccion'])) {
    echo json_encode(["error" => "ID de intersección requerido"]);
    exit();
}

$idInterseccion = intval($_GET['idInterseccion']);
$query = $mysqli->prepare("
    SELECT Id, CargaVehicular, VelocidadProm 
    FROM SimulacionFlujo 
    WHERE IdSemaforo IN (SELECT Id FROM Semaforo WHERE IdInterseccion = ?) 
    ORDER BY Fecha DESC 
    LIMIT 1
");
$query->bind_param("i", $idInterseccion);
$query->execute();
$result = $query->get_result();

if ($row = $result->fetch_assoc()) {
    $idSimulacionFlujo = $row["Id"]; // ✅ Ahora tenemos el ID de la simulación

    // 🔹 Recuperar vehículos de SimulacionVehiculo
    $queryVehiculos = $mysqli->prepare("
        SELECT IdTipoVehiculo, Cantidad 
        FROM SimulacionVehiculo 
        WHERE IdSimulacionFlujo = ?
    ");
    $queryVehiculos->bind_param("i", $idSimulacionFlujo);
    $queryVehiculos->execute();
    $resultVehiculos = $queryVehiculos->get_result();

    $vehiculos = [];
    while ($vehiculo = $resultVehiculos->fetch_assoc()) {
        $vehiculos[$vehiculo["IdTipoVehiculo"]] = $vehiculo["Cantidad"];
    }

    echo json_encode([
        "cargaVehicular" => $row["CargaVehicular"],
        "velocidadPromedio" => $row["VelocidadProm"],
        "vehiculos" => $vehiculos // ✅ Ahora devuelve correctamente los vehículos
    ]);
} else {
    echo json_encode(["error" => "No hay datos de tráfico para esta intersección"]);
}
?>
