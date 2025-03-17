<?php

use models\Interseccion;

require_once __DIR__ . '/../models/Interseccion.php';

class InterseccionController
{
    public function index()
    {
        $interseccionModel = new Interseccion();
        $intersecciones = $interseccionModel->getAll();

        require_once __DIR__ . '/../views/interseccion/index.php';
    }

    public function create()
    {
        $interseccionModel = new Interseccion();
        $calles = $interseccionModel->getCalles();
        $avenidas = $interseccionModel->getAvenidas();

        require_once __DIR__ . '/../views/interseccion/create.php';
    }

    public function store()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $idCalle = $_POST['idCalle'];
            $idAvenida = $_POST['idAvenida'];
            $descripcion = $_POST['descripcion'];

            $interseccionModel = new Interseccion();
            $interseccionModel->create($idCalle, $idAvenida, $descripcion);

            header("Location: index.php?controller=Interseccion&action=index&success=1");
            exit();
        }
    }
}
