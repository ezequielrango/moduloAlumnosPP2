<?php
session_start();
require '../vendor/autoload.php';
require_once '../.env.php';
require_once '../entities/user.php';

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

// Inicializar variables
$materia = '';
$calificacion = '';
$fecha = '';
$profesor = '';


if (isset($_GET['download']) && $_GET['download'] === 'true'){
    // Generar el PDF para descarga
    $materia = $_GET['materia'];
    $calificacion = $_GET['calificacion'];
    $fecha = $_GET['fecha'];
    $profesor = $_GET['profesor'];
    $alumno = $_GET['alumno'];

        require_once('../vendor/tecnickcom/tcpdf/tcpdf.php');

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Agregar una página al PDF
    $pdf->AddPage();

    // Agregar contenido al PDF utilizando las variables disponibles
    $html = "
       <h1>Constancia de Examen</h1>
       <p>Alumno: $user_name . $last_name  </p>
       <p>DNI: $dni</p>
       <p>LEGAJO: $nro_legajo</p>
       <p>Materia: $materia</p>
       <p>Calificación: $calificacion</p>
       <p>Fecha: $fecha</p>
       <p>Profesor: $profesor</p>
       ";

    $pdf->writeHTML($html, true, false, true, false, '');

    // Generar el archivo PDF
    $pdfFileName = 'constancia_examen.pdf';
    $pdf->Output($pdfFileName, 'D'); // Descargar el archivo PDF

    exit; // Importante: termina el script después de enviar el PDF para descarga

}else { 
    // Obtener datos del cuerpo de la solicitud POST
    $data = json_decode(file_get_contents("php://input"));

    $materia = $data->materia;
    $calificacion = $data->calificacion;
    $fecha = $data->fecha;
    $profesor = $data->profesor;
    $alumno = $data->alumno;
// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     $data = json_decode(file_get_contents("php://input"));

//     $materia = $data->materia;
//     $calificacion = $data->calificacion;
//     $fecha = $data->fecha;
//     $profesor = $data->profesor;
//     $alumno = $data->alumno;

    // Si la solicitud es un POST, enviar el correo electrónico
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
    $phpmailer->Subject = 'Constancia de examen';
    $phpmailer->Body = "El dia $fecha el alumno $user_name $last_name legajo: $nro_legajo rindio: Materia: $materia, profesor: $profesor, calificacion: $calificacion";

    // Intenta enviar el correo electrónico
    if ($phpmailer->Send()) {
        $respuesta = ['status' => 200, 'message' => 'Correo electrónico enviado con éxito'];
    } else {
        $respuesta = ['status' => 500, 'message' => 'Error al enviar el correo electrónico ' . $phpmailer->ErrorInfo];
    }
}
//     echo json_encode($respuesta);
// } else {
//     $data = json_decode(file_get_contents("php://input"));

//     $materia = $data->materia;
//     $calificacion = $data->calificacion;
//     $fecha = $data->fecha;
//     $profesor = $data->profesor;
//     $alumno = $data->alumno;
//     // Si la solicitud no es un POST, mostrar el mensaje de error o realizar alguna otra acción
//     // También puedes generar el PDF aquí con las variables disponibles
//     require_once('../vendor/tecnickcom/tcpdf/tcpdf.php');

//     $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//     // Agregar una página al PDF
//     $pdf->AddPage();

//     // Agregar contenido al PDF utilizando las variables disponibles
//     $html = "
//        <h1>Constancia de Examen</h1>
//        <p>Alumno: </p>
//        <p>Materia: $materia</p>
//        <p>Calificación: $calificacion</p>
//        <p>Fecha: $fecha</p>
//        <p>Profesor: $profesor</p>
//        ";

//     $pdf->writeHTML($html, true, false, true, false, '');

//     // Generar el archivo PDF
//     $pdfFileName = 'constancia_examen.pdf';
//     $pdf->Output($pdfFileName, 'D'); // Descargar el archivo PDF

//     exit; // Importante: termina el script después de enviar el PDF para descarga
// }
// 
