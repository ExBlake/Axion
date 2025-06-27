// ================== Elementos DOM ==================
const sidebar = document.querySelector(".sidebar");
const sidebarToggle = document.getElementById("sidebar-toggle");
const showSidebarBtn = document.getElementById("show-sidebar-btn");
const overlay = document.getElementById("overlay");
const darkModeSwitch = document.getElementById("dark-mode-switch");
const body = document.body;
const submenuItems = document.querySelectorAll(".has-submenu");
const menuItems = document.querySelectorAll(".sidebar-menu a");
const viewOptions = document.querySelectorAll(".view-option");
const statCards = document.querySelectorAll(".stat-card");

// ================== Funciones ==================

// Actualizar visibilidad del botón flotante
function updateShowSidebarButton() {
    if (sidebar.classList.contains('collapsed')) {
        showSidebarBtn.classList.add('visible');
    } else {
        showSidebarBtn.classList.remove('visible');
    }
}

// Manejar vista móvil
function handleMobileView() {
    if (window.innerWidth <= 576) {
        sidebar.classList.add('collapsed');
        updateShowSidebarButton();

        // Cerrar sidebar haciendo clic fuera
        document.addEventListener('click', (e) => {
            if (!sidebar.contains(e.target) &&
                !sidebarToggle.contains(e.target) &&
                !showSidebarBtn.contains(e.target)) {
                sidebar.classList.add('collapsed');
                updateShowSidebarButton();
            }
        });
    }
}

// ================== Eventos ==================

// Toggle sidebar colapsado
if (sidebarToggle) {
    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        updateShowSidebarButton();

        // En móviles, también quitar clase 'active'
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    });
}

// Mostrar sidebar en móvil (botón flotante)
if (showSidebarBtn) {
    showSidebarBtn.addEventListener('click', () => {
        sidebar.classList.remove('collapsed');
        sidebar.classList.add('active');
        overlay.classList.add('active');
        updateShowSidebarButton();
    });
}

// Cerrar sidebar al hacer clic en el overlay
if (overlay) {
    overlay.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    });
}

// Toggle submenu en sidebar
submenuItems.forEach(item => {
    item.addEventListener('click', function (e) {
        if (e.target.closest('a') === this.querySelector('a')) {
            e.preventDefault();

            // Cerrar otros submenus
            submenuItems.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.classList.remove('open');
                }
            });

            // Abrir o cerrar el submenu
            this.classList.toggle('open');
        }
    });

    // Hover en modo colapsado
    item.addEventListener('mouseenter', function () {
        if (sidebar.classList.contains('collapsed')) {
            this.classList.add('open');
        }
    });

    item.addEventListener('mouseleave', function () {
        if (sidebar.classList.contains('collapsed')) {
            this.classList.remove('open');
        }
    });
});

// Toggle Dark Mode
if (localStorage.getItem('darkMode') === 'enabled') {
    body.classList.add('dark-mode');
    if (darkModeSwitch) darkModeSwitch.checked = true;
}

if (darkModeSwitch) {
    darkModeSwitch.addEventListener('change', () => {
        if (darkModeSwitch.checked) {
            body.classList.add('dark-mode');
            localStorage.setItem('darkMode', 'enabled');
        } else {
            body.classList.remove('dark-mode');
            localStorage.setItem('darkMode', 'disabled');
        }
    });
}

// Activar item de menú principal
menuItems.forEach(item => {
    item.addEventListener('click', function () {
        if (!this.closest('.submenu')) {
            menuItems.forEach(i => {
                if (!i.closest('.submenu')) {
                    i.closest('li').classList.remove('active');
                }
            });

            if (!this.closest('.has-submenu')) {
                this.closest('li').classList.add('active');
            }
        }
    });
});

// Activar opción de vista
viewOptions.forEach(option => {
    option.addEventListener('click', function () {
        viewOptions.forEach(opt => opt.classList.remove('active'));
        this.classList.add('active');
    });
});

// Animación de estadísticas
statCards.forEach((card, index) => {
    card.style.animationDelay = `${index * 0.1}s`;
    card.classList.add('animate-in');
});

// ================== Inicializaciones ==================
// Revisar tamaño inicial y en redimensionar
handleMobileView();
window.addEventListener('resize', handleMobileView);

// Simular clic en botón de sidebar en móviles (extra seguridad)
document.addEventListener('DOMContentLoaded', function () {
    if (window.innerWidth <= 768) {
        sidebar.classList.add('collapsed');
        updateShowSidebarButton();
    }
});
