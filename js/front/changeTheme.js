

document.addEventListener("DOMContentLoaded", function () {
    const themeSwitch = document.getElementById('themeSwitch');
    const body = document.getElementById('body');
    const nav = document.getElementById('nav');
    const textElements = document.querySelectorAll('p, h1, h2, h3, h5, a, span');
    const cards = document.querySelectorAll('.my-card');
    const dropdownMenues = document.querySelectorAll('.dropdown-menu');
    const dropdownLinks = document.querySelectorAll(".dropdown-item");
    const labelsChekForm = document.querySelectorAll('.form-check-label');
    const labelsProfile =  document.querySelectorAll('#labelProfile');
    const asistenciasTable =  document.querySelectorAll('#asistenciasTable');
    const asistenciasTableTh =  document.querySelectorAll('#asistenciasTableTh');
    const asistenciasTableTd =  document.querySelectorAll('#asistenciasTableTd');
    const spanbadges = document.querySelectorAll('#spanbadge');


    function toggleTheme() {
        themeSwitch.value = localStorage.getItem('switchValue');
        console.log(themeSwitch.value)
        if (body.classList.contains('light-theme')) {
            // Cambiar a OSCURO
            nav.classList.remove('navbar-light');
            nav.classList.remove('bg-light');
            body.classList.remove('light-theme');
            body.classList.add('dark-theme');

            textElements.forEach((element) => {
                element.style.color = 'white';
            });
            labelsChekForm.forEach((label) => {
                label.style.color = 'black';
            });
    

            cards.forEach((card) => {
                card.style.backgroundColor = 'grey';
            });

            dropdownMenues.forEach((dropdownMenu) => {
                dropdownMenu.style.backgroundColor = 'grey';
            });

            dropdownLinks.forEach((dropdownLink) => {
                dropdownLink.style.color = 'black';
            });
            
            
            labelsProfile.forEach((labelProfile) => {
                labelProfile.style.color = 'white';
            });

            asistenciasTable.forEach((asistenciasTable) => {
                asistenciasTable.style.backgroundColor = 'white';
            });

            asistenciasTableTh.forEach((asistenciasTableTh) => {
                asistenciasTableTh.style.color = 'black';
            });

            asistenciasTableTd.forEach((asistenciasTableTd) => {
                asistenciasTableTd.style.color = 'black';
            });

            localStorage.setItem('theme', 'dark-theme');
            localStorage.setItem('switchValue',themeSwitch.value);
        } else {
            // Cambiar a CLARO
            body.classList.remove('dark-theme');
            nav.classList.remove('navbar-dark');
            nav.classList.remove('bg-dark');
            body.classList.add('light-theme');
            nav.classList.remove('navbar-light');
            nav.classList.remove('bg-light');

            textElements.forEach((element) => {
                element.style.color = 'black';
            });

            cards.forEach((card) => {
                card.style.backgroundColor = 'white';
            });

            dropdownMenues.forEach((dropdownMenu) => {
                dropdownMenu.style.backgroundColor = 'white';
            });

            labelsProfile.forEach((labelProfile) => {
                labelProfile.style.color = 'black';
            });

            
            asistenciasTable.forEach((asistenciasTable) => {
                asistenciasTable.style.backgroundColor = 'grey';
            });

            asistenciasTableTh.forEach((asistenciasTableTh) => {
                asistenciasTableTh.style.color = 'white';
            });

            asistenciasTableTd.forEach((asistenciasTableTd) => {
                asistenciasTableTd.style.color = 'white';
            });


            spanbadges.forEach((spanbadge) => {
                spanbadge.style.color = 'white';
            });

            

            localStorage.setItem('theme', 'light-theme');
            localStorage.setItem('switchValue',themeSwitch.value);
        }


        
    }

    const storedTheme = localStorage.getItem('theme');

    if (storedTheme == 'light-theme' ) {
        body.classList.add(storedTheme);
        body.classList.remove('dark-theme');
        nav.classList.remove('navbar-dark');
        nav.classList.remove('bg-dark');
        body.classList.add('light-theme');
        nav.classList.remove('navbar-light');
        nav.classList.remove('bg-light');

        textElements.forEach((element) => {
            element.style.color = 'black';
        });

        labelsProfile.forEach((labelProfile) => {
            labelProfile.style.color = 'black';
        });

        cards.forEach((card) => {
            card.style.backgroundColor = 'white';
        });

        dropdownMenues.forEach((dropdownMenu) => {
            dropdownMenu.style.backgroundColor = 'white';
        });

        
        spanbadges.forEach((spanbadge) => {
            spanbadge.style.color = 'white';
        });


    } else {
        themeSwitch.value = 'on';
        nav.classList.remove('navbar-light');
        nav.classList.remove('bg-light');
        body.classList.remove('light-theme');
        body.classList.add('dark-theme');

        textElements.forEach((element) => {
            element.style.color = 'white';
        });
        
        labelsProfile.forEach((labelProfile) => {
            labelProfile.style.color = 'white';
        });

        cards.forEach((card) => {
            card.style.backgroundColor = 'grey';
        });

        dropdownMenues.forEach((dropdownMenu) => {
            dropdownMenu.style.backgroundColor = 'grey';
        });

        dropdownLinks.forEach((dropdownLink) => {
            dropdownLink.style.color = 'black';
        });

        spanbadges.forEach((spanbadge) => {
            spanbadge.style.color = 'white';
        });
        
    }

    themeSwitch.addEventListener('click', toggleTheme);
});
