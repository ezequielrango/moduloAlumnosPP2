<?php

class Asistencia
{
    public $id;
    public $fecha;
    public $estado;

    public function __construct($id, $fecha, $estado)
    {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->estado = $estado;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getEstado()
    {
        return $this->estado;
    }

}
