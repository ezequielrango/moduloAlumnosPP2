<?php

abstract class User 
{
    protected $id;
    protected $nombre;
    protected $apellido;
    protected $email;
    protected $contraseña;
    protected $telefono;
    protected $dni;
    protected $role_id;
    protected $nro_legajo;

    public function __construct( $id, $nombre, $apellido, $email,$contraseña, $telefono, $dni, $role_id, $nro_legajo)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->contraseña = $contraseña;
        $this->telefono = $telefono;
        $this->dni = $dni;
        $this->role_id = $role_id;
        $this->nro_legajo = $nro_legajo;
    }

    public function getId() {return $this->id;}
    public function setId($id) {$this->id = $id;}
    public function getApellido() {return $this->apellido;}
    public function setApellido(){$this->apellido;}
    public function getNombre() {return $this->nombre;}
    public function setDatos($apellido){$this->apellido= $apellido;}
    public function getEmail() {return $this->email;}
    public function getTelefono() {return $this->telefono;}
    public function getDni() {return $this->dni;}
    public function getRoleId() {return $this->role_id;}
    public function getNumeroLegajo() {return $this->nro_legajo;}
    public function getPassword() {return $this->contraseña;}
    public function setNroLegajo($nombre, $apellido, $dni) {
        $nombreAbreviado = substr($nombre, 0, 1); 
        $apellidoAbreviado = substr($apellido, 0, 1);
        $nroLegajo = $nombreAbreviado . $apellidoAbreviado . $dni;
        $this->nro_legajo = $nroLegajo;
    }}
