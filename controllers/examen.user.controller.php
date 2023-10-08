<?php

require_once '../repositories/examen.repository.php';

class ExamenUserController
{
    protected $user = null;

    public function getExamsByUserIdAndMateriaId($userId, $materiaId)
    {
        $repo = new ExamenRepository();

        $user = $repo->getExamsByUserIdAndMateriaId($userId, $materiaId);
        if ($user === false) {
            return [ false, "Error al recuperar exámenes del usuario" ];
        } else {
            return [ true, "Examenes del usuario ok"];
        }
    }

    public function getLastExamByUserIdAndMateriaId($userId, $materiaId)
    {
        $repo = new ExamenRepository();

        $lastExamen = $repo->getLastExamByUserIdAndMateriaId($userId, $materiaId);
        if ($lastExamen === false) {
            return [ false, "Error al recuperar examen del usuario" ];
        } else {
            return [ true, $lastExamen, "Examenes del usuario ok"];
        }
    }

    public function getMateriasByUserId($userId)
    {
        $repo = new ExamenRepository();

        $materias = $repo->getMateriasByUserId($userId);

        return $materias;
    }



    public function getExamenesByUserIdAndMateriIdFuture($userId, $materiaId)
    {
        $repo = new ExamenRepository();
        $exams = $repo->getExamenesByUserIdAndMateriIdFuture($userId, $materiaId);
    
        if ($exams === false) {
            return [false, "Error al recuperar exámenes del usuario"];
        } else {
            return  $exams;
        }
    }

    public function InscriptExam($userId, $materiaId,$fechaExamen, $examId)
    {
        $repo = new ExamenRepository();
        $Inscription = $repo->InscriptExam($userId, $materiaId,$fechaExamen, $examId);
    
        if ($Inscription === false) {
            return [false, "Error al recuperar exámenes del usuario"];
        } else {
            return  $Inscription;
        }
    }
    
    

}

