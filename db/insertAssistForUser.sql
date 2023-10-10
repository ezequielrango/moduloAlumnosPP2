DELIMITER //

CREATE PROCEDURE InsertarAsistencias2()
BEGIN
    DECLARE fechaInicio DATE;
    DECLARE fechaFin DATE;
    DECLARE currentDate DATE;
    DECLARE estadoAsistencia INT;

    SET fechaInicio = '2023-03-01';
    SET fechaFin = '2023-10-31';
    SET currentDate = fechaInicio;

    WHILE currentDate <= fechaFin DO
        -- Generar un estado de asistencia aleatorio entre 1 y 2
        SET estadoAsistencia = FLOOR(1 + (RAND() * 2));

        -- Generar un valor de Materia_ID aleatorio entre 1 y 13
        SET @randomMateriaID = FLOOR(1 + (RAND() * 13));

        -- Insertar registro para el lunes
        INSERT INTO Asistencias (Alumno_ID, Materia_ID, FechaAsistencia, EstadoAsistencia_ID)
        VALUES (52, @randomMateriaID, currentDate, estadoAsistencia);

        -- Insertar registro para el martes
        SET currentDate = DATE_ADD(currentDate, INTERVAL 1 DAY);
        SET estadoAsistencia = FLOOR(1 + (RAND() * 2));
        SET @randomMateriaID = FLOOR(1 + (RAND() * 13));
        INSERT INTO Asistencias (Alumno_ID, Materia_ID, FechaAsistencia, EstadoAsistencia_ID)
        VALUES (52, @randomMateriaID, currentDate, estadoAsistencia);

        -- Insertar registro para el miércoles
        SET currentDate = DATE_ADD(currentDate, INTERVAL 1 DAY);
        SET estadoAsistencia = FLOOR(1 + (RAND() * 2));
        SET @randomMateriaID = FLOOR(1 + (RAND() * 13));
        INSERT INTO Asistencias (Alumno_ID, Materia_ID, FechaAsistencia, EstadoAsistencia_ID)
        VALUES (52, @randomMateriaID, currentDate, estadoAsistencia);

        -- Avanzar a la siguiente semana (7 días)
        SET currentDate = DATE_ADD(currentDate, INTERVAL 4 DAY);
    END WHILE;
END //

DELIMITER ;
CALL InsertarAsistencias2();