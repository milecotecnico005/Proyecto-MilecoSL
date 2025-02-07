const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

allSideMenu.forEach(item=> {
	const li = item.parentElement;

	item.addEventListener('click', function () {
		allSideMenu.forEach(i=> {
			i.parentElement.classList.remove('active');
		})
		li.classList.add('active');
	})
});



// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
})







const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

searchButton.addEventListener('click', function (e) {
	if(window.innerWidth < 576) {
		e.preventDefault();
		searchForm.classList.toggle('show');
		if(searchForm.classList.contains('show')) {
			searchButtonIcon.classList.replace('bx-search', 'bx-x');
		} else {
			searchButtonIcon.classList.replace('bx-x', 'bx-search');
		}
	}
})





if(window.innerWidth < 768) {
	sidebar.classList.add('hide');
} else if(window.innerWidth > 576) {
	searchButtonIcon.classList.replace('bx-x', 'bx-search');
	searchForm.classList.remove('show');
}


window.addEventListener('resize', function () {
	if(this.innerWidth > 576) {
		searchButtonIcon.classList.replace('bx-x', 'bx-search');
		searchForm.classList.remove('show');
	}
})



const switchMode = document.getElementById('switch-mode');

// Funciones para manejar cookies
function setCookie(name, value, days) {
    const date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    document.cookie = `${name}=${value}; expires=${date.toUTCString()}; path=/`;
}

function getCookie(name) {
    const cookies = document.cookie.split('; ');
    for (let cookie of cookies) {
        const [key, value] = cookie.split('=');
        if (key === name) {
            return value;
        }
    }
    return null;
}

// Cargar el modo previamente seleccionado al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    let isDarkMode;

    // Verificar si `localStorage` está disponible
    if (typeof localStorage !== 'undefined') {
        isDarkMode = localStorage.getItem('darkMode') === 'true';
    } else {
        isDarkMode = getCookie('darkMode') === 'true';
    }

    if (isDarkMode) {
        document.body.classList.add('dark');
        switchMode.checked = true; // Asegurar que el switch esté en estado "checked"
    } else {
        document.body.classList.remove('dark');
        switchMode.checked = false;
    }
});

// Escuchar cambios en el switch y guardar la selección
switchMode.addEventListener('change', function () {
    if (this.checked) {
        document.body.classList.add('dark');
        if (typeof localStorage !== 'undefined') {
            localStorage.setItem('darkMode', 'true'); // Guardar en localStorage
        } else {
            setCookie('darkMode', 'true', 365); // Guardar en una cookie
        }
    } else {
        document.body.classList.remove('dark');
        if (typeof localStorage !== 'undefined') {
            localStorage.setItem('darkMode', 'false'); // Guardar en localStorage
        } else {
            setCookie('darkMode', 'false', 365); // Guardar en una cookie
        }
    }
});