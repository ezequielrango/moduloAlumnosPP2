<?php

class Materia
{
    private $id;
    private $nombre;
    private $profesorId;
    private $nombreProfesor;

    public function __construct($id, $nombre, $profesorId, $nombreProfesor)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->profesorId = $profesorId;
        $this->nombreProfesor = $nombreProfesor;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getProfesorId()
    {
        return $this->profesorId;
    }

    public function getNombreProfesor()
    {
        return $this->nombreProfesor;
    }
}
