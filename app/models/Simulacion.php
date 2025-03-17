<?php

namespace models;
require_once __DIR__ . '/../config/config.php';

class Simulacion
{
    private $conn;

    public function __construct()
    {
        global $mysqli;
        $this->conn = $mysqli;
    }

    public function loadStreamFromFile($rutaArchivo, $idSemaforo)
    {
        // Verificar si el archivo existe y se puede leer
        if (!file_exists($rutaArchivo)) {
            die("Error: El archivo no existe.");
        }

        $jsonData = file_get_contents($rutaArchivo);

        // Verificar si se pudo leer el archivo
        if (!$jsonData) {
            die("Error: No se pudo leer el archivo JSON.");
        }

        // Intentar decodificar el JSON
        $datos = json_decode($jsonData, true);

        // Verificar si se pudo decodificar
        if (json_last_error() !== JSON_ERROR_NONE) {
            die("Error en la decodificación JSON: " . json_last_error_msg());
        }

        // Verificar si contiene los campos esperados
        if (!isset($datos['cargaVehicular'], $datos['vehiculos'])) {
            die("Error: El JSON no contiene las claves esperadas (cargaVehicular, vehiculos).");
        }

        // Insertar en SimulacionFlujo
        $stmt = $this->conn->prepare(
            "INSERT INTO SimulacionFlujo (IdSemaforo, CargaVehicular, VelocidadProm, TipoGeneracion) 
         VALUES (?, ?, ?, 'archivo')"
        );
        $stmt->bind_param("iid", $idSemaforo, $datos['cargaVehicular'], $datos['velocidadPromedio']);

        if (!$stmt->execute()) {
            die("Error al insertar en SimulacionFlujo: " . $stmt->error);
        }

        $idSimulacion = $stmt->insert_id;

        // Insertar los tipos de vehículos
        foreach ($datos['vehiculos'] as $tipoVehiculo => $cantidad) {
            $stmtVehiculo = $this->conn->prepare(
                "INSERT INTO SimulacionVehiculo (IdSimulacionFlujo, IdTipoVehiculo, Cantidad) 
             VALUES (?, ?, ?)"
            );
            $stmtVehiculo->bind_param("iii", $idSimulacion, $tipoVehiculo, $cantidad);

            if (!$stmtVehiculo->execute()) {
                die("Error al insertar en SimulacionVehiculo: " . $stmtVehiculo->error);
            }
        }

        return true;
    }

    public function generateRandomFlow($idSemaforo)
    {
        $cargaVehicular = rand(5, 50); // Total de vehículos
        $velocidadProm = rand(20, 80) + (rand(0, 99) / 100);

        $stmt = $this->conn->prepare(
            "INSERT INTO SimulacionFlujo (IdSemaforo, CargaVehicular, VelocidadProm, TipoGeneracion) 
         VALUES (?, ?, ?, 'random')"
        );
        $stmt->bind_param("iid", $idSemaforo, $cargaVehicular, $velocidadProm);
        $stmt->execute();
        $idSimulacion = $stmt->insert_id;

        // Tipos de vehículos: 1 = Carro, 2 = Moto, 3 = Camión, 4 = Bus
        $tiposVehiculo = [1, 2, 3, 4];
        $vehiculosDistribuidos = [];

        // Distribuir carga vehicular
        $restante = $cargaVehicular;
        foreach ($tiposVehiculo as $index => $tipo) {
            if ($index === count($tiposVehiculo) - 1) {
                $cantidad = $restante; // Último tipo recibe el restante
            } else {
                $cantidad = rand(0, max(0, $restante)); // Evitar valores negativos
            }

            $vehiculosDistribuidos[$tipo] = $cantidad;
            $restante -= $cantidad;
        }

        // Insertar los vehículos en la BD
        foreach ($vehiculosDistribuidos as $tipo => $cantidad) {
            if ($cantidad > 0) { // Solo insertar si hay vehículos
                $stmtVehiculo = $this->conn->prepare(
                    "INSERT INTO SimulacionVehiculo (IdSimulacionFlujo, IdTipoVehiculo, Cantidad) 
                 VALUES (?, ?, ?)"
                );
                $stmtVehiculo->bind_param("iii", $idSimulacion, $tipo, $cantidad);
                $stmtVehiculo->execute();
            }
        }

        return true;
    }


    public function getAllSimulations()
    {
        $query = "SELECT sf.Id, sf.IdSemaforo, sf.CargaVehicular, sf.TipoGeneracion, sf.Fecha, 
                         GROUP_CONCAT(tv.Nombre, ': ', sv.Cantidad SEPARATOR ', ') AS DetalleVehiculos
                  FROM SimulacionFlujo sf
                  LEFT JOIN SimulacionVehiculo sv ON sf.Id = sv.IdSimulacionFlujo
                  LEFT JOIN TipoVehiculo tv ON sv.IdTipoVehiculo = tv.Id
                  GROUP BY sf.Id
                  ORDER BY sf.Fecha DESC";
        $result = $this->conn->query($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}
