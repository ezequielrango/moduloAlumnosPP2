<?php
require_once '../.env.php';
require_once '../models/Asistencia.php';

class AsistenciaRepository
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

    // Asistencias filtradas por usuario logueado y materia, anterior al dia de la fecha
    public function getAsistenciasByUserAndMateriaId($userId, $materiaId)
    {
        $q = "SELECT A.ID, A.FechaAsistencia, EA.Estado FROM asistencias AS A
        JOIN estadosasistencia AS EA ON A.EstadoAsistencia_ID = EA.ID
          WHERE A.Alumno_ID = ? AND A.Materia_ID = ?  AND A.FechaAsistencia <= CURDATE()
          ORDER BY A.FechaAsistencia DESC LIMIT 12  ";
        $query = self::$conexion->prepare($q);
        $query->bind_param("ii", $userId, $materiaId);

        if ($query->execute()) {
            $results = $query->get_result();
            $asistencias = [];

            while ($row = $results->fetch_assoc()) {
                $asistencias[] = new Asistencia(
                    $row['ID'],
                    $row['FechaAsistencia'],
                    $row['Estado'],
                );
            }
            return $asistencias;
        }
        return false;
    }
}
