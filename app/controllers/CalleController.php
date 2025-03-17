<?php

use models\Calle;

require_once __DIR__ . '/../models/Calle.php';

class CalleController
{
    public function index()
    {
        $calleModel = new Calle();
        $calles = $calleModel->getAll();

        require_once __DIR__ . '/../views/calle/index.php';
    }

    public function crear()
    {
        $calleModel = new Calle();
        $sentidos = $calleModel->getSentidos();

        require_once __DIR__ . '/../views/calle/crear.php';
    }

    public function store()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nombre = $_POST['nombre'];
            $numeroCarriles = $_POST['numeroCarriles'];
            $idSentido = $_POST['idSentido'];

            $calleModel = new Calle();
            $calleModel->create($nombre, $numeroCarriles, $idSentido);

            header("Location: index.php?controller=Calle&action=index&success=1");
            exit();
        }
    }

    public function edit()
    {
        $id = $_GET['id'];
        $calleModel = new Calle();
        $calle = $calleModel->getById($id);
        $sentidos = $calleModel->getSentidos();

        require_once __DIR__ . '/../views/calle/editar.php';
    }

    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $numeroCarriles = $_POST['numeroCarriles'];
            $idSentido = $_POST['idSentido'];

            $calleModel = new Calle();
            $calleModel->update($id, $nombre, $numeroCarriles, $idSentido);

            header("Location: index.php?controller=Calle&action=index&success=1");
            exit();
        }
    }

    public function delete()
    {
        $id = $_GET['id'];
        $calleModel = new Calle();
        $calleModel->delete($id);

        header("Location: index.php?controller=Calle&action=index&success=1");
    }
}
