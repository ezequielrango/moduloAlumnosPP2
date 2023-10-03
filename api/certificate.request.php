<?php
require_once '../controllers/examen.user.controller.php';
require_once '../entities/user.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../index.php');
    exit;
}
$user = unserialize($_SESSION['user']);
$userId = $user->getId();


if (isset($_POST['materiaSelect'])) {

    $materia_seleccionada_constancia = intval($_POST['materiaSelect']);

    if ($materia_seleccionada_constancia > 0) {
        $examenController = new ExamenUserController();
        $ultimoExamen = $examenController->getLastExamByUserIdAndMateriaId($userId, $materia_seleccionada_constancia);

        if ($ultimoExamen) {
            $calificacion = $ultimoExamen[1]->getResultado();
            $fecha = $ultimoExamen[1]->getFecha();
            $profesor = $ultimoExamen[1]->getProfesor();

            $respuesta = [
                'calificacion' => $calificacion,
                'fecha' => $fecha,
                'profesor' => $profesor
            ];

            echo json_encode($respuesta);
        } else {
            echo json_encode(["error" => "No se encontró el examen"]);
        }
    } else {
        echo json_encode(["error" => "No se ha seleccionado una materia válida"]);
    }
} else {
    echo json_encode(["error" => "No se ha proporcionado una materia"]);
}
?>