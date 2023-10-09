    <?php include('navbar.php'); ?>

    <?php
    if (isset($_SESSION['user'])) {
        $user = unserialize($_SESSION['user']);
        $userId = $user->getId();
        $user_name = $user->getNombre();
        $last_name = $user->getApellido();
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
        $materiasInscript = $examenController->getMateriasByUserId($userId);
        $dataAcademica = $userController->getCareerDataByUser($userId);
        $fechaInscripcion = $dataAcademica[1]['fecha_inscripcion'];
        $comision = $dataAcademica[1]['comision'];
        $carrera = $dataAcademica[1]['carrera'];
        $materiasAprobadas = $dataAcademica[1]['materias_aprobadas'];
        $materiasPendientes = $dataAcademica[1]['materias_pendientes'];

    } else {
        header('Location: index.php');
    }
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
            <div class="containerprofile">
                <h1 class="titleMyProfile">Mi perfil</h1>
                <div id='toastCasero' style="position:absolute; top:60px; border-radius:8px;color:white; font-weight:bold; font-size: 20px; right: 40px; z-index:9999; display: none; width:400px;height:70px; background-color:greenyellow">
                    <span id="spanToast" style="color:white; font-weight:bold; font-size: 36px; "></span>
                </div>
                <form id='formContainerProfileData'>
                    <div style="box-shadow: 5px 4px 13px 0px rgba(0,0,0,0.68);
-webkit-box-shadow: 5px 4px 13px 0px rgba(0,0,0,0.68);
-moz-box-shadow: 5px 4px 13px 0px rgba(0,0,0,0.68); padding:10px;" class="row">
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

            <div class="sidebar">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Calendario acadèmico
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table class="table">
                                <thead>
                                    <tr class="table-light">
                                        <th scope="col">Desde</th>
                                        <th scope="col">Hasta</th>
                                        <th scope="col">Actividad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-success">

                                        <td>12/10/23</td>
                                        <td>12/10/23</td>
                                        <td>Fin clases</td>
                                    </tr>
                                    <tr class="table-warning">

                                        <td>17/10/23</td>
                                        <td>06/11/23</td>
                                        <td>Parciales</td>
                                    </tr>
                                    <tr class="table-warning">

                                        <td>30/10/23</td>
                                        <td>07/11/23</td>
                                        <td>Entrega Notas Bedelia</td>
                                    </tr>
                                    <tr class="table-danger">

                                        <td>06/11/23</td>
                                        <td>10/11/23</td>
                                        <td>Ins. 1er Finales</td>

                                    </tr>
                                    <tr class="table-danger">

                                        <td>13/11/23</td>
                                        <td>34/10/23</td>
                                        <td>Primer llamado finales</td>
                                    </tr>
                                    </tr>
                                    <tr class="table-danger">

                                        <td>06/11/23</td>
                                        <td>10/11/23</td>
                                        <td>Ins. 2do llamado Finales</td>

                                    </tr>
                                    <tr class="table-danger">

                                        <td>13/11/23</td>
                                        <td>34/10/23</td>
                                        <td>Segundo llamado finales</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Parciales
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <img src="../assets/images/parciales.png" style="width: 200px; height:100px;">
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Documentaciòn a presentar
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong style="font-size: 12px;">
                                Partida de nacimiento legalizada.<br>
                                Fotocopia del documento nacional de identidad.<br>
                                Título de estudios secundarios o constancia actualizada de título en trámite.<br>
                                Certificado de buena salud. En caso de contar con algún problema de salud debe declararlo en dicho certificado.<br>
                                Abonar el monto correspondiente a Cooperador de la Escuela.
                            </strong>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Contacto
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong style="font-size: 12px;">BEDELIA: para trámites generales de los alumnos. <br>

                                Horario de atencón: de lunes a viernes de 19:30 a 21:30 primer piso.<br>

                                info@terciariourquiza.edu.ar<br>

                                SECRETARIA: para asistencia docente.<br>

                                Horario de atención: de lunes a viernes de 08:00 a 22:00 planta baja.<br>

                                escuelaurquizaofrecimientos@gmail.com<br>

                                secretara49urquiza@gmail.com</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div>


        

        

    <!-- INSCRIPCION EXAMEN -->



    <div class="modal fade  " id="modalInscripcionExamen" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="staticBackdropLabel">Inscribirse a examen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <label for="staticEmail"">Selecciona una materia</label>
    
                        <select id="materiaSelectExams" name='materiaSelectExams' class="form-select form-select-sm" aria-label=".form-select-sm example">
                            <option selected>Materia...</option>
                            <?php
                            foreach ($materias as $materia) {
                                echo '<option value="' . $materia->getId() . '">' . $materia->getNombre() . '</option>';
                            }
                            ?>
                            </select>
                            <div id="examenesDisponibles"></div> <!-- Contenedor para los exámenes disponibles -->
                </div>

                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button id='confirmBtnInscriptionExam' type="button" class="btn btn-primary">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- REVISAR ESTOS DIVS -->
    </div>
    </div>
    </div>
    </div>
    <!-- REVISAR ESTOS DIVS -->



    <!-- CONSTANCIA DE ALUMNO REGULAR -->



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



    <!-- CONSTANCIA DE EXAMEN -->




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