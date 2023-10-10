<?php

require_once '../repositories/asistencia.repository.php';

class AsistenciaController
{
    protected $user = null;

    public function getAsistenciasByUserAndMateriaId($userId, $materiaId)
    {
        $repo = new AsistenciaRepository();
        $asistencias  = $repo->getAsistenciasByUserAndMateriaId($userId, $materiaId);
        if ($asistencias  === false) {
            return [ false, "Error al recuperar exámenes del usuario" ];
        } else {
            return $asistencias;
        }
    }

}

