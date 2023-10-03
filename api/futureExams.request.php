<?php
require_once '../controllers/examen.user.controller.php';
require_once '../entities/user.php';
require_once '../entities/FuturosExamenesPorMateria.php';
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
        $proximosExamenes = $examenController->getExamenesByUserIdAndMateriIdFuture($userId, $materia_seleccionada_constancia);
        
        if ($proximosExamenes !== null) { // Verifica que $proximosExamenes no sea null
            $examArray = [];
        
            foreach ($proximosExamenes as $examen) {
                // Accede a las propiedades protegidas a través de los métodos públicos
                $id= $examen->getId();
                $resultado= $examen->getResultado();
                $materia = $examen-> getMateria();
                $fecha = $examen-> getFecha();
                $profesor = $examen-> getProfesor();
                // Construye el array de examen
                $examArray[] = [
                    "id" => $id,
                    "resultado" => $resultado,
                    "materia" => $materia,
                    "fecha" => $fecha,
                    "profesor" => $profesor,
                    // Agrega otras propiedades aquí
                ];
            }
        
            $respuesta = ["success" => true, "exams" => $examArray, "message" => "Examenes del usuario ok"];
            echo json_encode($respuesta);
        } else {
            echo json_encode(["error" => "No se encontraron exámenes"]);
        }
        
    } else {
        echo json_encode(["error" => "No se ha seleccionado una materia válida"]);
    }
} else {
    echo json_encode(["error" => "No se ha proporcionado una materia"]);
}
?>