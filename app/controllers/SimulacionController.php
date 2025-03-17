<?php

use models\Simulacion;

require_once __DIR__ . '/../models/Simulacion.php';
require_once __DIR__ . '/../models/Interseccion.php';

class SimulacionController
{
    public function index()
    {
        $simulacion = new Simulacion();
        $simulaciones = $simulacion->getAllSimulations();

        require_once __DIR__ . '/../views/simulacion/index.php';
    }

    public function grafica(){
        require_once  __DIR__ . '/../views/simulacion/grafica.php';
    }

    public function cargarArchivo()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["archivo"])) {
            $archivoTmp = $_FILES["archivo"]["tmp_name"];
            $idSemaforo = $_POST["idSemaforo"];

            $simulacion = new Simulacion();
            if ($simulacion->loadStreamFromFile($archivoTmp, $idSemaforo)) {
                header("Location: index.php?controller=Simulacion&action=index&success=1");
            } else {
                header("Location: index.php?controller=Simulacion&action=index&error=1");
            }
        }
    }

    public function generarAleatorio()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $idSemaforo = $_POST["idSemaforo"];

            $simulacion = new Simulacion();
            if ($simulacion->generateRandomFlow($idSemaforo)) {
                header("Location: index.php?controller=Simulacion&action=index&success=2");
            } else {
                header("Location: index.php?controller=Simulacion&action=index&error=2");
            }
        }
    }

    public function interseccion()
    {
        $interseccionModel = new \models\Interseccion();
        $intersecciones = $interseccionModel->getAll();
        require_once __DIR__ . '/../views/simulacion/interseccion.php';
    }

}
