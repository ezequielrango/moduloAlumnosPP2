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
$alumno = '';
$dni = '';
$carrera = '';
$comision = '';
$legajo = '';



if (isset($_GET['download']) && $_GET['download'] === 'true'){
    $data = json_decode(file_get_contents("php://input"));


    $alumno =  $_GET['alumno'];
    $dni = $_GET['dni'];
    $carrera = $_GET['carrera'];
    $comision =  $_GET['comision'];
    $legajo =  $_GET['legajo'];
    $fecha = date("Y-m-d");

    // Generar el PDF para descarga

    require_once('../vendor/tecnickcom/tcpdf/tcpdf.php');

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Agregar una página al PDF
    $pdf->AddPage();

    // Agregar contenido al PDF utilizando las variables disponibles
    $html = "
       <h1>Constancia de Alumno Regular</h1>
       <p>Alumno: $alumno  </p>
       <p>DNI: $dni</p>
       <p>Legajo: $legajo</p>
       <p>Carrera: $carrera</p>
       <p>Comision: $comision</p>
       <p>Fecha emision: $fecha</p>
       ";

    $pdf->writeHTML($html, true, false, true, false, '');

    // Generar el archivo PDF
    $pdfFileName = 'constancia_regular.pdf';
    $pdf->Output($pdfFileName, 'D'); // Descargar el archivo PDF

    exit; // Importante: termina el script después de enviar el PDF para descarga

}else{
    $data = json_decode(file_get_contents("php://input"));

    $alumno = $data->alumno;
    $dni = $data->dni;
    $carrera = $data->carrera;
    $comision = $data->comision;
    $legajo = $data->legajo;
    $fecha = date("Y-m-d");

    $credenciales = credenciales();
    header('Content-Type: application/json');

    $phpmailer = new PHPMailer\PHPMailer\PHPMailer();
    $phpmailer->isSMTP();
    $phpmailer->Host = $credenciales['host'];
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = $credenciales['port'];
    $phpmailer->Username = $credenciales['usernameemail'];
    $phpmailer->Password = $credenciales['passwordemail'];
    $phpmailer->CharSet = 'UTF-8';
    $phpmailer->SetFrom($credenciales['email'], $credenciales['sender']);
    $phpmailer->AddAddress($credenciales['email'], $credenciales['receiver']);
    $phpmailer->Subject = 'Constancia de alumno regular';
    $phpmailer->Body = "El día $fecha el alumno $alumno, legajo: $legajo y DNI: $dni solicita la constancia de alumno regular APROBADA. Actualmente cursando la carrera de $carrera en la comision $comision. Terciario Urquiza. Le adjuntamos la constancia para que pueda descargarla y/o imprimirla ";

    // Intenta enviar el correo electrónico
    if ($phpmailer->Send()) {
        $respuesta = ['status' => 200, 'message' => 'Correo electrónico enviado con éxito'];
    } else {
        $respuesta = ['status' => 500, 'message' => 'Error al enviar el correo electrónico ' . $phpmailer->ErrorInfo];
    }

}

