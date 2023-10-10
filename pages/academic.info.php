<?php include('navbar.php'); ?>
<?php
if (isset($_SESSION['user'])) {
  $user = unserialize($_SESSION['user']);
  $nro_legajo = $user->getNumeroLegajo();
  $userId = $user->getId();
  //Modal certificado examen
  require_once '../controllers/examen.user.controller.php';
  require_once '../controllers/asistencia.controller.php';
  $examenController = new ExamenUserController();
  $asistenciaController = new AsistenciaController();
  $materias = $examenController->getMateriasByUserId($userId);
  $examsHistory = $examenController->getAllExamsByUserId($userId);
} else {
  header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Información académica del alumno</title>
  <link rel="stylesheet" href="../assets/css/theme.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<body id='body' class="light-theme">
  <div class="bodyContainerAcademic">
    <h1 class="titleMyAcademic">Historial académico</h1>
    <div id='toastCasero' style="position:absolute; top:60px; border-radius:8px;color:white; font-weight:bold; font-size: 20px; right: 40px; z-index:9999; display: none; width:400px;height:70px; background-color:greenyellow">
      <span id="spanToast" style="color:white; font-weight:bold; font-size: 36px; "></span>
    </div>
    <div class="dataAndExams">
      <div class="lagartixaBB">
        <h2>Tu Información</h2>
        <h5 id='spanbadge' class="badgeAcademic"><span id='spanbadge' class="badge bg-primary">Comisión: 3.2 </span></h5> <br>
        <h5 id='spanbadge' class="badgeAcademic"><span id='spanbadge' class="badge bg-primary"> <?= $nro_legajo; ?> </span></h5>
        <h5 id='spanbadge' class="badgeAcademic"><span id='spanbadge' class="badge bg-primary"> Tecnicatura en Desarrollo de Software </span></h5>
        <h5 id='spanbadge' class="badgeAcademic"><span id='spanbadge' class="badge bg-primary">Total materias: 30</span></h5>
        <h5 id='spanbadge' class="badgeAcademic"><span id='spanbadge' class="badge bg-primary">Materias aprobadas: 25 </span></h5>
        <h5 id='spanbadge' class="badgeAcademic"><span id='spanbadge' class="badge bg-primary">Materias pendientes: 5 </span></h5>
      </div>

      <div class="examsContainer">
        <h2>Tus exámenes</h2>
        <table class="table">
          <thead>
            <tr class="table-light">
              <th scope="col">Materia</th>
              <th scope="col">Fecha</th>
              <th scope="col">Profesor</th>
              <th scope="col">Resultado</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($examsHistory as $exam) { ?>
              <tr class="<?php echo ($exam->getResultado() >= 6) ? 'table-success' : 'table-danger'; ?>">
                <td style="font-size: 12px;"><?= $exam->getMateria(); ?></td>
                <td style="font-size: 12px;"><?= $exam->getFecha(); ?></td>
                <td style="font-size: 12px;"><?= $exam->getProfesor(); ?></td>
                <td style="font-size: 12px;"><?= $exam->getResultado(); ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>

      </div>

      <div class="asistenciasContainer">
        <div style="display: flex; justify-content:space-around;">
          <h2 style="margin-right: 5px;">Asistencias</h2>
          <select id="materiaSelectAssist" name='materiaSelect' class="form-select form-select-sm" aria-label=".form-select-sm example">
              <option selected>Materia...</option>
              <?php
              foreach ($materias as $materia) {
                echo '<option value="' . $materia->getId() . '">' . $materia->getNombre() . '</option>';
              }
              ?>
              </select>
        </div>


        <table id='asistenciasTable' class="table">
          <thead>
            <tr class="table-light">
              <th id='asistenciasTableTh' scope="col">Fecha</th>
              <th id='asistenciasTableTh' scope="col">Estado</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
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


  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="../js/fetch/certificateRequest.js"></script>
  <script src="../js/fetch/assistRequest.js"></script>
  <script src="../js/front/changeTheme.js"></script>
  <script src="../js/front/openModalCertificates.js"></script>
</body>

</html>