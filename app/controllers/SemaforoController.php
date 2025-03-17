<?php

use models\Semaforo;

require_once __DIR__ . '/../models/Semaforo.php';

class SemaforoController
{
    public function index()
    {
        $semaforoModel = new Semaforo();
        $semaforos = $semaforoModel->getAll();

        require_once __DIR__ . '/../views/semaforo/index.php';
    }

    public function crear()
    {
        $semaforoModel = new Semaforo();
        $intersecciones = $semaforoModel->getIntersecciones();

        require_once __DIR__ . '/../views/semaforo/crear.php';
    }

    public function store()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $idInterseccion = $_POST['idInterseccion'];
            $tiempoVerde = $_POST['tiempoVerde'];
            $tiempoAmarillo = $_POST['tiempoAmarillo'];
            $tiempoRojo = $_POST['tiempoRojo'];
            $estadoActual = $_POST['estadoActual'];

            $semaforoModel = new Semaforo();

            if ($semaforoModel->create($idInterseccion, $tiempoVerde, $tiempoAmarillo, $tiempoRojo, $estadoActual)) {
                header("Location: index.php?controller=Semaforo&action=index&success=1");
            } else {
                header("Location: index.php?controller=Semaforo&action=crear&error=1");
            }
            exit();
        }
    }

    public function edit()
    {
        $id = $_GET['id'];
        $semaforoModel = new Semaforo();
        $semaforo = $semaforoModel->getById($id);
        $intersecciones = $semaforoModel->getIntersecciones();

        require_once __DIR__ . '/../views/semaforo/editar.php';
    }

    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST['id'];
            $idInterseccion = $_POST['idInterseccion'];
            $tiempoVerde = $_POST['tiempoVerde'];
            $tiempoAmarillo = $_POST['tiempoAmarillo'];
            $tiempoRojo = $_POST['tiempoRojo'];
            $estadoActual = $_POST['estadoActual'];

            $semaforoModel = new Semaforo();
            $semaforoModel->update($id, $idInterseccion, $tiempoVerde, $tiempoAmarillo, $tiempoRojo, $estadoActual);

            header("Location: index.php?controller=Semaforo&action=index&success=1");
            exit();
        }
    }

    public function delete()
    {
        $id = $_GET['id'];
        $semaforoModel = new Semaforo();
        $semaforoModel->delete($id);

        header("Location: index.php?controller=Semaforo&action=index&success=1");
    }
}
