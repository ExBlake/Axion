<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
    <link rel="icon" type="image/x-icon" href="Icono">
    <link rel="stylesheet" href="Estilos_Menu">
    <link rel="stylesheet" href="Estilos_Reportes">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500&display=swap">
    <!-- Fuentes adicionales -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&display=swap">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php include 'Layout/HeaderLeft.php'; ?>
        <!-- Main Content -->
        <div class="main-content">
          

            <!-- Reports Content -->
            <div class="dashboard-content">
                <div class="section-header">
                    <h1>Informes Power BI</h1>
                    <div class="header-actions">
                        <button id="add-report-btn-main" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            <span>Nuevo Informe</span>
                        </button>
                    </div>
                </div>

                <!-- Reports Filters and Actions -->
                <div class="reports-actions">
                    <div class="search-filter">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" placeholder="Buscar informes..." id="report-search">
                            <button class="clear-search" id="clear-search" title="Clear search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="view-actions">
                        <div class="view-toggle">
                            <button class="view-option active" data-view="grid" title="Vista de cuadrícula">
                                <i class="fas fa-th-large"></i>
                            </button>
                            <button class="view-option" data-view="list" title="Vista de lista">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Reports Grid View (Default) -->
                <div class="reports-grid" id="reports-grid">
                    <!-- Sample Report Cards -->
                    <div class="report-card" 
                         data-id="1"
                         data-company="Apple Inc."
                         data-name="Dashboard Financiero Q4 2024"
                         data-url="https://app.powerbi.com/view?r=eyJrIjoiYWJjZGVmZ2hpams"
                         data-status="Activo"
                         data-type="Financiero"
                         data-priority="Alta"
                         data-description="Dashboard completo de análisis financiero para el cuarto trimestre de 2024, incluyendo métricas de ingresos, gastos y proyecciones."
                         data-created="15/01/2024"
                         data-updated="20/01/2024"
                         data-author="Juan Pérez"
                         data-department="Finanzas"
                         data-plan="Enterprise Pro"
                         data-last-sync="2024-01-20T14:30:00">
                        
                        
                        <div class="report-card-header">
    <div class="report-title-section">
        <h3>Dashboard Financiero Q4 2024</h3>
        <div class="report-company">
            <i class="fas fa-building"></i>
            <span>Apple Inc.</span>
        </div>
    </div>
    <div class="report-status-badge-large active">
        <span>Activo</span>
    </div>
</div>
                        
                        <div class="report-description">
                            <p>Dashboard completo de análisis financiero para el cuarto trimestre de 2024, incluyendo métricas de ingresos, gastos y proyecciones.</p>
                        </div>
                        
                        <div class="report-tags">
                            <span class="report-type financial">Financiero</span>
                            <span class="report-priority high">Alta Prioridad</span>
                            <span class="report-plan enterprise-pro">Enterprise Pro</span>
                        </div>

                        <div class="report-sync-status">
                            <div class="sync-info">
                                <i class="fas fa-sync-alt synced"></i>
                                <span class="sync-text">Actualizado: 20/01/2024 - 14:30</span>
                            </div>
                        </div>
                        
                        <div class="report-details-grid">
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-link"></i>
                                    <span>URL Power BI</span>
                                </div>
                                <div class="detail-value">
                                    <span class="url-preview">app.powerbi.com/view?r=eyJr...</span>
                                    <button class="copy-url-btn" title="Copiar URL">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-user"></i>
                                    <span>Autor</span>
                                </div>
                                <div class="detail-value">Juan Pérez</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-sitemap"></i>
                                    <span>Departamento</span>
                                </div>
                                <div class="detail-value">Finanzas</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-calendar-plus"></i>
                                    <span>Creado</span>
                                </div>
                                <div class="detail-value">15/01/2024</div>
                            </div>
                        </div>

                        <div class="report-actions">
                            <button class="btn-icon edit-report-btn" title="Editar">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button class="btn-icon view-report-btn" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon open-powerbi-btn" title="Abrir en Power BI" data-url="https://app.powerbi.com/view?r=eyJrIjoiYWJjZGVmZ2hpams">
                                <i class="fas fa-external-link-alt"></i>
                            </button>
                        </div>
                    </div>

                    <div class="report-card" 
                         data-id="2"
                         data-company="Microsoft"
                         data-name="Análisis de Ventas Regional"
                         data-url="https://app.powerbi.com/view?r=eyJrIjoieHl6YWJjZGVmZ2g"
                         data-status="En Revisión"
                         data-type="Ventas"
                         data-priority="Media"
                         data-description="Reporte detallado de ventas por región con comparativas mensuales y análisis de tendencias de mercado."
                         data-created="18/01/2024"
                         data-updated="22/01/2024"
                         data-author="María González"
                         data-department="Ventas"
                         data-plan="Professional"
                         data-last-sync="2024-01-18T09:15:00">
                        
                        
                        <div class="report-card-header">
    <div class="report-title-section">
        <h3>Análisis de Ventas Regional</h3>
        <div class="report-company">
            <i class="fas fa-building"></i>
            <span>Microsoft</span>
        </div>
    </div>
    <div class="report-status-badge-large active">

        <span>Activo</span>
    </div>
</div>
                        
                        <div class="report-description">
                            <p>Reporte detallado de ventas por región con comparativas mensuales y análisis de tendencias de mercado.</p>
                        </div>
                        
                        <div class="report-tags">
                            <span class="report-type sales">Ventas</span>
                            <span class="report-priority medium">Media Prioridad</span>
                            <span class="report-plan professional">Professional</span>
                        </div>

                        <div class="report-sync-status">
                            <div class="sync-info outdated">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span class="sync-text">Desactualizado: 18/01/2024 - 09:15</span>
                            </div>
                        </div>
                        
                        <div class="report-details-grid">
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-link"></i>
                                    <span>URL Power BI</span>
                                </div>
                                <div class="detail-value">
                                    <span class="url-preview">app.powerbi.com/view?r=eyJr...</span>
                                    <button class="copy-url-btn" title="Copiar URL">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-user"></i>
                                    <span>Autor</span>
                                </div>
                                <div class="detail-value">María González</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-sitemap"></i>
                                    <span>Departamento</span>
                                </div>
                                <div class="detail-value">Ventas</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-calendar-plus"></i>
                                    <span>Creado</span>
                                </div>
                                <div class="detail-value">18/01/2024</div>
                            </div>
                        </div>

                        <div class="report-actions">
                            <button class="btn-icon edit-report-btn" title="Editar">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button class="btn-icon view-report-btn" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon open-powerbi-btn" title="Abrir en Power BI" data-url="https://app.powerbi.com/view?r=eyJrIjoieHl6YWJjZGVmZ2g">
                                <i class="fas fa-external-link-alt"></i>
                            </button>
                        </div>
                    </div>

                    <div class="report-card" 
                         data-id="3"
                         data-company="Google"
                         data-name="Dashboard de Recursos Humanos"
                         data-url="https://app.powerbi.com/view?r=eyJrIjoicXdlcnR5dWlvcA"
                         data-status="Inactivo"
                         data-type="RRHH"
                         data-priority="Baja"
                         data-description="Panel de control para gestión de recursos humanos con métricas de empleados, rotación y satisfacción laboral."
                         data-created="20/01/2024"
                         data-updated="20/01/2024"
                         data-author="Carlos Rodríguez"
                         data-department="Recursos Humanos"
                         data-plan="Basic"
                         data-last-sync="2024-01-15T16:45:00">
                        
                        
                        <div class="report-card-header">
    <div class="report-title-section">
        <h3>Dashboard de Recursos Humanos</h3>
        <div class="report-company">
            <i class="fas fa-building"></i>
            <span>Google</span>
        </div>
    </div>
    <div class="report-status-badge-large inactive">

        <span>Inactivo</span>
    </div>
</div>
                        
                        <div class="report-description">
                            <p>Panel de control para gestión de recursos humanos con métricas de empleados, rotación y satisfacción laboral.</p>
                        </div>
                        
                        <div class="report-tags">
                            <span class="report-type hr">RRHH</span>
                            <span class="report-priority low">Baja Prioridad</span>
                            <span class="report-plan basic">Basic</span>
                        </div>

                        <div class="report-sync-status">
                            <div class="sync-info error">
                                <i class="fas fa-times-circle"></i>
                                <span class="sync-text">Sin sincronizar: 15/01/2024 - 16:45</span>
                            </div>
                        </div>
                        
                        <div class="report-details-grid">
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-link"></i>
                                    <span>URL Power BI</span>
                                </div>
                                <div class="detail-value">
                                    <span class="url-preview">app.powerbi.com/view?r=eyJr...</span>
                                    <button class="copy-url-btn" title="Copiar URL">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-user"></i>
                                    <span>Autor</span>
                                </div>
                                <div class="detail-value">Carlos Rodríguez</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-sitemap"></i>
                                    <span>Departamento</span>
                                </div>
                                <div class="detail-value">Recursos Humanos</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">
                                    <i class="fas fa-calendar-plus"></i>
                                    <span>Creado</span>
                                </div>
                                <div class="detail-value">20/01/2024</div>
                            </div>
                        </div>

                        <div class="report-actions">
                            <button class="btn-icon edit-report-btn" title="Editar">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button class="btn-icon view-report-btn" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon open-powerbi-btn" title="Abrir en Power BI" data-url="https://app.powerbi.com/view?r=eyJrIjoicXdlcnR5dWlvcA">
                                <i class="fas fa-external-link-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Reports List View (Hidden by default) -->
                <div class="reports-list" id="reports-list">
                    <div class="reports-table">
                        <div class="table-row table-header">
                            <div class="table-cell cell-name">Nombre del Informe</div>
                            <div class="table-cell cell-company">Empresa</div>
                            <div class="table-cell cell-type">Tipo</div>
                            <div class="table-cell cell-author">Autor</div>
                            <div class="table-cell cell-status">Estado</div>
                            <div class="table-cell cell-plan">Plan</div>
                            <div class="table-cell cell-updated">Actualizado</div>
                            <div class="table-cell cell-actions">Acciones</div>
                        </div>

                        <div class="table-row"
                             data-id="1"
                             data-company="Apple Inc."
                             data-name="Dashboard Financiero Q4 2024"
                             data-url="https://app.powerbi.com/view?r=eyJrIjoiYWJjZGVmZ2hpams"
                             data-status="Activo"
                             data-type="Financiero"
                             data-priority="Alta"
                             data-description="Dashboard completo de análisis financiero para el cuarto trimestre de 2024"
                             data-created="15/01/2024"
                             data-updated="20/01/2024"
                             data-author="Juan Pérez"
                             data-department="Finanzas"
                             data-plan="Enterprise Pro"
                             data-last-sync="2024-01-20T14:30:00">

                            <div class="table-cell cell-name">
                                <div class="report-name-cell">
                                    <span class="report-title">Dashboard Financiero Q4 2024</span>
                                    <span class="report-url">app.powerbi.com/view?r=eyJr...</span>
                                </div>
                            </div>
                            <div class="table-cell cell-company">Apple Inc.</div>
                            <div class="table-cell cell-type">
                                <span class="type-badge financial">Financiero</span>
                            </div>
                            <div class="table-cell cell-author">Juan Pérez</div>
                            <div class="table-cell cell-status">
                                <div class="status-badge-with-sync active">
                                    <span class="status-badge active">Activo</span>
                                    <span class="sync-indicator-small synced">●</span>
                                </div>
                            </div>
                            <div class="table-cell cell-plan">
                                <span class="plan-badge enterprise-pro">Enterprise Pro</span>
                            </div>
                            <div class="table-cell cell-updated">20/01/2024 14:30</div>
                            <div class="table-cell cell-actions">
                                <button class="btn-icon edit-report-btn" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="btn-icon view-report-btn" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-icon open-powerbi-btn" title="Abrir en Power BI" data-url="https://app.powerbi.com/view?r=eyJrIjoiYWJjZGVmZ2hpams">
                                    <i class="fas fa-external-link-alt"></i>
                                </button>
                            </div>
                        </div>

                        <div class="table-row"
                             data-id="2"
                             data-company="Microsoft"
                             data-name="Análisis de Ventas Regional"
                             data-url="https://app.powerbi.com/view?r=eyJrIjoieHl6YWJjZGVmZ2g"
                             data-status="En Revisión"
                             data-type="Ventas"
                             data-priority="Media"
                             data-description="Reporte detallado de ventas por región con comparativas mensuales"
                             data-created="18/01/2024"
                             data-updated="22/01/2024"
                             data-author="María González"
                             data-department="Ventas"
                             data-plan="Professional"
                             data-last-sync="2024-01-18T09:15:00">

                            <div class="table-cell cell-name">
                                <div class="report-name-cell">
                                    <span class="report-title">Análisis de Ventas Regional</span>
                                    <span class="report-url">app.powerbi.com/view?r=eyJr...</span>
                                </div>
                            </div>
                            <div class="table-cell cell-company">Microsoft</div>
                            <div class="table-cell cell-type">
                                <span class="type-badge sales">Ventas</span>
                            </div>
                            <div class="table-cell cell-author">María González</div>
                            <div class="table-cell cell-status">
                                <div class="status-badge-with-sync review">
                                    <span class="status-badge review">En Revisión</span>
                                    <span class="sync-indicator-small outdated">●</span>
                                </div>
                            </div>
                            <div class="table-cell cell-plan">
                                <span class="plan-badge professional">Professional</span>
                            </div>
                            <div class="table-cell cell-updated">18/01/2024 09:15</div>
                            <div class="table-cell cell-actions">
                                <button class="btn-icon edit-report-btn" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="btn-icon view-report-btn" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-icon open-powerbi-btn" title="Abrir en Power BI" data-url="https://app.powerbi.com/view?r=eyJrIjoieHl6YWJjZGVmZ2g">
                                    <i class="fas fa-external-link-alt"></i>
                                </button>
                            </div>
                        </div>

                        <div class="table-row"
                             data-id="3"
                             data-company="Google"
                             data-name="Dashboard de Recursos Humanos"
                             data-url="https://app.powerbi.com/view?r=eyJrIjoicXdlcnR5dWlvcA"
                             data-status="Inactivo"
                             data-type="RRHH"
                             data-priority="Baja"
                             data-description="Panel de control para gestión de recursos humanos"
                             data-created="20/01/2024"
                             data-updated="20/01/2024"
                             data-author="Carlos Rodríguez"
                             data-department="Recursos Humanos"
                             data-plan="Basic"
                             data-last-sync="2024-01-15T16:45:00">

                            <div class="table-cell cell-name">
                                <div class="report-name-cell">
                                    <span class="report-title">Dashboard de Recursos Humanos</span>
                                    <span class="report-url">app.powerbi.com/view?r=eyJr...</span>
                                </div>
                            </div>
                            <div class="table-cell cell-company">Google</div>
                            <div class="table-cell cell-type">
                                <span class="type-badge hr">RRHH</span>
                            </div>
                            <div class="table-cell cell-author">Carlos Rodríguez</div>
                            <div class="table-cell cell-status">
                                <div class="status-badge-with-sync inactive">
                                    <span class="status-badge inactive">Inactivo</span>
                                    <span class="sync-indicator-small error">●</span>
                                </div>
                            </div>
                            <div class="table-cell cell-plan">
                                <span class="plan-badge basic">Basic</span>
                            </div>
                            <div class="table-cell cell-updated">15/01/2024 16:45</div>
                            <div class="table-cell cell-actions">
                                <button class="btn-icon edit-report-btn" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="btn-icon view-report-btn" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-icon open-powerbi-btn" title="Abrir en Power BI" data-url="https://app.powerbi.com/view?r=eyJrIjoicXdlcnR5dWlvcA">
                                    <i class="fas fa-external-link-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para añadir/editar informe -->
    <div class="modal" id="report-modal">
        <div class="modal-backdrop"></div>
        <div class="modal-container">
            <div class="modal-header">
                <h2 id="modal-title">Nuevo Informe Power BI</h2>
                <button class="modal-close" id="modal-close" title="Cerrar modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="report-form">
                    <input type="hidden" id="report-id">
                    <div class="form-group">
                        <label for="report-name">Nombre del Informe</label>
                        <input type="text" id="report-name" class="form-input" placeholder="Ej: Dashboard Financiero Q4 2024" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="report-company">Empresa</label>
                            <select id="report-company" class="form-select" required>
                                <option value="">Seleccionar empresa</option>
                                <option value="Apple Inc.">Apple Inc.</option>
                                <option value="Microsoft">Microsoft</option>
                                <option value="Google">Google</option>
                                <option value="Amazon">Amazon</option>
                                <option value="Meta">Meta</option>
                                <option value="Netflix">Netflix</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="report-type">Tipo de Informe</label>
                            <select id="report-type" class="form-select" required>
                                <option value="">Seleccionar tipo</option>
                                <option value="Financiero">Financiero</option>
                                <option value="Ventas">Ventas</option>
                                <option value="Marketing">Marketing</option>
                                <option value="RRHH">Recursos Humanos</option>
                                <option value="Operaciones">Operaciones</option>
                                <option value="Inventario">Inventario</option>
                                <option value="Calidad">Calidad</option>
                                <option value="Estratégico">Estratégico</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="report-url">URL de Power BI</label>
                        <input type="url" id="report-url" class="form-input" placeholder="https://app.powerbi.com/view?r=..." required>
                        <small class="form-help">Pegue aquí la URL completa del informe de Power BI</small>
                    </div>
                    <div class="form-group">
                        <label for="report-description">Descripción</label>
                        <textarea id="report-description" class="form-textarea" placeholder="Descripción detallada del informe y su propósito" required></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="report-author">Autor</label>
                            <input type="text" id="report-author" class="form-input" placeholder="Nombre del autor" required>
                        </div>
                        <div class="form-group">
                            <label for="report-department">Departamento</label>
                            <input type="text" id="report-department" class="form-input" placeholder="Departamento responsable" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="report-priority">Prioridad</label>
                            <select id="report-priority" class="form-select" required>
                                <option value="Baja">Baja</option>
                                <option value="Media" selected>Media</option>
                                <option value="Alta">Alta</option>
                            </select>
                        </div>
                        
<div class="form-group">
    <label for="report-status">Estado</label>
    <select id="report-status" class="form-select" required>
        <option value="Activo" selected>Activo</option>
        <option value="Inactivo">Inactivo</option>
    </select>
</div>
                    </div>
                    <div class="form-group">
                        <label for="report-plan">Plan Asociado</label>
                        <select id="report-plan" class="form-select" required>
                            <option value="Basic">Basic</option>
                            <option value="Professional">Professional</option>
                            <option value="Enterprise">Enterprise</option>
                            <option value="Enterprise Pro" selected>Enterprise Pro</option>
                        </select>
                    </div>
                    <input type="hidden" id="action-form" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="cancel-report">Cancelar</button>
                <button class="btn btn-primary" id="save-report" style="display: none;">Guardar</button>
                <button class="btn btn-primary" id="edit-report" style="display: none;">Actualizar</button>
            </div>
        </div>
    </div>

    <!-- Modal para ver detalles del informe -->
    <div class="modal" id="report-details-modal">
        <div class="modal-backdrop"></div>
        <div class="modal-container">
            <div class="modal-header">
                <h2 id="details-modal-title">Detalles del Informe</h2>
                <button class="modal-close" id="details-modal-close" title="Cerrar detalles">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <!-- Advertencia de Seguridad -->
                <div class="security-warning">
                    <div class="warning-header">
                        <i class="fas fa-shield-alt"></i>
                        <h4>Información Confidencial</h4>
                    </div>
                    <p>⚠️ <strong>IMPORTANTE:</strong> Este enlace de Power BI contiene información confidencial y NO debe ser compartido con personas no autorizadas. El acceso no autorizado puede comprometer datos sensibles de la empresa.</p>
                </div>

                <div class="report-details-header">
                    <div class="report-details-info">
                        <h3 id="details-name">Nombre del Informe</h3>
                        <div class="details-company">
                            <i class="fas fa-building"></i>
                            <span id="details-company">Empresa</span>
                        </div>
                        <div class="details-tags">
                            <span class="report-type" id="details-type">Tipo</span>
                            <span class="report-status" id="details-status">Estado</span>
                            <span class="report-priority" id="details-priority">Prioridad</span>
                        </div>
                    </div>
                    <div class="report-details-actions">
                        <button class="btn btn-secondary" id="copy-url-details">
                            <i class="fas fa-copy"></i>
                            <span>Copiar URL</span>
                        </button>
                        <button class="btn btn-primary" id="open-powerbi-details">
                            <i class="fas fa-external-link-alt"></i>
                            <span>Abrir en Power BI</span>
                        </button>
                    </div>
                </div>

                <div class="report-details-section">
                    <h4>Plan Asociado</h4>
                    <div class="plan-info">
                        <span class="plan-badge-large" id="details-plan-badge">Enterprise Pro</span>
                        <span class="plan-description" id="details-plan-description">Acceso completo a todas las funcionalidades</span>
                    </div>
                </div>

                <div class="report-details-section">
                    <h4>Estado de Sincronización</h4>
                    <div class="sync-details-large">
                        <div class="sync-status-detail" id="details-sync-status">
                            <div class="sync-indicator-detail synced">
                                <i class="fas fa-check-circle"></i>
                                <span>Sincronizado correctamente</span>
                            </div>
                            <span class="sync-time" id="details-last-sync">Última actualización: 20/01/2024 a las 14:30</span>
                        </div>
                    </div>
                </div>

                <div class="report-details-section">
                    <h4>Descripción</h4>
                    <p id="details-description">Descripción del informe...</p>
                </div>
                <div class="report-details-section">
                    <h4>URL de Power BI</h4>
                    <div class="url-display">
                        <input type="text" id="details-url" readonly class="url-input">
                        <button class="btn-icon copy-url-btn" title="Copiar URL">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
                <div class="report-details-section">
                    <h4>Información del Informe</h4>
                    <div class="details-grid">
                        <div class="details-item">
                            <span class="details-label">Autor</span>
                            <span class="details-value" id="details-author">Autor</span>
                        </div>
                        <div class="details-item">
                            <span class="details-label">Departamento</span>
                            <span class="details-value" id="details-department">Departamento</span>
                        </div>
                        <div class="details-item">
                            <span class="details-label">Fecha de Creación</span>
                            <span class="details-value" id="details-created">Fecha</span>
                        </div>
                        <div class="details-item">
                            <span class="details-label">Última Actualización</span>
                            <span class="details-value" id="details-updated">Fecha</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="close-details">Cerrar</button>
                <button class="btn btn-primary" id="edit-from-details">Editar</button>
            </div>
        </div>
    </div>
    <script src="Funcion_Menu"></script>
    <script src="Funcion_Sincronizacion"></script>
    <script src="Funcion_Reportes"></script>
</body>
</html>