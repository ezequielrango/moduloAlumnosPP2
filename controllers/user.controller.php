<?php

require_once '../repositories/user.repository.php';
require_once '../entities/user.php';

class UserController
{
    protected $user = null;

    public function login($email, $clave)
    {
        $repo = new UserRepository();

        $user = $repo->login($email, $clave);
        if ($user === false) {
            return [ false, "Error de credenciales" ];
        } else {
            session_start();
            $_SESSION['user'] = serialize($user);
            return [ true, "user correctamente autenticado"];
        }
    }

    public function register($id=null,$nombre, $apellido, $email, $contraseña, $telefono, $dni , $role_id, $nro_legajo)
    {

        $repo = new UserRepository();
        $user = new Alumno($id=null,$nombre, $apellido, $email, $contraseña, $telefono, $dni , $role_id, $nro_legajo );
        // var_dump($user->getRoleId());
        // die(1);
        $id = $repo->save($user, $contraseña);
        if ($id === false) {
            return [false, "Error al crear el user"];
        } else {
            $user->setId($id);
            session_start();
            $_SESSION['user'] = serialize($user);
            return [true, "user creado correctamente"];
        }
    }

    public function getCareerDataByUser($userId)
    {
        $repo = new UserRepository();
       $data = $repo->getCareerDataByUser($userId);
        if ($data === false) {
            return [false, "Error al recuperar la información académica del usuario"];
        } else {
            return [true, $data, "Datos recuperados correctamente"];
        }
    }


}
