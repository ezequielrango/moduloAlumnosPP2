<?php
require_once '../models/Examen.php';

class FuturosExamenesPorMateria extends Examen
{
    public function __construct($id, $alumnoId, $materiaId, $fecha, $resultado, $materia, $nombre_profesor)
    {
        parent::__construct($id, $alumnoId, $materiaId, $fecha, $resultado, $materia, $nombre_profesor);

    }
}
