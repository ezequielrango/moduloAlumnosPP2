<?php

abstract class Examen 
{
    protected $id;
    protected $alumnoId;
    protected $materiaId;
    protected $fecha;
    protected $resultado;
    protected $materia;
    protected $nombre_profesor;

    public function __construct($id, $alumnoId, $materiaId, $fecha, $resultado, $materia, $nombre_profesor)
    {
        $this->id = $id;
        $this->alumnoId = $alumnoId;
        $this->$materiaId = $materiaId;
        $this->fecha = $fecha;
        $this->resultado = $resultado;
        $this->materia = $materia;
        $this->nombre_profesor =  $nombre_profesor;
        ;
    }
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getAlumnoId() { return $this->alumnoId; }
    public function setAlumnoId($alumnoId) { $this->alumnoId = $alumnoId; }

    public function getFecha() { return $this->fecha; }
    public function setFecha($fecha) { $this->fecha = $fecha; }

    public function getResultado() { return $this->resultado; }
    public function setResultado($resultado) { $this->resultado = $resultado; }

    public function getMateria() { return $this->materia; }
    public function setMateria($materia) { $this->materia = $materia; }

    public function getProfesor() { return $this->nombre_profesor; }
    public function setProfesor($profesor) { $this->nombre_profesor = $profesor; }
}
