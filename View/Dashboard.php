<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Panel de control</title>
        <link rel="icon" type="image/x-icon" href="Icono">
        <link rel="stylesheet" href="Estilos_Menu">
        <link rel="stylesheet" href="Estilos_Tablero">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@300;400;500;600&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500&display=swap">
        <!-- Fuentes adicionales -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body>
        <?php 
            /****************** MESSAGES ***********************/
            include_once(__DIR__ . '/Layout/FlashMessage.php');
            /************************************************/
        ?>

        <div class="dashboard-container">
            <!-- Sidebar -->
            <?php include 'Layout/HeaderLeft.php'; ?>

            <!-- Main Content -->
            <div class="main-content">
                <!-- Top Navigation Bar -->
                <?php include 'Layout/HeaderUp.php'; ?>

                <!-- Power BI Content -->
                <!--<div class="dashboard-content">-->
                    <!-- Sección de Inicio / Dashboard Principal -->
                <!--    <div class="dashboard-container">-->
                        <!-- Barra superior con acciones principales -->
                <!--        <div class="dashboard-topbar">-->
                <!--            <div class="dashboard-title">-->
                <!--                <h1>Panel de Control</h1>-->
                <!--            </div>-->
                <!--            <div class="dashboard-actions">-->
                <!--                <div class="date-range-selector">-->
                <!--                    <button class="btn-outline">-->
                <!--                        <i class="fas fa-calendar"></i>-->
                <!--                        <span>Últimos 30 días</span>-->
                <!--                        <i class="fas fa-chevron-down"></i>-->
                <!--                    </button>-->
                <!--                </div>-->
                <!--                <button class="btn btn-primary">-->
                <!--                    <i class="fas fa-sync-alt"></i>-->
                <!--                    <span>Actualizar datos</span>-->
                <!--                </button>-->
                <!--            </div>-->
                <!--        </div>-->

                        <!-- Sección de KPIs principales -->
                <!--        <div class="dashboard-kpi-section">-->
                <!--            <div class="kpi-card">-->
                <!--                <div class="kpi-icon">-->
                <!--                    <i class="fas fa-users"></i>-->
                <!--                </div>-->
                <!--                <div class="kpi-content">-->
                <!--                    <div class="kpi-label">Usuarios totales</div>-->
                <!--                    <div class="kpi-value">24,892</div>-->
                <!--                    <div class="kpi-trend positive">-->
                <!--                        <i class="fas fa-arrow-up"></i> 128 nuevos hoy-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--            </div>-->

                <!--            <div class="kpi-card">-->
                <!--                <div class="kpi-icon">-->
                <!--                    <i class="fas fa-file-alt"></i>-->
                <!--                </div>-->
                <!--                <div class="kpi-content">-->
                <!--                    <div class="kpi-label">Registros totales</div>-->
                <!--                    <div class="kpi-value">156,784</div>-->
                <!--                    <div class="kpi-trend positive">-->
                <!--                        <i class="fas fa-arrow-up"></i> 1,243 este mes-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--            </div>-->

                <!--            <div class="kpi-card">-->
                <!--                <div class="kpi-icon">-->
                <!--                    <i class="fas fa-chart-line"></i>-->
                <!--                </div>-->
                <!--                <div class="kpi-content">-->
                <!--                    <div class="kpi-label">Ingresos totales</div>-->
                <!--                    <div class="kpi-value">$1,458,290</div>-->
                <!--                    <div class="kpi-trend positive">-->
                <!--                        <i class="fas fa-arrow-up"></i> 12.5% vs mes anterior-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--            </div>-->

                <!--            <div class="kpi-card">-->
                <!--                <div class="kpi-icon">-->
                <!--                    <i class="fas fa-clock"></i>-->
                <!--                </div>-->
                <!--                <div class="kpi-content">-->
                <!--                    <div class="kpi-label">Tiempo promedio</div>-->
                <!--                    <div class="kpi-value">18.5 min</div>-->
                <!--                    <div class="kpi-trend negative">-->
                <!--                        <i class="fas fa-arrow-down"></i> 2.3 min vs mes anterior-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--            </div>-->
                <!--        </div>-->

                        <!-- Sección principal de contenido -->
                <!--        <div class="dashboard-main-section">-->
                            <!-- Panel izquierdo -->
                <!--            <div class="dashboard-panel left-panel">-->
                                <!-- Usuarios recientes -->
                <!--                <div class="panel-section">-->
                <!--                    <div class="panel-header">-->
                <!--                        <h2><i class="fas fa-user-friends"></i> Usuarios recientes</h2>-->
                <!--                        <div class="panel-actions">-->
                <!--                            <button class="btn-icon" title="Refrescar"><i class="fas fa-sync-alt"></i></button>-->
                <!--                            <button class="btn-icon" title="Más opciones"><i class="fas fa-ellipsis-v"></i></button>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                    <div class="panel-content">-->
                <!--                        <div class="user-list">-->
                <!--                            <div class="user-item">-->
                <!--                                <div class="user-avatar">-->
                <!--                                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Usuario">-->
                <!--                                    <span class="status-indicator online"></span>-->
                <!--                                </div>-->
                <!--                                <div class="user-info">-->
                <!--                                    <div class="user-name">Carlos Rodríguez</div>-->
                <!--                                    <div class="user-email">carlos.rodriguez@ejemplo.com</div>-->
                <!--                                </div>-->
                <!--                                <div class="user-actions">-->
                <!--                                    <button class="btn-icon" title="Ver perfil"><i class="fas fa-eye"></i></button>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <div class="user-item">-->
                <!--                                <div class="user-avatar">-->
                <!--                                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Usuario">-->
                <!--                                    <span class="status-indicator offline"></span>-->
                <!--                                </div>-->
                <!--                                <div class="user-info">-->
                <!--                                    <div class="user-name">María López</div>-->
                <!--                                    <div class="user-email">maria.lopez@ejemplo.com</div>-->
                <!--                                </div>-->
                <!--                                <div class="user-actions">-->
                <!--                                    <button class="btn-icon" title="Ver perfil"><i class="fas fa-eye"></i></button>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <div class="user-item">-->
                <!--                                <div class="user-avatar">-->
                <!--                                    <img src="https://randomuser.me/api/portraits/men/67.jpg" alt="Usuario">-->
                <!--                                    <span class="status-indicator online"></span>-->
                <!--                                </div>-->
                <!--                                <div class="user-info">-->
                <!--                                    <div class="user-name">Juan Martínez</div>-->
                <!--                                    <div class="user-email">juan.martinez@ejemplo.com</div>-->
                <!--                                </div>-->
                <!--                                <div class="user-actions">-->
                <!--                                    <button class="btn-icon" title="Ver perfil"><i class="fas fa-eye"></i></button>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                        <div class="panel-footer">-->
                <!--                            <button class="btn-text">Ver todos los usuarios</button>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->

                                <!-- Actividad reciente -->
                <!--                <div class="panel-section">-->
                <!--                    <div class="panel-header">-->
                <!--                        <h2><i class="fas fa-history"></i> Actividad reciente</h2>-->
                <!--                        <div class="panel-actions">-->
                <!--                            <button class="btn-icon" title="Refrescar"><i class="fas fa-sync-alt"></i></button>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                    <div class="panel-content">-->
                <!--                        <div class="activity-list">-->
                <!--                            <div class="activity-item">-->
                <!--                                <div class="activity-time">10:45 AM</div>-->
                <!--                                <div class="activity-icon">-->
                <!--                                    <i class="fas fa-user-plus"></i>-->
                <!--                                </div>-->
                <!--                                <div class="activity-content">-->
                <!--                                    <div class="activity-title">Nuevo usuario registrado</div>-->
                <!--                                    <div class="activity-details">Pedro Sánchez se ha unido al sistema</div>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <div class="activity-item">-->
                <!--                                <div class="activity-time">09:32 AM</div>-->
                <!--                                <div class="activity-icon">-->
                <!--                                    <i class="fas fa-file-upload"></i>-->
                <!--                                </div>-->
                <!--                                <div class="activity-content">-->
                <!--                                    <div class="activity-title">Nuevo documento subido</div>-->
                <!--                                    <div class="activity-details">María López subió "Informe Trimestral.pdf"</div>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <div class="activity-item">-->
                <!--                                <div class="activity-time">Ayer</div>-->
                <!--                                <div class="activity-icon">-->
                <!--                                    <i class="fas fa-edit"></i>-->
                <!--                                </div>-->
                <!--                                <div class="activity-content">-->
                <!--                                    <div class="activity-title">Registro actualizado</div>-->
                <!--                                    <div class="activity-details">Carlos Rodríguez actualizó el registro #45982</div>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                        <div class="panel-footer">-->
                <!--                            <button class="btn-text">Ver toda la actividad</button>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--            </div>-->

                            <!-- Panel central -->
                <!--            <div class="dashboard-panel center-panel">-->
                                <!-- Registros recientes -->
                <!--                <div class="panel-section">-->
                <!--                    <div class="panel-header">-->
                <!--                        <h2><i class="fas fa-clipboard-list"></i> Registros recientes</h2>-->
                <!--                        <div class="panel-actions">-->
                <!--                            <button class="btn-icon" title="Refrescar"><i class="fas fa-sync-alt"></i></button>-->
                <!--                            <button class="btn-icon" title="Más opciones"><i class="fas fa-ellipsis-v"></i></button>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                    <div class="panel-content">-->
                <!--                        <div class="records-list">-->
                <!--                            <div class="record-item">-->
                <!--                                <div class="record-icon">-->
                <!--                                    <i class="fas fa-file-invoice"></i>-->
                <!--                                </div>-->
                <!--                                <div class="record-info">-->
                <!--                                    <div class="record-title">Informe de ventas - Q2 2023</div>-->
                <!--                                    <div class="record-meta">-->
                <!--                                        <span class="record-date">15/06/2023</span>-->
                <!--                                    </div>-->
                <!--                                </div>-->
                <!--                                <div class="record-status">-->
                <!--                                    <span class="status-badge completed">Completado</span>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <div class="record-item">-->
                <!--                                <div class="record-icon">-->
                <!--                                    <i class="fas fa-chart-pie"></i>-->
                <!--                                </div>-->
                <!--                                <div class="record-info">-->
                <!--                                    <div class="record-title">Análisis de mercado</div>-->
                <!--                                    <div class="record-meta">-->
                <!--                                        <span class="record-date">10/06/2023</span>-->
                <!--                                    </div>-->
                <!--                                </div>-->
                <!--                                <div class="record-status">-->
                <!--                                    <span class="status-badge in-progress">En progreso</span>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <div class="record-item">-->
                <!--                                <div class="record-icon">-->
                <!--                                    <i class="fas fa-users"></i>-->
                <!--                                </div>-->
                <!--                                <div class="record-info">-->
                <!--                                    <div class="record-title">Encuesta de satisfacción</div>-->
                <!--                                    <div class="record-meta">-->
                <!--                                        <span class="record-date">05/06/2023</span>-->
                <!--                                    </div>-->
                <!--                                </div>-->
                <!--                                <div class="record-status">-->
                <!--                                    <span class="status-badge completed">Completado</span>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <div class="record-item">-->
                <!--                                <div class="record-icon">-->
                <!--                                    <i class="fas fa-tasks"></i>-->
                <!--                                </div>-->
                <!--                                <div class="record-info">-->
                <!--                                    <div class="record-title">Planificación de proyecto</div>-->
                <!--                                    <div class="record-meta">-->
                <!--                                        <span class="record-date">01/06/2023</span>-->
                <!--                                    </div>-->
                <!--                                </div>-->
                <!--                                <div class="record-status">-->
                <!--                                    <span class="status-badge pending">Pendiente</span>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <div class="record-item">-->
                <!--                                <div class="record-icon">-->
                <!--                                    <i class="fas fa-file-contract"></i>-->
                <!--                                </div>-->
                <!--                                <div class="record-info">-->
                <!--                                    <div class="record-title">Contrato de servicios</div>-->
                <!--                                    <div class="record-meta">-->
                <!--                                        <span class="record-date">28/05/2023</span>-->
                <!--                                    </div>-->
                <!--                                </div>-->
                <!--                                <div class="record-status">-->
                <!--                                    <span class="status-badge completed">Completado</span>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                        <div class="panel-footer">-->
                <!--                            <button class="btn-text">Ver todos los registros</button>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--            </div>-->

                            <!-- Panel derecho -->
                <!--            <div class="dashboard-panel right-panel">-->
                                <!-- Accesos rápidos -->
                <!--                <div class="panel-section">-->
                <!--                    <div class="panel-header">-->
                <!--                        <h2><i class="fas fa-bolt"></i> Accesos rápidos</h2>-->
                <!--                        <div class="panel-actions">-->
                <!--                            <button class="btn-icon" title="Personalizar"><i class="fas fa-cog"></i></button>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                    <div class="panel-content">-->
                <!--                        <div class="quick-access-grid">-->
                <!--                            <a href="#" class="quick-access-item">-->
                <!--                                <div class="quick-access-icon">-->
                <!--                                    <i class="fas fa-users"></i>-->
                <!--                                </div>-->
                <!--                                <div class="quick-access-label">Usuarios</div>-->
                <!--                            </a>-->
                <!--                            <a href="#" class="quick-access-item">-->
                <!--                                <div class="quick-access-icon">-->
                <!--                                    <i class="fas fa-file-alt"></i>-->
                <!--                                </div>-->
                <!--                                <div class="quick-access-label">Registros</div>-->
                <!--                            </a>-->
                <!--                            <a href="#" class="quick-access-item">-->
                <!--                                <div class="quick-access-icon">-->
                <!--                                    <i class="fas fa-chart-bar"></i>-->
                <!--                                </div>-->
                <!--                                <div class="quick-access-label">Informes</div>-->
                <!--                            </a>-->
                <!--                            <a href="#" class="quick-access-item">-->
                <!--                                <div class="quick-access-icon">-->
                <!--                                    <i class="fas fa-cog"></i>-->
                <!--                                </div>-->
                <!--                                <div class="quick-access-label">Configuración</div>-->
                <!--                            </a>-->
                <!--                            <a href="#" class="quick-access-item">-->
                <!--                                <div class="quick-access-icon">-->
                <!--                                    <i class="fas fa-bell"></i>-->
                <!--                                </div>-->
                <!--                                <div class="quick-access-label">Notificaciones</div>-->
                <!--                            </a>-->
                <!--                            <a href="#" class="quick-access-item">-->
                <!--                                <div class="quick-access-icon">-->
                <!--                                    <i class="fas fa-question-circle"></i>-->
                <!--                                </div>-->
                <!--                                <div class="quick-access-label">Ayuda</div>-->
                <!--                            </a>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->

                                <!-- Estado del sistema -->
                <!--                <div class="panel-section">-->
                <!--                    <div class="panel-header">-->
                <!--                        <h2><i class="fas fa-server"></i> Estado del sistema</h2>-->
                <!--                        <div class="panel-actions">-->
                <!--                            <button class="btn-icon" title="Refrescar"><i class="fas fa-sync-alt"></i></button>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                    <div class="panel-content">-->
                <!--                        <div class="system-status-list">-->
                <!--                            <div class="status-item">-->
                <!--                                <div class="status-label">Servidor principal</div>-->
                <!--                                <div class="status-value">-->
                <!--                                    <span class="status-indicator online"></span>-->
                <!--                                    <span>Operativo (99.9%)</span>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <div class="status-item">-->
                <!--                                <div class="status-label">Base de datos</div>-->
                <!--                                <div class="status-value">-->
                <!--                                    <span class="status-indicator online"></span>-->
                <!--                                    <span>Operativa (100%)</span>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <div class="status-item">-->
                <!--                                <div class="status-label">API</div>-->
                <!--                                <div class="status-value">-->
                <!--                                    <span class="status-indicator online"></span>-->
                <!--                                    <span>Operativa (98.5%)</span>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <div class="status-item">-->
                <!--                                <div class="status-label">Almacenamiento</div>-->
                <!--                                <div class="status-value">-->
                <!--                                    <span class="status-indicator warning"></span>-->
                <!--                                    <span>75% utilizado</span>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <div class="status-item">-->
                <!--                                <div class="status-label">Última actualización</div>-->
                <!--                                <div class="status-value">Hoy, 08:15 AM</div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->

                                <!-- Notificaciones -->
                <!--                <div class="panel-section">-->
                <!--                    <div class="panel-header">-->
                <!--                        <h2><i class="fas fa-bell"></i> Notificaciones</h2>-->
                <!--                        <div class="panel-actions">-->
                <!--                            <button class="btn-icon" title="Marcar todas como leídas"><i class="fas fa-check-double"></i></button>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                    <div class="panel-content">-->
                <!--                        <div class="notification-list">-->
                <!--                            <div class="notification-item unread">-->
                <!--                                <div class="notification-icon warning">-->
                <!--                                    <i class="fas fa-exclamation-triangle"></i>-->
                <!--                                </div>-->
                <!--                                <div class="notification-content">-->
                <!--                                    <div class="notification-title">Espacio de almacenamiento bajo</div>-->
                <!--                                    <div class="notification-details">El almacenamiento está al 75% de capacidad</div>-->
                <!--                                    <div class="notification-time">Hace 35 minutos</div>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <div class="notification-item unread">-->
                <!--                                <div class="notification-icon info">-->
                <!--                                    <i class="fas fa-info-circle"></i>-->
                <!--                                </div>-->
                <!--                                <div class="notification-content">-->
                <!--                                    <div class="notification-title">Actualización disponible</div>-->
                <!--                                    <div class="notification-details">Nueva versión 2.5.3 disponible para instalar</div>-->
                <!--                                    <div class="notification-time">Hace 2 horas</div>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <div class="notification-item">-->
                <!--                                <div class="notification-icon success">-->
                <!--                                    <i class="fas fa-check-circle"></i>-->
                <!--                                </div>-->
                <!--                                <div class="notification-content">-->
                <!--                                    <div class="notification-title">Copia de seguridad completada</div>-->
                <!--                                    <div class="notification-details">La copia de seguridad diaria se completó con éxito</div>-->
                <!--                                    <div class="notification-time">Ayer</div>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                        <div class="panel-footer">-->
                <!--                            <button class="btn-text">Ver todas las notificaciones</button>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
            </div>
        </div>
        <script src="Funcion_Menu"></script>
        <script src="Funcion_Tablero"></script>
        <script src="Funcion_Sincronizacion"></script>
    </body>
</html>