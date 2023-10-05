<?php
require_once '../entities/user.php';
session_start();
if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    $user_name = $user->getNombre();
    $last_name = $user->getApellido();
    $userId = $user->getId();

        // var_dump($user->getId());
    // die();
    $email = $user->getEmail();
    $phone = $user->getTelefono();
    $dni = $user->getDni();
    $nro_legajo = $user->getNumeroLegajo();
    $password =  $user->getPassword();

    //Modal certificado examen
    require_once '../controllers/examen.user.controller.php';
    require_once '../controllers/user.controller.php';


    $examenController = new ExamenUserController();
    $userController = new UserController();
    $materias = $examenController->getMateriasByUserId($userId);
    $dataAcademica = $userController->getCareerDataByUser($userId);
// Verificar si $dataAcademica es un arreglo válido
if (is_array($dataAcademica) && count($dataAcademica) > 0) {
    $fechaInscripcion = $dataAcademica[1]['fecha_inscripcion'] ?? '';
    $comision = $dataAcademica[1]['comision'] ?? '';
    $carrera = $dataAcademica[1]['carrera'] ?? '';
    $materiasAprobadas = $dataAcademica[1]['materias_aprobadas'] ?? '';
    $materiasPendientes = $dataAcademica[1]['materias_pendientes'] ?? '';
} else {
    // No se encontraron datos académicos para el usuario, asignar valores vacíos o manejar el caso de error aquí
    $fechaInscripcion = '';
    $comision = '';
    $carrera = '';
    $materiasAprobadas = '';
    $materiasPendientes = '';
}
  } else {
    header('Location: index.php');
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script src="../js/front/avatar.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../assets/css/avatar.css">
</head>

<body id='body' class="light-theme">

    <nav id='nav' class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <!-- <a class="navbar-brand" href="home.php"><span class="icon"><i class='bx bx-user'></i></span>Inicio</a> -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">

                        <a id='homeLink' class="nav-link active" aria-current="page" href="home.php"> <span class="iconHome"><i class='bx bx-home-alt'></i></span></a>
                    </li>
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="icon"><i class='bx bx-user'></i></span> Mi perfil
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="profile.php">Mis datos personales</a></li>
                            <li><a class="dropdown-item" href="academic.info.php">Información académica</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a id='proximosExamenes' href="prox.exams.php" class="nav-link" href="#"> <span class="icon"><i class='bx bx-task'></i></span>Próximos exámenes</a>
                    </li>
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="icon"><i class='bx bx-list-check'></i></span> Inscripciones
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" id='inscripcionExamenLink' href="#">Mesa de examen</a></li>
                            <li><a class="dropdown-item" href="#">Materia</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="icon"><i class='bx bx-news'></i></span> Solicitar certificados
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#" id="constanciaExamenLink">Constancia de examen</a></li>
                            <li><a class="dropdown-item" href="#" id="alumnoRegularLink">Alumno regular</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <span class="icon"><i class='bx bx-adjust'></i></span>
            <div class="form-check form-switch">
                <input class="form-check-input" name='theme' type="checkbox" id="themeSwitch">
            </div>

            <a href="logout.php" class="btn btn-secondary btn-sm">Cerrar sesión</a>
            <img class="round" id='avatar' style="margin-left: 30px; margin-right:20px;" width="60" height="60" avatar="<?= $user_name . ' ' . $last_name; ?>">
    </nav>



</body>

</html>