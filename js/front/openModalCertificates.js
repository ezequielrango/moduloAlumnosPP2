
document.addEventListener('DOMContentLoaded', function() {

    const alumnoRegularLink = document.getElementById('alumnoRegularLink');
    const constanciaExamenLink = document.getElementById('constanciaExamenLink');
    const inscripcionExamenLink = document.getElementById('inscripcionExamenLink');
    const parcialesLink = document.getElementById('parcialesLink');

    const spanToast = document.getElementById('spanToast');

    const setspanToast = () => {
        spanToast.style.color = 'white'
        spanToast.style.fontSize = '20px'
        spanToast.style.fontWeight = 'bold'

    }
    alumnoRegularLink.addEventListener('click', function(e) {
        e.preventDefault();
        const modal = new bootstrap.Modal(document.getElementById('modalAlumnoRegular'));
        modal.show();
    });

    constanciaExamenLink.addEventListener('click', function(e) {
        e.preventDefault();
        const modal = new bootstrap.Modal(document.getElementById('modalConstanciaExamen'));
        modal.show();
    });

    inscripcionExamenLink.addEventListener('click', function(e) {
        console.log('ENTRO')
        e.preventDefault();
        const modal = new bootstrap.Modal(document.getElementById('modalInscripcionExamen'));
        modal.show();
    });

    parcialesLink.addEventListener('click', function(e) {
        e.preventDefault();
        const modal = new bootstrap.Modal(document.getElementById('modalParciales'));
        modal.show();
    });

    document.getElementById("confirmBtn").addEventListener('click', function(e) {
        e.preventDefault();
        const modalElement = document.getElementById('modalConstanciaExamen');
        const modal = bootstrap.Modal.getInstance(modalElement); // Obtén la instancia existente del modal
        modal.hide(); // Cierra el modal
        setspanToast()
    });

    document.getElementById("confirmBtnRegular").addEventListener('click', function(e) {
        e.preventDefault();
        const modalElement = document.getElementById('modalAlumnoRegular');
        const modal = bootstrap.Modal.getInstance(modalElement); // Obtén la instancia existente del modal
        modal.hide(); // Cierra el modal
        setspanToast()
    });

    document.getElementById("confirmBtnInscriptionExam").addEventListener('click', function(e) {
        e.preventDefault();
        const modalElement = document.getElementById('modalInscripcionExamen');
        const modal = bootstrap.Modal.getInstance(modalElement); // Obtén la instancia existente del modal
        modal.hide(); // Cierra el modal
        setspanToast()
    });

});

function zoom(e){
    var zoomer = e.currentTarget;
    e.offsetX ? offsetX = e.offsetX : offsetX = e.touches[0].pageX
    e.offsetY ? offsetY = e.offsetY : offsetX = e.touches[0].pageX
    x = offsetX/zoomer.offsetWidth*100
    y = offsetY/zoomer.offsetHeight*100
    zoomer.style.backgroundPosition = x + '% ' + y + '%';
  }