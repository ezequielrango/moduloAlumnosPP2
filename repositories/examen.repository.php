<?php
require_once '../.env.php';
require_once '../models/Examen.php';
require_once '../models/Materia.php';
require_once '../entities/UltimoExamenPorMateria.php';
require_once '../entities/FuturosExamenesPorMateria.php';


class ExamenRepository
{
    private static $conexion = null;

    public function __construct()
    {
        if (is_null(self::$conexion)) {
            $credenciales = credenciales();
            self::$conexion = new mysqli(
                $credenciales['servidor'],
                $credenciales['usuario'],
                $credenciales['clave'],
                $credenciales['base_de_datos'],
            );
            if (self::$conexion->connect_error) {
                $error = 'Error de conexión: ' . self::$conexion->connect_error;
                self::$conexion = null;
                die($error);
            }
            self::$conexion->set_charset('utf8');
        }
    }

// Examenes del usuario filtrado por materia y fecha anterior al día de hoy con nombre y apellido del profesor
public function getExamsByUserIdAndMateriaId($userId, $materiaId)
{
    $currentDate = date("Y-m-d");
    $q = "SELECT examenes.ID, Alumno_ID, Materia_ID, FechaExamen, ResultadoExamen, M.NombreMateria AS Materia, CONCAT(U.Nombre, ' ', U.Apellido) AS NombreProfesor
          FROM examenes 
          JOIN materias AS M ON examenes.Materia_ID = M.ID 
          JOIN usuarios AS U ON M.Profesor_ID = U.ID
          WHERE Alumno_ID = ? AND Materia_ID = ?  AND FechaExamen <= CURDATE()";
    $query = self::$conexion->prepare($q);
    $query->bind_param("ii", $userId, $materiaId);

    if ($query->execute()) {
        $results = $query->get_result();
        $exams = [];

        while ($row = $results->fetch_assoc()) {
            $exams[] = new Examen(
                $row['ID'],
                $row['Alumno_ID'],
                $row['Materia_ID'],
                $row['FechaExamen'],
                $row['ResultadoExamen'],
                $row['Materia'],
                $row['NombreProfesor']
            );
        }

        return $exams;
    }

    return false;
}

// Ultimo examen por materia y fecha anterior al día de hoy con nombre y apellido del profesor
public function getLastExamByUserIdAndMateriaId($userId, $materiaId)
{
    $currentDate = date("Y-m-d");
    $q = "SELECT examenes.ID, Alumno_ID, Materia_ID, FechaExamen, ResultadoExamen, M.NombreMateria AS Materia, CONCAT(U.Nombre, ' ', U.Apellido) AS NombreProfesor
          FROM examenes 
          JOIN materias AS M ON examenes.Materia_ID = M.ID 
          JOIN usuarios AS U ON M.Profesor_ID = U.ID
          WHERE Alumno_ID = ? AND Materia_ID = ? AND FechaExamen <= ?
          ORDER BY FechaExamen DESC
          LIMIT 1";
    $query = self::$conexion->prepare($q);
    $query->bind_param("iis", $userId, $materiaId, $currentDate);

    if ($query->execute()) {
        $results = $query->get_result();

        if ($row = $results->fetch_assoc()) {
            return new UltimoExamen(
                $row['ID'],
                $row['Alumno_ID'],
                $row['Materia_ID'],
                $row['FechaExamen'],
                $row['ResultadoExamen'],
                $row['Materia'],
                $row['NombreProfesor']
            );
        }
    }

    return false;
}


// Las que fueron rendidas por el usuario y fecha anterior al día de hoy
// Las materias que fueron rendidas por el usuario y fecha anterior al día de hoy
public function getMateriasByUserId($userId)
{
    $currentDate = date("Y-m-d");
    $q = "SELECT DISTINCT M.ID, M.NombreMateria, M.Profesor_ID, CONCAT(U.Nombre, ' ', U.Apellido) AS NombreProfesor
          FROM examenes AS E
          JOIN materias AS M ON E.Materia_ID = M.ID
          JOIN usuarios AS U ON M.Profesor_ID = U.ID
          WHERE E.Alumno_ID = ? AND E.FechaExamen <= ?";
    $query = self::$conexion->prepare($q);
    $query->bind_param("is", $userId, $currentDate);

    if ($query->execute()) {
        $results = $query->get_result();
        $materias = [];

        while ($row = $results->fetch_assoc()) {
            $materia = new Materia(
                $row['ID'],
                $row['NombreMateria'],
                $row['Profesor_ID'],
                $row['NombreProfesor']
            );
            $materias[] = $materia;
        }

        return $materias;
    }

    return false;
    
}

public function getExamenesByUserIdAndMateriIdFuture($userId, $materiaId)
    {
        $currentDate = date("Y-m-d");
        $q = "SELECT examenes.ID, Alumno_ID, Materia_ID, FechaExamen, ResultadoExamen, M.NombreMateria AS Materia, CONCAT(U.Nombre, ' ', U.Apellido) AS NombreProfesor
              FROM examenes 
              JOIN materias AS M ON examenes.Materia_ID = M.ID 
              JOIN usuarios AS U ON M.Profesor_ID = U.ID
              WHERE Alumno_ID = ? AND Materia_ID = ? AND FechaExamen >= CURDATE() AND ResultadoExamen IS NULL";
        $query = self::$conexion->prepare($q);
        $query->bind_param("ii", $userId, $materiaId);
    
        if ($query->execute()) {
            $results = $query->get_result();
            $exams = [];
    
            while ($row = $results->fetch_assoc()) {
                $exams[] = new FuturosExamenesPorMateria(
                    $row['ID'],
                    $row['Alumno_ID'],
                    $row['Materia_ID'],
                    $row['FechaExamen'],
                    $row['ResultadoExamen'],
                    $row['Materia'],
                    $row['NombreProfesor']
                );
            }
    
            return $exams;
        }
    
        return false;
    }

}
