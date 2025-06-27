document.addEventListener("DOMContentLoaded", () => {
    // Inicializar funcionalidades del dashboard
    initDashboard();
    
    // Funcionalidad para el selector de rango de fechas
    const dateRangeBtn = document.querySelector('.date-range-selector .btn-outline');
    if (dateRangeBtn) {
        dateRangeBtn.addEventListener('click', () => {
            showDateRangePicker();
        });
    }
    
    // Funcionalidad para el botón de actualizar
    const refreshBtn = document.querySelector('.dashboard-container .btn-primary');
    if (refreshBtn) {
        refreshBtn.addEventListener('click', () => {
            refreshDashboard();
        });
    }
    
    // Funcionalidad para los botones de refrescar en los paneles
    const refreshBtns = document.querySelectorAll('.panel-actions .btn-icon[title="Refrescar"]');
    refreshBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const panel = e.target.closest('.panel-section');
            refreshPanel(panel);
        });
    });
    
    // Funcionalidad para los botones de opciones en los paneles
    const optionsBtns = document.querySelectorAll('.panel-actions .btn-icon[title="Más opciones"]');
    optionsBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            showPanelOptions(e);
        });
    });
    
    // Funcionalidad para el botón de personalizar accesos rápidos
    const customizeBtn = document.querySelector('.panel-section .panel-actions .btn-icon[title="Personalizar"]');
    if (customizeBtn) {
        customizeBtn.addEventListener('click', () => {
            showCustomizeQuickAccess();
        });
    }
    
    // Funcionalidad para los botones "Ver todos"
    const viewAllBtns = document.querySelectorAll('.panel-footer .btn-text');
    viewAllBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const panel = e.target.closest('.panel-section');
            const panelTitle = panel.querySelector('.panel-header h2').textContent.trim();
            showAllItems(panelTitle);
        });
    });
    
    // Funcionalidad para los botones de acción de usuarios
    const userActionBtns = document.querySelectorAll('.user-actions .btn-icon');
    userActionBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const action = e.target.closest('.btn-icon').title;
            const userName = e.target.closest('.user-item').querySelector('.user-name').textContent;
            handleUserAction(action, userName);
        });
    });
    
    // Funcionalidad para marcar todas las notificaciones como leídas
    const markReadBtn = document.querySelector('.panel-actions .btn-icon[title="Marcar todas como leídas"]');
    if (markReadBtn) {
        markReadBtn.addEventListener('click', () => {
            markAllNotificationsAsRead();
        });
    }
});

// Función para inicializar el dashboard
function initDashboard() {
    console.log('Dashboard inicializado');
    
    // Aquí podrías cargar datos iniciales, configurar websockets para actualizaciones en tiempo real, etc.
}

// Función para mostrar el selector de rango de fechas
function showDateRangePicker() {
    // Crear el diálogo
    const dialog = document.createElement('div');
    dialog.className = 'date-range-dialog';
    
    dialog.innerHTML = `
        <div class="dialog-backdrop"></div>
        <div class="dialog-container">
            <div class="dialog-header">
                <h3>Seleccionar rango de fechas</h3>
                <button class="dialog-close"><i class="fas fa-times"></i></button>
            </div>
            <div class="dialog-body">
                <div class="date-range-options">
                    <button class="date-preset active" data-range="7">Últimos 7 días</button>
                    <button class="date-preset" data-range="30">Últimos 30 días</button>
                    <button class="date-preset" data-range="90">Últimos 90 días</button>
                    <button class="date-preset" data-range="365">Último año</button>
                    <button class="date-preset" data-range="custom">Personalizado</button>
                </div>
                
                <div class="custom-date-range" style="display: none;">
                    <div class="date-input-group">
                        <label for="date-from">Desde:</label>
                        <input type="date" id="date-from" class="date-input">
                    </div>
                    <div class="date-input-group">
                        <label for="date-to">Hasta:</label>
                        <input type="date" id="date-to" class="date-input">
                    </div>
                </div>
            </div>
            <div class="dialog-footer">
                <button class="btn btn-secondary dialog-cancel">Cancelar</button>
                <button class="btn btn-primary dialog-apply">Aplicar</button>
            </div>
        </div>
    `;
    
    // Añadir al DOM
    document.body.appendChild(dialog);
    
    // Mostrar con animación
    setTimeout(() => {
        dialog.classList.add('show');
    }, 10);
    
    // Manejar cierre del diálogo
    const closeDialog = () => {
        dialog.classList.remove('show');
        setTimeout(() => {
            dialog.remove();
        }, 300);
    };
    
    // Eventos para cerrar
    dialog.querySelector('.dialog-close').addEventListener('click', closeDialog);
    dialog.querySelector('.dialog-cancel').addEventListener('click', closeDialog);
    dialog.querySelector('.dialog-backdrop').addEventListener('click', closeDialog);
    
    // Manejar selección de presets
    const presets = dialog.querySelectorAll('.date-preset');
    const customDateRange = dialog.querySelector('.custom-date-range');
    
    presets.forEach(preset => {
        preset.addEventListener('click', () => {
            // Quitar clase activa de todos
            presets.forEach(p => p.classList.remove('active'));
            // Añadir clase activa al seleccionado
            preset.classList.add('active');
            
            // Mostrar/ocultar selector personalizado
            if (preset.dataset.range === 'custom') {
                customDateRange.style.display = 'block';
            } else {
                customDateRange.style.display = 'none';
            }
        });
    });
    
    // Inicializar fechas para el selector personalizado
    const today = new Date();
    const thirtyDaysAgo = new Date();
    thirtyDaysAgo.setDate(today.getDate() - 30);
    
    const dateFrom = dialog.querySelector('#date-from');
    const dateTo = dialog.querySelector('#date-to');
    
    if (dateFrom && dateTo) {
        dateFrom.valueAsDate = thirtyDaysAgo;
        dateTo.valueAsDate = today;
    }
    
    // Evento para aplicar
    dialog.querySelector('.dialog-apply').addEventListener('click', () => {
        let rangeText = 'Últimos 30 días';
        const activePreset = dialog.querySelector('.date-preset.active');
        
        if (activePreset) {
            const range = activePreset.dataset.range;
            
            if (range === 'custom') {
                const from = new Date(dateFrom.value);
                const to = new Date(dateTo.value);
                
                const options = { day: 'numeric', month: 'short' };
                rangeText = `${from.toLocaleDateString('es-ES', options)} - ${to.toLocaleDateString('es-ES', options)}`;
            } else if (range === '7') {
                rangeText = 'Últimos 7 días';
            } else if (range === '30') {
                rangeText = 'Últimos 30 días';
            } else if (range === '90') {
                rangeText = 'Últimos 90 días';
            } else if (range === '365') {
                rangeText = 'Último año';
            }
        }
        
        // Actualizar el texto del botón
        const dateRangeBtn = document.querySelector('.date-range-selector .btn-outline span');
        if (dateRangeBtn) {
            dateRangeBtn.textContent = rangeText;
        }
        
        // Cerrar diálogo
        closeDialog();
        
        // Refrescar dashboard con el nuevo rango
        refreshDashboard(true);
    });
    
    // Añadir estilos para el diálogo
    const style = document.createElement('style');
    style.textContent = `
        .date-range-dialog {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1100;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .date-range-dialog.show {
            opacity: 1;
        }
        
        .dialog-backdrop {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }
        
        .dialog-container {
            position: relative;
            background-color: var(--panel-color);
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transform: scale(0.95);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        .date-range-dialog.show .dialog-container {
            transform: scale(1);
            opacity: 1;
        }
        
        .dialog-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .dialog-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }
        
        .dialog-body {
            padding: 20px;
        }
        
        .date-range-options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .date-preset {
            background-color: var(--gray-7);
            border: none;
            padding: 10px 16px;
            border-radius: var(--button-radius);
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .date-preset:hover {
            background-color: var(--gray-6);
        }
        
        .date-preset.active {
            background-color: var(--primary-color);
            color: white;
        }
        
        .custom-date-range {
            display: flex;
            gap: 16px;
            margin-top: 16px;
        }
        
        .date-input-group {
            flex: 1;
        }
        
        .date-input-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: var(--text-secondary);
        }
        
        .date-input {
            width: 100%;
            padding: 10px;
            border-radius: var(--input-radius);
            border: 1px solid var(--border-color);
            background-color: var(--panel-color);
            color: var(--text-color);
        }
        
        .dialog-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }
        
        @media (max-width: 576px) {
            .custom-date-range {
                flex-direction: column;
                gap: 12px;
            }
        }
    `;
    document.head.appendChild(style);
}

// Función para refrescar el dashboard
function refreshDashboard(silent = false) {
    if (!silent) {
        showNotification('Actualizando dashboard...');
    }
    
    // Simular recarga de datos
    const kpiCards = document.querySelectorAll('.kpi-card');
    const panelSections = document.querySelectorAll('.panel-section');
    
    kpiCards.forEach(card => {
        card.style.opacity = '0.6';
    });
    
    panelSections.forEach(panel => {
        panel.style.opacity = '0.6';
    });
    
    // Simular tiempo de carga
    setTimeout(() => {
        // Restaurar opacidad
        kpiCards.forEach(card => {
            card.style.opacity = '1';
            
            // Actualizar valores de KPIs
            const kpiValue = card.querySelector('.kpi-value');
            if (kpiValue) {
                const originalValue = kpiValue.textContent;
                
                if (originalValue.includes('$')) {
                    // Es un valor monetario
                    const baseValue = parseInt(originalValue.replace(/[$,]/g, ''));
                    const newValue = baseValue + Math.floor(Math.random() * 100000 - 50000);
                    kpiValue.textContent = '$' + newValue.toLocaleString();
                } else if (originalValue.includes('min')) {
                    // Es un tiempo
                    const baseValue = parseFloat(originalValue);
                    const newValue = (baseValue + (Math.random() * 5 - 2.5)).toFixed(1);
                    kpiValue.textContent = newValue + ' min';
                } else if (originalValue.includes(',')) {
                    // Es un número grande con comas
                    const baseValue = parseInt(originalValue.replace(/,/g, ''));
                    const newValue = baseValue + Math.floor(Math.random() * 1000 - 500);
                    kpiValue.textContent = newValue.toLocaleString();
                }
            }
            
            // Actualizar tendencia
            const kpiTrend = card.querySelector('.kpi-trend');
            if (kpiTrend) {
                const isPositive = Math.random() > 0.3; // 70% de probabilidad de ser positivo
                
                if (isPositive) {
                    kpiTrend.className = 'kpi-trend positive';
                    kpiTrend.innerHTML = `<i class="fas fa-arrow-up"></i> ${(Math.random() * 15 + 1).toFixed(1)}% vs mes anterior`;
                } else {
                    kpiTrend.className = 'kpi-trend negative';
                    kpiTrend.innerHTML = `<i class="fas fa-arrow-down"></i> ${(Math.random() * 10 + 1).toFixed(1)}% vs mes anterior`;
                }
            }
        });
        
        // Restaurar opacidad de los paneles
        panelSections.forEach(panel => {
            panel.style.opacity = '1';
        });
        
        if (!silent) {
            showNotification('Dashboard actualizado correctamente');
        }
    }, 1500);
}

// Función para refrescar un panel específico
function refreshPanel(panel) {
    const panelTitle = panel.querySelector('.panel-header h2').textContent.trim();
    showNotification(`Actualizando ${panelTitle}...`);
    
    // Simular recarga de datos
    panel.style.opacity = '0.6';
    
    // Simular tiempo de carga
    setTimeout(() => {
        panel.style.opacity = '1';
        
        // Actualizar contenido según el tipo de panel
        if (panelTitle.includes('Usuarios')) {
            // Actualizar panel de usuarios
            const userItems = panel.querySelectorAll('.user-item');
            userItems.forEach(item => {
                // Actualizar estado online/offline aleatoriamente
                const statusIndicator = item.querySelector('.status-indicator');
                if (statusIndicator) {
                    const statuses = ['online', 'offline', 'away'];
                    const randomStatus = statuses[Math.floor(Math.random() * statuses.length)];
                    statusIndicator.className = 'status-indicator ' + randomStatus;
                }
            });
        } else if (panelTitle.includes('Registros')) {
            // Actualizar panel de registros
            const recordItems = panel.querySelectorAll('.record-item');
            recordItems.forEach(item => {
                // Actualizar estado aleatoriamente
                const statusBadge = item.querySelector('.status-badge');
                if (statusBadge) {
                    const statuses = [
                        {class: 'completed', text: 'Completado'},
                        {class: 'in-progress', text: 'En progreso'},
                        {class: 'pending', text: 'Pendiente'}
                    ];
                    const randomStatus = statuses[Math.floor(Math.random() * statuses.length)];
                    statusBadge.className = 'status-badge ' + randomStatus.class;
                    statusBadge.textContent = randomStatus.text;
                }
            });
        } else if (panelTitle.includes('Actividad')) {
            // Actualizar panel de actividad
            const activityList = panel.querySelector('.activity-list');
            
            // Añadir una nueva actividad al principio
            const activities = [
                {
                    time: 'Ahora',
                    icon: 'fas fa-user-plus',
                    title: 'Nuevo usuario registrado',
                    details: 'Laura Fernández se ha unido al sistema'
                },
                {
                    time: 'Ahora',
                    icon: 'fas fa-file-upload',
                    title: 'Nuevo documento subido',
                    details: 'Carlos Rodríguez subió "Reporte Mensual.pdf"'
                },
                {
                    time: 'Ahora',
                    icon: 'fas fa-edit',
                    title: 'Registro actualizado',
                    details: 'Ana García actualizó el registro #45982'
                }
            ];
            
            const randomActivity = activities[Math.floor(Math.random() * activities.length)];
            
            const newActivityItem = document.createElement('div');
            newActivityItem.className = 'activity-item';
            newActivityItem.innerHTML = `
                <div class="activity-time">${randomActivity.time}</div>
                <div class="activity-icon">
                    <i class="${randomActivity.icon}"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-title">${randomActivity.title}</div>
                    <div class="activity-details">${randomActivity.details}</div>
                </div>
            `;
            
            // Insertar al principio
            if (activityList.firstChild) {
                activityList.insertBefore(newActivityItem, activityList.firstChild);
                
                // Eliminar el último si hay más de 3
                const activityItems = activityList.querySelectorAll('.activity-item');
                if (activityItems.length > 3 && activityList.lastChild) {
                    activityList.removeChild(activityList.lastChild);
                }
            }
        } else if (panelTitle.includes('Estado del sistema')) {
            // Actualizar panel de estado del sistema
            const statusItems = panel.querySelectorAll('.status-item');
            statusItems.forEach(item => {
                const statusLabel = item.querySelector('.status-label').textContent;
                
                if (statusLabel !== 'Última actualización') {
                    // Actualizar porcentajes aleatoriamente
                    const statusValue = item.querySelector('.status-value');
                    if (statusValue) {
                        const statusText = statusValue.querySelector('span:last-child');
                        if (statusText) {
                            if (statusLabel === 'Almacenamiento') {
                                const percentage = Math.floor(Math.random() * 30 + 65); // Entre 65% y 95%
                                statusText.textContent = `${percentage}% utilizado`;
                                
                                // Actualizar indicador según el porcentaje
                                const indicator = statusValue.querySelector('.status-indicator');
                                if (indicator) {
                                    if (percentage > 90) {
                                        indicator.className = 'status-indicator warning';
                                    } else {
                                        indicator.className = 'status-indicator online';
                                    }
                                }
                            } else {
                                const percentage = (Math.random() * 2 + 98).toFixed(1); // Entre 98% y 100%
                                statusText.textContent = `Operativo (${percentage}%)`;
                            }
                        }
                    }
                } else {
                    // Actualizar hora de última actualización
                    const statusValue = item.querySelector('.status-value');
                    if (statusValue) {
                        const now = new Date();
                        const hours = now.getHours().toString().padStart(2, '0');
                        const minutes = now.getMinutes().toString().padStart(2, '0');
                        statusValue.textContent = `Hoy, ${hours}:${minutes}`;
                    }
                }
            });
        } else if (panelTitle.includes('Notificaciones')) {
            // Actualizar panel de notificaciones
            const notificationList = panel.querySelector('.notification-list');
            
            // Añadir una nueva notificación al principio
            const notifications = [
                {
                    icon: 'info',
                    iconClass: 'fas fa-info-circle',
                    title: 'Nueva actualización disponible',
                    details: 'Versión 2.6.0 lista para instalar',
                    time: 'Hace 1 minuto'
                },
                {
                    icon: 'success',
                    iconClass: 'fas fa-check-circle',
                    title: 'Tarea completada',
                    details: 'La sincronización de datos ha finalizado',
                    time: 'Hace 3 minutos'
                },
                {
                    icon: 'warning',
                    iconClass: 'fas fa-exclamation-triangle',
                    title: 'Advertencia de sistema',
                    details: 'Alto uso de CPU detectado',
                    time: 'Hace 5 minutos'
                }
            ];
            
            const randomNotification = notifications[Math.floor(Math.random() * notifications.length)];
            
            const newNotificationItem = document.createElement('div');
            newNotificationItem.className = 'notification-item unread';
            newNotificationItem.innerHTML = `
                <div class="notification-icon ${randomNotification.icon}">
                    <i class="${randomNotification.iconClass}"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">${randomNotification.title}</div>
                    <div class="notification-details">${randomNotification.details}</div>
                    <div class="notification-time">${randomNotification.time}</div>
                </div>
            `;
            
            // Insertar al principio
            if (notificationList.firstChild) {
                notificationList.insertBefore(newNotificationItem, notificationList.firstChild);
                
                // Eliminar el último si hay más de 3
                const notificationItems = notificationList.querySelectorAll('.notification-item');
                if (notificationItems.length > 3 && notificationList.lastChild) {
                    notificationList.removeChild(notificationList.lastChild);
                }
            }
        }
        
        showNotification(`${panelTitle} actualizado correctamente`);
    }, 1000);
}

// Función para mostrar opciones de panel
function showPanelOptions(event) {
    const button = event.target.closest('.btn-icon');
    const panel = button.closest('.panel-section');
    const panelTitle = panel.querySelector('.panel-header h2').textContent.trim();
    
    // Crear menú de opciones
    const optionsMenu = document.createElement('div');
    optionsMenu.className = 'panel-options-menu';
    optionsMenu.innerHTML = `
        <div class="options-menu-arrow"></div>
        <ul>
            <li data-action="refresh"><i class="fas fa-sync-alt"></i> Actualizar</li>
            <li data-action="export"><i class="fas fa-download"></i> Exportar</li>
            <li data-action="fullscreen"><i class="fas fa-expand"></i> Pantalla completa</li>
            <li class="divider"></li>
            <li data-action="settings"><i class="fas fa-cog"></i> Configuración</li>
        </ul>
    `;
    
    // Añadir al DOM
    document.body.appendChild(optionsMenu);
    
    // Posicionar el menú
    const buttonRect = button.getBoundingClientRect();
    optionsMenu.style.top = (buttonRect.bottom + 10) + 'px';
    optionsMenu.style.left = (buttonRect.left - 150 + buttonRect.width / 2) + 'px';
    
    // Mostrar con animación
    setTimeout(() => {
        optionsMenu.classList.add('active');
    }, 10);
    
    // Cerrar el menú al hacer clic fuera
    const closeMenu = () => {
        optionsMenu.classList.remove('active');
        setTimeout(() => {
            optionsMenu.remove();
        }, 300);
        document.removeEventListener('click', handleOutsideClick);
    };
    
    const handleOutsideClick = (e) => {
        if (!optionsMenu.contains(e.target) && e.target !== button) {
            closeMenu();
        }
    };
    
    // Añadir evento después de un pequeño retraso para evitar que se cierre inmediatamente
    setTimeout(() => {
        document.addEventListener('click', handleOutsideClick);
    }, 10);
    
    // Manejar acciones del menú
    optionsMenu.querySelectorAll('li[data-action]').forEach(item => {
        item.addEventListener('click', () => {
            const action = item.getAttribute('data-action');
            
            // Cerrar menú
            closeMenu();
            
            // Ejecutar acción
            switch (action) {
                case 'refresh':
                    refreshPanel(panel);
                    break;
                case 'export':
                    exportPanelData(panel, panelTitle);
                    break;
                case 'fullscreen':
                    togglePanelFullscreen(panel);
                    break;
                case 'settings':
                    showPanelSettings(panel, panelTitle);
                    break;
            }
        });
    });
    
    // Añadir estilos para el menú
    const style = document.createElement('style');
    style.textContent = `
        .panel-options-menu {
            position: absolute;
            background-color: var(--panel-color);
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            width: 180px;
            z-index: 1050;
            opacity: 0;
            transform: translateY(10px);
            pointer-events: none;
            transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 1px solid var(--border-color);
        }
        
        .panel-options-menu.active {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }
        
        .options-menu-arrow {
            position: absolute;
            top: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 16px;
            height: 8px;
            overflow: hidden;
        }
        
        .options-menu-arrow:after {
            content: "";
            position: absolute;
            width: 12px;
            height: 12px;
            background: var(--panel-color);
            transform: translateY(50%) rotate(45deg);
            top: 0;
            left: 2px;
            border-top: 1px solid var(--border-color);
            border-left: 1px solid var(--border-color);
        }
        
        .panel-options-menu ul {
            list-style: none;
            padding: 8px 0;
            margin: 0;
        }
        
        .panel-options-menu li {
            padding: 10px 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background-color 0.2s ease;
        }
        
        .panel-options-menu li:hover {
            background-color: var(--gray-7);
        }
        
        .panel-options-menu li i {
            width: 16px;
            text-align: center;
            color: var(--primary-color);
        }
        
        .panel-options-menu li.divider {
            height: 1px;
            padding: 0;
            margin: 8px 0;
            background-color: var(--border-color);
            cursor: default;
        }
        
        .panel-options-menu li.divider:hover {
            background-color: var(--border-color);
        }
    `;
    document.head.appendChild(style);
}

// Función para exportar datos de un panel
function exportPanelData(panel, panelTitle) {
    showNotification(`Exportando datos de ${panelTitle}...`);
    
    // Simular proceso de exportación
    setTimeout(() => {
        showNotification(`Datos de ${panelTitle} exportados correctamente`);
    }, 1500);
}

// Función para mostrar panel en pantalla completa
function togglePanelFullscreen(panel) {
    if (!panel.classList.contains('fullscreen')) {
        // Guardar posición original
        panel.dataset.originalIndex = Array.from(panel.parentNode.children).indexOf(panel);
        panel.dataset.originalParent = panel.parentNode.className;
        
        // Crear contenedor de pantalla completa si no existe
        let fullscreenContainer = document.querySelector('.panel-fullscreen-container');
        if (!fullscreenContainer) {
            fullscreenContainer = document.createElement('div');
            fullscreenContainer.className = 'panel-fullscreen-container';
            document.body.appendChild(fullscreenContainer);
            
            // Añadir estilos
            const style = document.createElement('style');
            style.textContent = `
                .panel-fullscreen-container {
                    position: fixed;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background-color: rgba(0, 0, 0, 0.8);
                    z-index: 1100;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 40px;
                    opacity: 0;
                    transition: opacity 0.3s ease;
                }
                
                .panel-fullscreen-container.show {
                    opacity: 1;
                }
                
                .panel-section.fullscreen {
                    width: 100%;
                    height: 100%;
                    margin: 0;
                    transform: none !important;
                    display: flex;
                    flex-direction: column;
                }
                
                .panel-section.fullscreen .panel-content {
                    flex: 1;
                    overflow: auto;
                    max-height: none;
                }
                
                .fullscreen-close {
                    position: absolute;
                    top: 20px;
                    right: 20px;
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                    background-color: var(--panel-color);
                    color: var(--text-color);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
                    border: none;
                    font-size: 18px;
                    z-index: 1101;
                }
                
                .fullscreen-close:hover {
                    background-color: var(--gray-7);
                }
            `;
            document.head.appendChild(style);
            
            // Añadir botón de cerrar
            const closeBtn = document.createElement('button');
            closeBtn.className = 'fullscreen-close';
            closeBtn.innerHTML = '<i class="fas fa-times"></i>';
            closeBtn.addEventListener('click', () => {
                const fullscreenPanel = document.querySelector('.panel-section.fullscreen');
                if (fullscreenPanel) {
                    exitPanelFullscreen(fullscreenPanel);
                }
            });
            fullscreenContainer.appendChild(closeBtn);
        }
        
        // Mover panel al contenedor de pantalla completa
        panel.classList.add('fullscreen');
        fullscreenContainer.appendChild(panel);
        
        // Mostrar contenedor
        setTimeout(() => {
            fullscreenContainer.classList.add('show');
        }, 10);
        
        // Añadir evento de escape
        document.addEventListener('keydown', handleEscapeKey);
    } else {
        exitPanelFullscreen(panel);
    }
}

// Función para salir del modo pantalla completa
function exitPanelFullscreen(panel) {
    const fullscreenContainer = document.querySelector('.panel-fullscreen-container');
    if (fullscreenContainer) {
        // Ocultar contenedor
        fullscreenContainer.classList.remove('show');
        
        setTimeout(() => {
            // Restaurar panel a su posición original
            panel.classList.remove('fullscreen');
            
            const originalParentClass = panel.dataset.originalParent;
            const originalParent = document.querySelector(`.${originalParentClass}`);
            const originalIndex = parseInt(panel.dataset.originalIndex || '0');
            
            if (originalParent) {
                if (originalIndex >= originalParent.children.length) {
                    originalParent.appendChild(panel);
                } else {
                    originalParent.insertBefore(panel, originalParent.children[originalIndex]);
                }
            }
            
            // Eliminar contenedor si está vacío
            if (!fullscreenContainer.querySelector('.panel-section')) {
                fullscreenContainer.remove();
            }
            
            // Eliminar evento de escape
            document.removeEventListener('keydown', handleEscapeKey);
        }, 300);
    }
}

// Manejador de tecla Escape
function handleEscapeKey(e) {
    if (e.key === 'Escape') {
        const fullscreenPanel = document.querySelector('.panel-section.fullscreen');
        if (fullscreenPanel) {
            exitPanelFullscreen(fullscreenPanel);
        }
    }
}

// Función para mostrar configuración de panel
function showPanelSettings(panel, panelTitle) {
    showNotification(`Configurando ${panelTitle}...`);
    
    // Aquí iría el código para mostrar un modal de configuración
}

// Función para mostrar personalización de accesos rápidos
function showCustomizeQuickAccess() {
    // Crear el diálogo
    const dialog = document.createElement('div');
    dialog.className = 'customize-dialog';
    
    dialog.innerHTML = `
        <div class="dialog-backdrop"></div>
        <div class="dialog-container">
            <div class="dialog-header">
                <h3>Personalizar accesos rápidos</h3>
                <button class="dialog-close"><i class="fas fa-times"></i></button>
            </div>
            <div class="dialog-body">
                <p class="dialog-description">Selecciona los accesos rápidos que quieres mostrar en el panel.</p>
                
                <div class="customize-options">
                    <div class="customize-item">
                        <input type="checkbox" id="access-users" checked>
                        <label for="access-users">
                            <i class="fas fa-users"></i>
                            <span>Usuarios</span>
                        </label>
                    </div>
                    <div class="customize-item">
                        <input type="checkbox" id="access-records" checked>
                        <label for="access-records">
                            <i class="fas fa-file-alt"></i>
                            <span>Registros</span>
                        </label>
                    </div>
                    <div class="customize-item">
                        <input type="checkbox" id="access-reports" checked>
                        <label for="access-reports">
                            <i class="fas fa-chart-bar"></i>
                            <span>Informes</span>
                        </label>
                    </div>
                    <div class="customize-item">
                        <input type="checkbox" id="access-settings" checked>
                        <label for="access-settings">
                            <i class="fas fa-cog"></i>
                            <span>Configuración</span>
                        </label>
                    </div>
                    <div class="customize-item">
                        <input type="checkbox" id="access-notifications" checked>
                        <label for="access-notifications">
                            <i class="fas fa-bell"></i>
                            <span>Notificaciones</span>
                        </label>
                    </div>
                    <div class="customize-item">
                        <input type="checkbox" id="access-help" checked>
                        <label for="access-help">
                            <i class="fas fa-question-circle"></i>
                            <span>Ayuda</span>
                        </label>
                    </div>
                    <div class="customize-item">
                        <input type="checkbox" id="access-calendar">
                        <label for="access-calendar">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Calendario</span>
                        </label>
                    </div>
                    <div class="customize-item">
                        <input type="checkbox" id="access-tasks">
                        <label for="access-tasks">
                            <i class="fas fa-tasks"></i>
                            <span>Tareas</span>
                        </label>
                    </div>
                    <div class="customize-item">
                        <input type="checkbox" id="access-messages">
                        <label for="access-messages">
                            <i class="fas fa-envelope"></i>
                            <span>Mensajes</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="dialog-footer">
                <button class="btn btn-secondary dialog-cancel">Cancelar</button>
                <button class="btn btn-primary dialog-apply">Aplicar</button>
            </div>
        </div>
    `;
    
    // Añadir al DOM
    document.body.appendChild(dialog);
    
    // Mostrar con animación
    setTimeout(() => {
        dialog.classList.add('show');
    }, 10);
    
    // Manejar cierre del diálogo
    const closeDialog = () => {
        dialog.classList.remove('show');
        setTimeout(() => {
            dialog.remove();
        }, 300);
    };
    
    // Eventos para cerrar
    dialog.querySelector('.dialog-close').addEventListener('click', closeDialog);
    dialog.querySelector('.dialog-cancel').addEventListener('click', closeDialog);
    dialog.querySelector('.dialog-backdrop').addEventListener('click', closeDialog);
    
    // Evento para aplicar
    dialog.querySelector('.dialog-apply').addEventListener('click', () => {
        // Recoger los accesos seleccionados
        const selectedAccesses = [];
        dialog.querySelectorAll('.customize-item input:checked').forEach(checkbox => {
            selectedAccesses.push({
                id: checkbox.id.replace('access-', ''),
                icon: checkbox.nextElementSibling.querySelector('i').className,
                label: checkbox.nextElementSibling.querySelector('span').textContent
            });
        });
        
        // Actualizar el panel de accesos rápidos
        updateQuickAccessPanel(selectedAccesses);
        
        // Cerrar diálogo
        closeDialog();
        
        showNotification('Accesos rápidos actualizados');
    });
    
    // Añadir estilos para el diálogo
    const style = document.createElement('style');
    style.textContent = `
        .customize-dialog {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1100;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .customize-dialog.show {
            opacity: 1;
        }
        
        .dialog-backdrop {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }
        
        .dialog-container {
            position: relative;
            background-color: var(--panel-color);
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transform: scale(0.95);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        .customize-dialog.show .dialog-container {
            transform: scale(1);
            opacity: 1;
        }
        
        .dialog-description {
            margin-top: 0;
            margin-bottom: 20px;
            color: var(--text-secondary);
        }
        
        .customize-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }
        
        .customize-item {
            position: relative;
        }
        
        .customize-item input {
            position: absolute;
            opacity: 0;
        }
        
        .customize-item label {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 16px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .customize-item label i {
            font-size: 24px;
            margin-bottom: 8px;
            color: var(--primary-color);
        }
        
        .customize-item input:checked + label {
            background-color: var(--primary-light);
            border-color: var(--primary-color);
        }
        
        .customize-item input:not(:checked) + label {
            opacity: 0.6;
        }
        
        .customize-item label:hover {
            border-color: var(--primary-color);
            opacity: 1;
        }
        
        @media (max-width: 576px) {
            .customize-options {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    `;
    document.head.appendChild(style);
}

// Función para actualizar el panel de accesos rápidos
function updateQuickAccessPanel(selectedAccesses) {
    const quickAccessGrid = document.querySelector('.quick-access-grid');
    if (quickAccessGrid) {
        // Limpiar el grid
        quickAccessGrid.innerHTML = '';
        
        // Añadir los accesos seleccionados
        selectedAccesses.forEach(access => {
            const accessItem = document.createElement('a');
            accessItem.href = '#';
            accessItem.className = 'quick-access-item';
            accessItem.innerHTML = `
                <div class="quick-access-icon">
                    <i class="${access.icon}"></i>
                </div>
                <div class="quick-access-label">${access.label}</div>
            `;
            quickAccessGrid.appendChild(accessItem);
        });
    }
}

// Función para mostrar todos los elementos
function showAllItems(panelTitle) {
    showNotification(`Mostrando todos los ${panelTitle.toLowerCase()}`);
    // Aquí iría el código para mostrar una página o modal con todos los elementos
}

// Función para manejar acciones de usuario
function handleUserAction(action, userName) {
    if (action === 'Ver perfil') {
        showNotification(`Viendo perfil de ${userName}`);
    } else if (action === 'Enviar mensaje') {
        showNotification(`Enviando mensaje a ${userName}`);
    }
}

// Función para marcar todas las notificaciones como leídas
function markAllNotificationsAsRead() {
    const unreadNotifications = document.querySelectorAll('.notification-item.unread');
    unreadNotifications.forEach(notification => {
        notification.classList.remove('unread');
    });
    
    showNotification('Todas las notificaciones marcadas como leídas');
}

// Función para mostrar notificaciones
function showNotification(message) {
    // Crear elemento de notificación
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    
    // Añadir al DOM
    document.body.appendChild(notification);
    
    // Mostrar con animación
    setTimeout(() => {
        notification.classList.add('show');
    }, 10);
    
    // Ocultar después de un tiempo
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}