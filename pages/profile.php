<?php include('navbar.php'); ?>

<?php
// if (isset($_SESSION['user'])) {
//     $user = unserialize($_SESSION['user']);
//     $userId = $user->getId();
//     $user_name = $user->getNombre();
//     $last_name = $user->getApellido();
//     $email = $user->getEmail();
//     $phone = $user->getTelefono();
//     $dni = $user->getDni();
//     $nro_legajo = $user->getNumeroLegajo();
//     $password =  $user->getPassword();

//     //Modal certificado examen
//     require_once '../controllers/examen.user.controller.php';
//     require_once '../controllers/user.controller.php';


//     $examenController = new ExamenUserController();
//     $userController = new UserController();
//     $materias = $examenController->getMateriasByUserId($userId);
//     $dataAcademica = $userController->getCareerDataByUser($userId);
//     $fechaInscripcion = $dataAcademica[1]['fecha_inscripcion'];
//     $comision = $dataAcademica[1]['comision'];
//     $carrera = $dataAcademica[1]['carrera'];
//     $materiasAprobadas = $dataAcademica[1]['materias_aprobadas'];
//     $materiasPendientes = $dataAcademica[1]['materias_pendientes'];

// } else {
//     header('Location: index.php');
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/theme.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Mi perfil</title>
</head>

<body id='body' class="light-theme">
    <div class="bodyContainerProfile">
        <h1 class="titleMyProfile">Mi perfil</h1>
        <div id='toastCasero' style="position:absolute; top:60px; border-radius:8px;color:white; font-weight:bold; font-size: 20px; right: 40px; z-index:9999; display: none; width:400px;height:70px; background-color:greenyellow">
            <span id="spanToast" style="color:white; font-weight:bold; font-size: 36px; "></span>
        </div>
        <form id='formContainerProfileData'>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <div id='containerChangePass'>
                            <label id='labelProfile' for="staticEmail">Contraseña</label>
                            <button type="button" id="changePass" class="btn btn-warning">
                                <spanv class="icon"><i class='bx bx-sync'></i></spanv>
                            </button>
                        </div>
                        <input class="form-control form-control-sm" type="password" value="<?= $password; ?>" aria-label="Password" readonly>

                    </div>
                    <div class="mb-3">
                        <label id='labelProfile' for="staticEmail">Nombre</label>
                        <input class="form-control form-control-sm" type="text" value="<?= $user_name; ?>" aria-label="Nombre" readonly>
                    </div>
                    <div class="mb-3">
                        <label id='labelProfile' for="staticEmail">Apellido</label>
                        <input class="form-control form-control-sm" type="text" value="<?= $last_name; ?>" aria-label="Apellido" readonly>
                    </div>
                    <div class="mb-3">
                        <label id='labelProfile' for="staticEmail">Email</label>
                        <input class="form-control form-control-sm" type="text" value="<?= $email; ?>" aria-label="Email" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label id='labelProfile' for="staticEmail">Teléfono</label>
                        <input class="form-control form-control-sm" type="text" value="<?= $phone; ?>" aria-label="Teléfono" readonly>
                    </div>
                    <div class="mb-3">
                        <label id='labelProfile' for="staticEmail">DNI</label>
                        <input class="form-control form-control-sm" type="text" value="<?= $dni; ?>" aria-label="DNI" readonly>
                    </div>
                    <div class="mb-3">
                        <label id='labelProfile' for="staticEmail">Legajo</label>
                        <input class="form-control form-control-sm" type="text" value="<?= $nro_legajo; ?>" aria-label="Legajo" readonly>
                    </div>
                    <div class="mb-3">
                        <button id='confirmChange' type="submit" class="btn btn-primary" style="display: none;">Confirmar cambio de contraseña</button>
                    </div>

                </div>
            </div>


            <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
        </form>

    </div>




    <div class="modal fade  " id="modalAlumnoRegular" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="staticBackdropLabel">Constancia de alumno regular</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">DNI</th>
                                <th scope="col">Carrera</th>
                                <th scope="col">Comisión</th>
                                <th scope="col">Legajo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> <input id='alumnoInputRegular' class="form-control form-control-sm" name="alumnoRegular" type="text" value="<?= $user_name . ' ' . $last_name; ?>" aria-label="10" readonly>
                                </td>
                                <td> <input id='dniInputRegular' class="form-control form-control-sm" name="dniRegular" type="text" value="<?= $dni ?>" aria-label="10" readonly>
                                </td>
                                <td><input id='carreraInputRegular' class="form-control form-control-sm" name="carreraRegular" type="text" value="<?= $carrera; ?>" aria-label="10" readonly></td>
                                <td><input id='comisionInputRegular' class="form-control form-control-sm" name="comisionRegular" type="text" value="<?= $comision; ?>" aria-label="10" readonly></td>
                                <td> <input id='legajoInputRegular' class="form-control form-control-sm" name="legajoRegular" type="text" value="<?= $nro_legajo; ?>" aria-label="10" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <input id='radioDownload' class="form-check-input" type="radio" name="download" id="flexRadioDefault2">
                    <label class="form-check-label" for="flexRadioDefault2">
                        Descargar
                    </label>
                    <input id='radioEmail' class="form-check-input" type="radio" name="download" id="flexRadioDefault2" checked>
                    <label class="form-check-label" for="flexRadioDefault2">
                        Enviar a tu email
                    </label>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button id='confirmBtnRegular' type="button" class="btn btn-primary">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade  " id="modalConstanciaExamen" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="staticBackdropLabel">Constancia de examen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <label for="staticEmail"">Selecciona una materia</label>
    
                        <select id="materiaSelect" name='materiaSelect' class="form-select form-select-sm" aria-label=".form-select-sm example">
                            <option selected>Materia...</option>
                            <?php
                            foreach ($materias as $materia) {
                                echo '<option value="' . $materia->getId() . '">' . $materia->getNombre() . '</option>';
                            }
                            ?>
                            </select>

                            <div class="mb-3 row">
                                <label for="staticEmail"">Calificación</label>
                            <div class=" col-sm-10">
                                    <input id='calificacion' name="calificacion" class="form-control form-control-sm" type="text" value="" aria-label="10" readonly>
                            </div>
                            <label for="staticEmail"">Fecha</label>
                            <div class=" col-sm-10">
                                <input id='fecha' name="fecha" class="form-control form-control-sm" type="text" value="" aria-label="10" readonly>
                </div>
                <label for="staticEmail"">Profesor</label>
                            <div class=" col-sm-10">
                    <input id='profesor' name="profesor" class="form-control form-control-sm" type="text" value="" aria-label="10" readonly>
            </div>
            <label for="staticEmail"">Alumno</label>
                        <div class=" col-sm-10">
                <input id='alumnoInput' class="form-control form-control-sm" name="alumno" type="text" value="<?= $user_name . ' ' . $last_name; ?>" aria-label="10" readonly>
        </div>
    </div>
    <input id='radioDownload1' class="form-check-input" type="radio" name="download" id="flexRadioDefault2">
    <label class="form-check-label" for="flexRadioDefault2">
        Descargar
    </label>
    <input id='radioEmail1' class="form-check-input" type="radio" name="download" id="flexRadioDefault2" checked>
    <label class="form-check-label" for="flexRadioDefault2">
        Enviar a tu email
    </label>

    </form>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button id='confirmBtn' type="button" class="btn btn-primary">Confirmar</button>
    </div>
    </div>
    </div>
    </div>




    <script>
        document.getElementById("changePass").addEventListener("click", function() {
            var btn = document.getElementById("confirmChange")
            var campos = document.querySelectorAll("input.form-control-sm");
            campos.forEach(function(campo) {
                if (campo.getAttribute("aria-label") === "Password") {
                    if (!campo.getAttribute("readonly")) {
                        campo.setAttribute("readonly", "readonly");
                        btn.style.display = 'none';
                        return;
                    }
                    campo.removeAttribute("readonly");
                    btn.style.display = 'flex';
                }
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="../js/fetch/certificateRequest.js"></script>
    <script src="../js/front/changeTheme.js"></script>
    <script src="../js/front/openModalCertificates.js"></script>


</body>

</html>