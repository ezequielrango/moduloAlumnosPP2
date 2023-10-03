<?php
require_once '../models/User.php';

class Alumno extends User
{
    public function __construct($id, $nombre, $apellido, $email, $contraseña, $telefono, $dni, $role_id, $nro_legajo)
    {
        parent::__construct($id,$nombre, $apellido, $email,$contraseña, $telefono, $dni, $role_id, $nro_legajo );
    
    }

}
