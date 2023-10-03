<?php
require_once '../controllers/user.controller.php';

if (empty($_POST['email']) || empty($_POST['contraseña'])) {
    $redirigir = 'index.php?mensaje=Error: Falta un campo obligatorio';
} else {
    $cs = new UserController();
    $login = $cs->login($_POST['email'], $_POST['contraseña']);
    if ($login[0] === true) {
        $redirigir = 'home.php?mensaje=' . $login[1];
    } else {
        $redirigir = 'https://localhost/xampp/alumno/index.php?mensaje=' . $login[1];
    }
}
header('Location: '.$redirigir);