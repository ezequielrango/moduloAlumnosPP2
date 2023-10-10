<?php
require_once '../controllers/asistencia.controller.php';
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
        $AsistenciaController = new AsistenciaController();
        $assistHistory = $AsistenciaController->getAsistenciasByUserAndMateriaId($userId, $materia_seleccionada_constancia);
        echo json_encode($assistHistory);
    } else {
        echo json_encode(["error" => "No se ha seleccionado una materia válida"]);
    }
} else {
    echo json_encode(["error" => "No se ha proporcionado una materia"]);
}
