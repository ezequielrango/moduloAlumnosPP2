document.addEventListener("DOMContentLoaded", function () {
    //CONSTANCIA EXAMEN
    const materiaSelect = document.getElementById("materiaSelect");
    const calificacionInput = document.getElementById("calificacion");
    const fechaInput = document.getElementById("fecha");
    const profesorInput = document.getElementById("profesor");
    const alumnoInput = document.getElementById("alumnoInput");
    const materiaSelectExams = document.getElementById("materiaSelectExams");

    //CARGA DATOS MODAL CONSTANCIA EXAMEN
    materiaSelect.addEventListener("change", function () {
        const materiaSeleccionada = materiaSelect.value;

        if (materiaSeleccionada !== "Materia..." && materiaSeleccionada != 0) {
            // Realiza una solicitud AJAX al servidor
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "../api/certificate.request.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {

                    const respuesta = xhr.responseText;
                    console.log(respuesta)
                    if (respuesta) {
                        // Maneja la respuesta del servidor aquí

                        const data = JSON.parse(xhr.responseText);
                        console.log(data)
                        calificacionInput.value = data.calificacion;
                        fechaInput.value = data.fecha;
                        profesorInput.value = data.profesor;
                    }
                }
            };

            // Envía el valor seleccionado como parámetro
            xhr.send("materiaSelect=" + materiaSeleccionada);
        }
    });

    const showToast = (message) => {
        const toastCasero = document.getElementById("toastCasero");

        'Recibirás tu constancia de examen'
        toastCasero.textContent = message;

        setTimeout(() => {
            toastCasero.style.display = 'none';
        }, 5000); // Oculta el toast después de 5 segundos (5000 ms)

        toastCasero.style.display = 'flex';
        toastCasero.style.justifyContent = 'center';
        toastCasero.style.alignItems = 'center';
        toastCasero.style.color = 'white';
        return;

        if (apiResponse.status === 500 || apiResponse.status === 400) {
            toastCasero.style.backgroundColor = 'red';
            toastCasero.style.display = 'flex';
            toastCasero.style.justifyContent = 'center';
            toastCasero.style.alignItems = 'center';
            toastCasero.style.color = 'white';
            toastCasero.style.color = 'white'
            toastCasero.style.fontSize = '20px'
            toastCasero.style.fontWeight = 'bold'
        }
    }
    // Agrega un evento al botón "Confirmar" constancia examen
    document.getElementById("confirmBtn").addEventListener("click", async () => {
        // Verifica qué opción de radio button está seleccionada
        const radioDownload1 = document.getElementById("radioDownload1");
        const radioEmail1 = document.getElementById("radioEmail1");
        const materiaSeleccionada = materiaSelect.value;

        if (radioDownload1.checked) {
            // Opción "Descargar" seleccionada
            // Proporciona un enlace para descargar el archivo PDF

            const queryString = `materia=${encodeURIComponent(materiaSeleccionada)}&calificacion=${encodeURIComponent(calificacionInput.value)}&fecha=${encodeURIComponent(fechaInput.value)}&profesor=${encodeURIComponent(profesorInput.value)}&alumno=${encodeURIComponent(alumnoInput.value)}`;
            window.location.href = `../api/sendEmail.php?download=true&${queryString}`;
            showToast('Constancia examen descargada con éxito')
        } else if (radioEmail1.checked) {
            // Opción "Enviar por correo electrónico" seleccionada

            if (materiaSeleccionada !== "Materia..." && materiaSeleccionada != 0) {
                const data = {
                    materia: materiaSeleccionada,
                    calificacion: calificacionInput.value,
                    fecha: fechaInput.value,
                    profesor: profesorInput.value,
                    alumno: alumnoInput.value
                };
                fetch('../api/sendEmail.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                    })
                    .catch(error => {
                        console.error('Error:');
                    });
                showToast('Constancia de examen enviada con éxito')
            }
        }
    });



    document.getElementById("confirmBtnRegular").addEventListener("click", async () => {
        const alumnoInputRegular = document.getElementById("alumnoInputRegular");
        const dniInputRegular = document.getElementById("dniInputRegular");
        const carreraInputRegular = document.getElementById("carreraInputRegular");
        const comisionInputRegular = document.getElementById("comisionInputRegular");
        const legajoInputRegular = document.getElementById("legajoInputRegular");
        const radioDownload = document.getElementById("radioDownload");
        const radioEmail = document.getElementById("radioEmail");

        const data = {
            alumno: alumnoInputRegular.value,
            dni: dniInputRegular.value,
            carrera: carreraInputRegular.value,
            comision: comisionInputRegular.value,
            legajo: legajoInputRegular.value
        };




        if (radioDownload.checked) {
            // Opción "Descargar" seleccionada
            // Proporciona un enlace para descargar el archivo PDF
            const queryString = `alumno=${encodeURIComponent(data.alumno)}&dni=${encodeURIComponent(data.dni)}&carrera=${encodeURIComponent(data.carrera)}&comision=${encodeURIComponent(data.comision)}&legajo=${encodeURIComponent(data.legajo)}`;
            window.location.href = `../api/sendRegular.php?download=true&${queryString}`;
            showToast('Constancia alumno regular descargada con éxito')
        } else if (radioEmail.checked) {
            // Opción "Enviar por correo electrónico" seleccionada
            fetch('../api/sendRegular.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                })
                .catch(error => {
                    console.error('Error:');
                });
            showToast('Constancia alumno regular enviada con éxito')
        }
    });

    //CARGA DATOS MODAL INSCRIPCIÓN EXAMEN
    materiaSelectExams.addEventListener("change", function () {
        const materiaSeleccionada = materiaSelectExams.value;
        const examenesDisponibles = document.getElementById('examenesDisponibles');

        if (materiaSeleccionada !== "Materia..." && materiaSeleccionada != 0) {
            // Realiza una solicitud AJAX al servidor
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "../api/futureExams.request.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {

                    const respuesta = xhr.responseText;
                    console.log(typeof respuesta)
                    if (respuesta) {
                        const data = JSON.parse(xhr.responseText);
                        if (data.success) {
                            showToast('Puedes inscribirte al examen de la materia')
                            console.log(data)
                            // Limpia el contenedor de exámenes disponibles
                            examenesDisponibles.innerHTML = '';

                            // Agrega los exámenes disponibles al contenedor
                            data.exams.forEach(examen => {
                                const examenDiv = document.createElement('div');
                                examenDiv.classList.add("examen");
                                examenDiv.innerHTML = `
                                <h5>${examen.materia}</h5>
                                <div>
                                <p>Fecha: ${examen.fecha}</p>
                                <p>Profesor: ${examen.profesor}</p>
                                </div>
                                <input type="radio" name="examenSelect" value="${examen.id}">
                            `;
                                examenesDisponibles.appendChild(examenDiv);
                            });
                        } else {
                            showToast('No hay examenes para esa materia')
                        }
                    }
                }
            };

            // Envía el valor seleccionado como parámetro
            xhr.send("materiaSelect=" + materiaSeleccionada);
        }
    });
});
