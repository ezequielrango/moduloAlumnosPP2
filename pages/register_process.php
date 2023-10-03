
<?php
require_once '../controllers/user.controller.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userController = new UserController();
    $id=null;
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $dni = $_POST['dni'];
    $contraseña = $_POST['contraseña'];
    $role_id= 1;
    $nro_legajo = 1;
    $result = $userController->register($id, $nombre, $apellido, $email, $contraseña, $telefono, $dni, $role_id, $nro_legajo);
    
    if ($result[0] === true) {
        $redirigir = 'home.php?mensaje=' . $result[1];
    } else {
        $redirigir = 'register.php?mensaje=' . $result[1];
    }
    header('Location: ' . $redirigir);
}
?>
