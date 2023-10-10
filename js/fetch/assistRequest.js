document.addEventListener("DOMContentLoaded", function () {
    const materiaSelectAssist = document.getElementById('materiaSelectAssist');
    const asistenciasTableBody = document.querySelector('#asistenciasTable tbody');

    // CARGA DATOS MODAL INSCRIPCIÓN EXAMEN
    materiaSelectAssist.addEventListener("change", function () {
        const materiaSeleccionada = materiaSelectAssist.value;

        if (materiaSeleccionada !== "Materia..." && materiaSeleccionada != 0) {
            // Realiza una solicitud AJAX al servidor
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "../api/assistHistory.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const respuesta = xhr.responseText;

                    // Parsea la respuesta JSON
                    const asistencias = JSON.parse(respuesta);

                    // Limpia la tabla existente
                    asistenciasTableBody.innerHTML = '';

                    // Itera sobre los registros y agrega filas a la tabla
                    asistencias.forEach(asistencia => {
                        const row = document.createElement('tr');
                        const fechaCell = document.createElement('td');
                        const estadoCell = document.createElement('td');

                        fechaCell.textContent = asistencia.fecha;

                        // Asigna un color según el estado
                        if (asistencia.estado === 'Presente') {
                            estadoCell.textContent = asistencia.estado;
                            row.className = 'table-success';
                        } else if (asistencia.estado === 'Ausente') {
                            estadoCell.textContent = asistencia.estado;
                            row.className = 'table-warning';
                        }

                        row.appendChild(fechaCell);
                        row.appendChild(estadoCell);
                        asistenciasTableBody.appendChild(row);
                    });
                }
            };

            // Envía el valor seleccionado como parámetro
            xhr.send("materiaSelect=" + materiaSeleccionada);
        }
    });
});
