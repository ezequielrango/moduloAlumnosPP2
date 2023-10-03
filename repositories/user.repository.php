<?php
require_once '../.env.php';
require_once '../entities/user.php';

class UserRepository
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

    public function login($email, $contraseña)
    {
        $q = "SELECT ID, Nombre, Apellido, Email, Contraseña, Telefono, DNI, Rol_ID, NroLegajo FROM usuarios WHERE Email = ?";
        $query = self::$conexion->prepare($q);
        $query->bind_param("s", $email);
        if ($query->execute()) {
            $query->bind_result($id, $nombre, $apellido, $email, $contraseña_encriptada, $telefono, $dni, $role_id, $nro_legajo);
            if ($query->fetch()) {
                if (password_verify($contraseña, $contraseña_encriptada)) {
                    return new Alumno($id, $nombre, $apellido, $email, $contraseña, $telefono, $dni, $role_id, $nro_legajo);
                }
            }
        }
        return false;
    }
    

    public function save(Alumno $usuario, $clave)
    {

        //    var_dump($usuario->getEmail());
        //    die(1);
        $q = "INSERT INTO usuarios (Nombre, Apellido, Email, Contraseña, Telefono, DNI, Rol_ID, NroLegajo) ";
        $q .= "VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $query = self::$conexion->prepare($q);
        $dni = $usuario->getDni();
        $nombre = $usuario->getNombre();

        $apellido = $usuario->getApellido();
        $email = $usuario->getEmail();
        $telefono = $usuario->getTelefono();
        $role_id = $usuario->getRoleId();
        $usuario->setNroLegajo($nombre, $apellido, $dni);
        $nro_legajo = $usuario->getNumeroLegajo();
        $clave_encriptada = password_hash($clave, PASSWORD_DEFAULT);

        $query->bind_param(
            "ssssiiis",
            $nombre,
            $apellido,
            $email,
            $clave_encriptada,
            $telefono,
            $dni,
            $role_id,
            $nro_legajo,
        );
        // var_dump($role_id);
        // die(1);
        if ($query->execute()) {

            return self::$conexion->insert_id;
        } else {
            //         var_dump($query->error);
            // die(1);
            echo "Error en la consulta: " . $query->error;
            return false;
        }
    }

    public function getCareerDataByUser($userId) {
        $q = "SELECT  u.ID, CONCAT(u.Nombre, ' ' ,u.Apellido) AS alumno, ic.FechaInscripcion, ic.MateriasAprobadas, ic.MateriasPendientes, ca.NombreCarrera AS carrera, com.Nombre AS comision FROM inscripcionescarrera AS ic
        JOIN carreras AS ca ON ca.ID = ic.Carrera_ID
        JOIN comisiones AS com ON com.ID = ca.ID
        JOIN usuarios AS u ON u.ID = ic.Usuario_ID
        WHERE ic.Usuario_ID = ?";
    
        try {
            $query = self::$conexion->prepare($q);
            $query->bind_param("i", $userId);
    
            if ($query->execute()) {
                $results = $query->get_result();
    
                if ($row = $results->fetch_assoc()) {
                    return [
                        'fecha_inscripcion' => $row['FechaInscripcion'],
                        'comision' => $row['comision'],
                        'carrera' => $row['carrera'],
                        'materias_aprobadas' => $row['MateriasAprobadas'],
                        'materias_pendientes' => $row['MateriasPendientes'],
                    ];
                    
                }
            }
    
            return false;
        } catch (Exception $e) {
            // Manejar cualquier excepción que pueda ocurrir durante la consulta
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
    
    
// {
//     $currentDate = date("Y-m-d");
//     $q = "SELECT examenes.ID, Alumno_ID, Materia_ID, FechaExamen, ResultadoExamen, M.NombreMateria AS Materia, CONCAT(U.Nombre, ' ', U.Apellido) AS NombreProfesor
//           FROM examenes 
//           JOIN materias AS M ON examenes.Materia_ID = M.ID 
//           JOIN usuarios AS U ON M.Profesor_ID = U.ID
//           WHERE Alumno_ID = ? AND Materia_ID = ? AND FechaExamen <= ?
//           ORDER BY FechaExamen DESC
//           LIMIT 1";
//     $query = self::$conexion->prepare($q);
//     $query->bind_param("iis", $userId, $materiaId, $currentDate);

//     if ($query->execute()) {
//         $results = $query->get_result();

//         if ($row = $results->fetch_assoc()) {
//             return new UltimoExamen(
//                 $row['ID'],
//                 $row['Alumno_ID'],
//                 $row['Materia_ID'],
//                 $row['FechaExamen'],
//                 $row['ResultadoExamen'],
//                 $row['Materia'],
//                 $row['NombreProfesor']
//             );
//         }
//     }

//     return false;
    // public function actualizar(User $u)
    // {
    //     $q = "UPDATE Users SET saldoUser = ? WHERE dniUser = ?";
    //     $query = self::$conexion->prepare($q);
    //     $saldo = $u->getSaldo();
    //     $id = $u->getId();

    //     $query->bind_param("sd", $saldo, $id);

    //     if ($query->execute()) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    // public function eliminar(User $u)
    // {
    //     $q = "DELETE FROM Users WHERE dniUser = ? ";
    //     $query = self::$conexion->prepare($q);

    //     $id = $u->getId();

    //     $query->bind_param("d", $id);

    //     if ($query->execute()) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
}
