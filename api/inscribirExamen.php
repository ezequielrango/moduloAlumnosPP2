<?php
session_start();
require '../vendor/autoload.php';
require_once '../.env.php';
require_once '../entities/user.php';
require_once '../controllers/examen.user.controller.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../index.php');
    exit;
}

$user = unserialize($_SESSION['user']);
$userId = $user->getId();
$user_name = $user->getNombre();
$last_name = $user->getApellido();
$email = $user->getEmail();
$phone = $user->getTelefono();
$dni = $user->getDni();
$nro_legajo = $user->getNumeroLegajo();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibe los datos del cliente (incluyendo el ID del examen)
    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->examenId)) {
        $examenId = $data->examenId;
        $materiaId = $data->materiaId;
        $fechaExamen = $data->fechaExamen;
        $currentDate = date("Y-m-d");
        $fechaInscripcion = $currentDate; // Fecha de inscripción igual a la fecha actual
        $alumno = $user_name + ' ' + $last_name;
        $constroller = new ExamenUserController();
        $resultado = $constroller->InscriptExam($userId,$materiaId, $fechaExamen,$examenId); // Implementa esta función según tu estructura de base de datos
        $credenciales = credenciales();
        header('Content-Type: application/json');
    
        $phpmailer = new PHPMailer\PHPMailer\PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = $credenciales['host'];
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = $credenciales['port'];
        $phpmailer->Username = $credenciales['usernameemail'];
        $phpmailer->Password = $credenciales['passwordemail'];
    
        $phpmailer->SetFrom($credenciales['email'], $credenciales['sender']);
        $phpmailer->AddAddress($credenciales['email'], $credenciales['receiver']);
        $phpmailer->Subject = 'Constancia de Inscripcion a Examen';
        $phpmailer->Body = "El día $fechaInscripcion el alumno: $alumno , legajo: $nro_legajo  y DNI: $dni, se inscribió satisfactoriamente al examen de la materia: $materiaId de la fecha: $fechaExamen ";
                // Enviar el correo electrónico
                try {
                    $phpmailer->send();
                    echo json_encode(["success" => true, "message" => "Inscripción exitosa. Correo electrónico enviado."]);
                } catch (Exception $e) {
                    echo json_encode(["failure" => false, "message" => "No se pudo enviar el correo electrónico. Error: " . $phpmailer->ErrorInfo]);
                }
        if ($resultado) {
            echo json_encode(["success" => true, "message" => "Inscripción exitosa"]);
        } else {
            echo json_encode(["failure" => false, "message" => "No se pudo inscribir al usuario en el examen"]);
        }
    } else {
        echo json_encode(["failure" => false, "message" => "ID de examen no proporcionado"]);
    }
} else {
    // Devuelve un error si la solicitud no es de tipo POST
    echo json_encode(["failure" => false, "message" => "Método no permitido"]);
}

?>
