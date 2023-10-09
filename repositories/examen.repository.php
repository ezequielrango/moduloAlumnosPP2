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

    public function InscriptExam($userId, $materiaId, $fechaExamen, $examId)
    {
        $currentDate = date("Y-m-d");
        $fechaInscripcion = $currentDate; // Fecha de inscripción igual a la fecha actual
    
        $q = "INSERT INTO inscripciones (Alumno_ID, Materia_ID, FechaInscripcion, TipoInscripcion_ID, Fecha, Examen_ID ) VALUES (?, ?, ?, ?, ?, ?)";
        $query = self::$conexion->prepare($q);
        
        // Debes definir un TipoInscripcion_ID apropiado para la inserción
        // Supongamos que TipoInscripcion_ID es 1 para una inscripción regular
        $tipoInscripcionId = 2;
        
        $query->bind_param("iisisi", $userId, $materiaId, $fechaInscripcion, $tipoInscripcionId, $fechaExamen, $examId);
    
        if ($query->execute()) {
            // Si la inserción fue exitosa, puedes retornar true o cualquier otro valor que desees
            return true;
        }
    
        return false;
    }


    
    public function getExamenesByUserFuture($userId)
    {
        $q = "SELECT  DISTINCT(EX.FechaExamen), EX.ID, I.FechaInscripcion, I.Alumno_ID, I.Materia_ID, EX.ResultadoExamen, M.NombreMateria AS Materia, CONCAT(U.Nombre, ' ', U.Apellido) AS NombreProfesor
        FROM inscripciones AS I
        JOIN materias AS M ON M.ID = I.Materia_ID 
        JOIN usuarios AS U ON M.Profesor_ID = U.ID
        JOIN examenes AS EX ON EX.ID = I.Examen_ID
        WHERE I.Alumno_ID = ? AND EX.FechaExamen >= CURDATE() AND EX.ResultadoExamen IS NULL;";
        $query = self::$conexion->prepare($q);
        $query->bind_param("i", $userId);
    
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
                    $row['NombreProfesor'],
                    $row['FechaInscripcion']
                );
            }
    
            return $exams;
        }
    
        return false;
    }
    

}
