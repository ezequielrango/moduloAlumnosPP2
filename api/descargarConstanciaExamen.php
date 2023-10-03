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

if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $data = json_decode(file_get_contents("php://input"));

    $materia = $data->materia;
    $calificacion = $data->calificacion;
    $fecha = $data->fecha;
    $profesor = $data->profesor;
    $alumno = $data->alumno;

    require_once('../vendor/tecnickcom/tcpdf/tcpdf.php');

    
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Agregar una página al PDF
    $pdf->AddPage();
 
    // Agregar contenido al PDF
    $html = "
       <h1>Constancia de Examen</h1>
       <p>Alumno: </p>
       <p>Materia: $materia</p>
       <p>Calificación: $calificacion</p>
       <p>Fecha: $fecha</p>
       <p>Profesor: $profesor</p>
       ";
 
    $pdf->writeHTML($html, true, false, true, false, '');
 
    // Generar el archivo PDF
    $pdfFileName = 'constancia_examen.pdf';
    $pdf->Output($pdfFileName, 'D'); // Descargar el archivo PDF
 
    if ($pdf->Output($pdfFileName, 'D')) {
        $respuesta = ['status' => 200, 'message' => 'Descarga éxito'];
    } else {
        $respuesta = ['status' => 500, 'message' => 'Error al descargar '];
    }
}