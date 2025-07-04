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

        <?php include 'Layout/HeaderLeft.php';
        /****************** MESSAGES ***********************/
        include_once(__DIR__ . '/Layout/FlashMessage.php');
        /************************************************/
        /****************** Company Controllers ***********************/
        require_once(__DIR__.'/../Controller/CompaniesController.php');
        /************************************************/
        /****************** Planes Controllers ***********************/
        require_once(__DIR__.'/../Controller/PlanReportController.php');
        /************************************************/
        $Companies = new CompaniesController();
        $CompaniesAll = $Companies->GetAllCompaniesController();
        $PlanReport = new PlanesReportController();
        $Plan = $PlanReport->GetAllPlanesController();
        $Reporting = $PlanReport->GetAllReportingController();
        ?>
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
                <?php
                    function prepararInforme($row) {
                        
                        $Id_Informe = htmlspecialchars($row['Id_Informe'] ?? 'Desconocido');
                        $Nombre_Informe = htmlspecialchars($row['Nombre_Informe'] ?? 'Sin Nombre');
                        $URL = htmlspecialchars($row['Url'] ?? 'Sin URL');
                        $Estado = htmlspecialchars($row['Estado'] ?? 'Sin estado');

                        $Fecha_Creacion = htmlspecialchars(
                            isset($row['Fecha_Creacion']) && $row['Fecha_Creacion'] !== ''
                                ? date('d/m/Y', strtotime($row['Fecha_Creacion']))
                                : ''
                        );
                        
                        $Fecha_Actualizacion = htmlspecialchars(
                            isset($row['Fecha_Actualizacion']) && $row['Fecha_Actualizacion'] !== ''
                                ? date('d/m/Y g:i:s A', strtotime($row['Fecha_Actualizacion']))
                                : ''
                        );

                        $Id_Planes = htmlspecialchars($row['Id_Planes'] ?? 'Desconocido');
                        $Nombre_Plan = htmlspecialchars($row['Nombre_Plan'] ?? 'Sin nombre');

                        $Id_Empresa = htmlspecialchars($row['Id_Empresa'] ?? 'Desconocido');
                        $Nombre_Empresa = htmlspecialchars($row['Nombre_Empresa'] ?? 'Sin empresa');

                        $URL_Parsed = parse_url($URL);
                        $host = $URL_Parsed['host'] ?? '';
                        $path = $URL_Parsed['path'] ?? '';
                        $query = $URL_Parsed['query'] ?? '';

                        $PreviewURL = $host . $path;
                        if ($query) {
                            $PreviewURL .= '?' . substr($query, 0, 30) . '...';
                        }

                        return compact(
                            'Id_Informe','Nombre_Informe', 'PreviewURL', 'URL', 'Estado', 'Fecha_Creacion', 'Fecha_Actualizacion',
                            'Id_Planes', 'Nombre_Plan', 'Id_Empresa', 'Nombre_Empresa'
                        );
                    }
                ?>


                <!-- Reports Grid View (Default) -->
                <div class="reports-grid" id="reports-grid">
                    <?php if (!empty($Reporting)): ?>
                        <?php 
                        foreach ($Reporting as $informe): 
                            extract(prepararInforme($informe));
                        ?>
                            <div class="report-card"
                                    data-id="<?= $Id_Informe ?>"
                                    data-nombre_informe="<?= $Nombre_Informe ?>"
                                    data-url="<?= $URL ?>"
                                    data-status="<?= $Estado ?>"
                                    data-created="<?= $Fecha_Creacion ?>"
                                    data-updated="<?= $Fecha_Actualizacion ?>"
                                    data-company-id="<?= $Id_Empresa ?>"
                                    data-company="<?= $Nombre_Empresa ?>"
                                    data-plan-id="<?= $Id_Planes ?>"
                                    data-plan="<?= $Nombre_Plan ?>">
                                    

                                <div class="report-card-header">
                                    <div class="report-title-section">
                                        <h2><?= $Nombre_Informe ?></h2>
                                    </div>
                                    <div class="report-status-badge-large <?= $Estado ?>">

                                        <span><?= $Estado ?></span>
                                    </div>
                                </div>


                                <div class="report-sync-status">
                                    <div class="sync-info outdated">
                                        <i class="fas fa-building"></i>
                                        <span class="sync-text"><?= $Nombre_Empresa ?></span>
                                    </div>
                                </div>

                                <div class="report-details-grid">
                                    <div class="detail-item">
                                        <div class="detail-label">
                                            <i class="fas fa-link"></i>
                                            <span>URL Power BI</span>
                                        </div>
                                        <div class="detail-value">
                                            <span class="url-preview"><?= $URL?></span>
                                            <button class="copy-url-btn" title="Copiar URL"
                                                data-url="<?= $URL ?>">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="detail-item">
                                        <div class="detail-label">
                                            <i class="fas fa-user"></i>
                                            <span>Plan</span>
                                        </div>
                                        <div class="report-tags">

                                    <span class="report-plan <?= $Nombre_Plan?>"><?= $Nombre_Plan?></span>
                                </div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-label">
                                            <i class="fas fa-sitemap"></i>
                                            <span>Contratación</span>
                                        </div>
                                        <div class="detail-value"><?= $Fecha_Creacion ?></div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-label">
                                            <i class="fas fa-calendar-plus"></i>
                                            <span>Actualización</span>
                                        </div>
                                        <div class="detail-value"><?= $Fecha_Actualizacion?></div>
                                    </div>
                                </div>

                                <div class="report-actions">
                                    <button class="btn-icon edit-report-btn" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button class="btn-icon view-report-btn" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-icon open-powerbi-btn" title="Abrir en Power BI"
                                        data-url="<?php echo "Informes?i=" . urlencode($Id_Informe) . "&e=" . urlencode($Id_Empresa); ?>">
                                        <i class="fas fa-external-link-alt"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-results">
                            <p>No hay informes disponibles por el momento.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Reports List View (Hidden by default) -->
                <div class="reports-list" id="reports-list">
                    <div class="reports-table">
                        <div class="table-row table-header">
                            <div class="table-cell cell-name">Nombre del Informe</div>
                            <div class="table-cell cell-company">Empresa</div>
                            <div class="table-cell cell-status">Estado</div>
                            <div class="table-cell cell-plan">Plan</div>
                            <div class="table-cell cell-updated">Actualizado</div>
                            <div class="table-cell cell-actions">Acciones</div>
                        </div>
                        <?php if (!empty($Reporting)): ?>
                            <?php foreach ($Reporting as $raw): ?>
                                <?php 
                                    $informe = prepararInforme($raw);
                                    extract($informe); 
                                ?>
                                <div class="table-row"
                                    data-id="<?= $Id_Informe ?>"
                                    data-nombre_informe="<?= $Nombre_Informe ?>"
                                    data-url="<?= $URL ?>"
                                    data-status="<?= $Estado ?>"
                                    data-created="<?= $Fecha_Creacion ?>"
                                    data-updated="<?= $Fecha_Actualizacion ?>"
                                    data-company-id="<?= $Id_Empresa ?>"
                                    data-company="<?= $Nombre_Empresa ?>"
                                    data-plan-id="<?= $Id_Planes ?>"
                                    data-plan="<?= $Nombre_Plan ?>">

                                    <div class="table-cell cell-name">
                                        <div class="report-name-cell">
                                            <span class="report-title"><?= $Nombre_Informe ?></span>
                                            <span class="report-url"><?= $PreviewURL ?></span>
                                        </div>
                                    </div>
                                    <div class="table-cell cell-company"><?= $Nombre_Empresa ?></div>

                                    <div class="table-cell cell-status">
                                        <div class="status-badge-with-sync active">
                                            <span class="status-badge <?= $Estado ?>"><?= $Estado ?></span>
                                        </div>
                                    </div>
                                    <div class="table-cell cell-plan">
                                        <span class="plan-badge <?= $Nombre_Plan ?>"><?= $Nombre_Plan ?></span>
                                    </div>
                                    <div class="table-cell cell-updated"><?= $Fecha_Actualizacion ?></div>
                                    <div class="table-cell cell-actions">
                                        <button class="btn-icon edit-report-btn" title="Editar">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button class="btn-icon view-report-btn" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn-icon open-powerbi-btn" title="Abrir en Power BI"
                                            data-url="<?php echo "Informes?i=" . urlencode($Id_Informe) . "&e=" . urlencode($Id_Empresa); ?>">
                                            <i class="fas fa-external-link-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-results">
                                <p>No hay informes disponibles por el momento.</p>
                            </div>
                        <?php endif; ?>


                       
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
                <form id="report-form" action="XZ" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="report-id" name="ID_INFORME">
                    <input type="hidden" name="csrf_token" id="csrf_token_input"
                        value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <div class="form-group">
                        <label for="report-nombre">Nombre</label>
                        <input type="nombre" id="report-nombre" name="NOMBRE" class="form-input"
                            placeholder="Nombre del Informe" required>
                    </div>    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="report-company">Empresa</label>
                            <select id="report-company" name="EMPRESA" class="form-select" required>
                                <option value="">Seleccionar empresa</option>
                                <?php
                                    foreach ($CompaniesAll as $company) {
                                        echo '<option value="' . htmlspecialchars($company['Id_Empresa']) . '">' . htmlspecialchars($company['Nombre']) . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="report-url">URL de Power BI</label>
                        <input type="url" id="report-url" name="URL" class="form-input"
                            placeholder="https://app.powerbi.com/view?r=..." required>
                        <small class="form-help">Pegue aquí la URL completa del informe de Power BI</small>
                    </div>
                    <div class="form-group">
                        <label for="report-plan">Plan Asociado</label>
                        <select id="report-plan" name="PLAN" class="form-select" required>
                            <option value="">Seleccionar plan</option>
                            <?php
                                foreach ($Plan as $PlanALl) {
                                    echo '<option value="' . htmlspecialchars($PlanALl['Id_Planes']) . '">' . htmlspecialchars($PlanALl['Nombre']) . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="accionReporting" id="accion-form" value="">
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
                    <p>⚠️ <strong>IMPORTANTE:</strong> Este enlace de Power BI contiene información confidencial y NO
                        debe ser compartido con personas no autorizadas. El acceso no autorizado puede comprometer datos
                        sensibles de la empresa.</p>
                </div>

                <div class="report-details-header">
                    <div class="report-details-info">
                        <h3 id="details-name">Nombre del Informe</h3>
                        <div class="details-company">
                            <i class="fas fa-building"></i>
                            <span id="details-company">Empresa</span>
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
                        <div class="details-tags">
                            <span class="report-status" id="details-status">Estado</span>
                        </div>
                    </div>
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