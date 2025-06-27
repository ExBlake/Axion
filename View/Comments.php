<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PQRS</title>
    <link rel="icon" type="image/x-icon" href="Icono">
    <link rel="stylesheet" href="Estilos_Menu_Hawks">
    <link rel="stylesheet" href="Estilos_PQRS_Hawks">
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
    <?php 

        /****************** TOKEN ***********************/
        require_once(__DIR__.'/../Controller/Token.php');
        /************************************************/
        /****************** MESSAGES ***********************/
        include_once(__DIR__ . '/Layout/FlashMessage.php');
        /************************************************/
        /****************** ALL USERS ***********************/
        require_once(__DIR__ . '/../Controller/PQRSController.php');
        $PQRS = new PQRSController();
        $AllPQRS = $PQRS->GetAllPQRsController();

    ?>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php include 'Layout/HeaderLeft.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navigation Bar -->
            <?php include 'Layout/HeaderUp.php'; ?>
            <!-- PQR Content -->
            <div class="dashboard-content">
                <div class="pqr-header">
                    <div class="pqr-title">
                        <h1>Sistema PQRS</h1>
                        <p class="pqr-subtitle">Gestión de Peticiones, Quejas, Reclamos y Sugerencias</p>
                    </div>
                    <div class="pqr-actions-top">
                        <button id="add-pqr-btn" class="btn-create">
                            <i class="fas fa-plus"></i>
                            <span>Crear PQR</span>
                        </button>
                    </div>
                </div>

                <?php
                    $tipos = ['peticion', 'queja', 'reclamo', 'sugerencia'];
                    $iconos = [
                        'peticion' => 'fa-file-alt',
                        'queja' => 'fa-exclamation-circle',
                        'reclamo' => 'fa-gavel',
                        'sugerencia' => 'fa-lightbulb'
                    ];
                    $colores = [
                        'peticion' => '#007bff',
                        'queja' => '#dc3545',
                        'reclamo' => '#ffc107',
                        'sugerencia' => '#28a745'
                    ];

                    echo '<div class="pqr-stats-cards">';

                    foreach ($tipos as $tipo) {
                        $estadisticas = $PQRS->GetAllStadisticsController($tipo);

                        $total = 0;
                        $pendientes = 0;

                        // Sumamos el total y pendientes reales
                        if (is_array($estadisticas)) {
                            foreach ($estadisticas as $row) {
                                $total += isset($row['Total']) ? $row['Total'] : 0;
                                $pendientes += isset($row['Pendientes']) ? $row['Pendientes'] : 0;
                            }
                        }

                        $porcentaje = $total > 0 ? intval(($pendientes / $total) * 100) : 0;

                        echo '
                        <div class="stat-card ' . $tipo . '">
                            <div class="stat-icon">
                                <i class="fas ' . $iconos[$tipo] . '"></i>
                            </div>
                            <div class="stat-info">
                                <h3>' . ucfirst($tipo) . 's</h3>
                                <div class="stat-value">' . $total . '</div>
                                <div class="stat-progress">
                                    <div class="progress-bar" style="width: ' . $porcentaje . '%; background-color:' . $colores[$tipo] . '"></div>
                                </div>
                                <div class="stat-detail">
                                    <span>' . $pendientes . ' pendientes</span>
                                    <span>' . $porcentaje . '%</span>
                                </div>
                            </div>
                        </div>';
                    }

                    echo '</div>';
                ?>

                <!-- PQR Filters and Search -->
                <div class="pqr-controls">
                    <div class="pqr-search">
                        <div class="search-input-container">
                            <i class="fas fa-search"></i>
                            <input type="text" placeholder="Buscar PQRs..." id="pqr-search">
                            <button class="clear-search" id="clear-search" title="Limpiar búsqueda">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="pqr-filters">
                        <div class="filter-group">
                            <label>Tipo:</label>
                            <div class="filter-options">
                                <button class="filter-btn active" data-filter="all">Todos</button>
                                <button class="filter-btn" data-filter="Peticion">Peticiones</button>
                                <button class="filter-btn" data-filter="Queja">Quejas</button>
                                <button class="filter-btn" data-filter="Reclamo">Reclamos</button>
                                <button class="filter-btn" data-filter="Sugerencia">Sugerencias</button>
                            </div>
                        </div>
                        <div class="filter-group">
                            <label>Estado:</label>
                            <div class="filter-options">
                                <button class="filter-btn active" data-status="all">Todos</button>
                                <button class="filter-btn" data-status="Pendiente">Pendientes</button>
                                <button class="filter-btn" data-status="En proceso">En proceso</button>
                                <button class="filter-btn" data-status="Resuelto">Resueltos</button>
                            </div>
                        </div>
                        <div class="view-toggle">
                            <button class="view-btn active" data-view="grid" title="Vista de cuadrícula">
                                <i class="fas fa-th-large"></i>
                            </button>
                            <button class="view-btn" data-view="list" title="Vista de lista">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <?php
                    function prepararDatosPQR($PQR, $PQRS) {
                        $Id = htmlspecialchars($PQR['Id_PQRS'] ?? 'Desconocido'); 
                        $Tipo = htmlspecialchars($PQR['Tipo'] ?? 'Desconocido');
                        $Estado = htmlspecialchars($PQR['Estado'] ?? 'Sin estado');
                        $Asunto = htmlspecialchars($PQR['Asunto'] ?? 'Sin asunto');
                        $Descripcion = htmlspecialchars($PQR['Descripcion'] ?? 'Sin descripción');
                        $Respuesta = htmlspecialchars($PQR['Respuesta'] ?? 'Sin respuesta');
                        $Fecha_Creacion = htmlspecialchars(
                            isset($PQR['Fecha_Creacion']) && $PQR['Fecha_Creacion'] !== ''
                                ? date('d/m/Y g:i:s A', strtotime($PQR['Fecha_Creacion']))
                                : ''
                        );
                        $Fecha_ActualizacionRaw = $PQR['Fecha_Actualizacion'] ?? '';
                        $Fecha_Creacion = htmlspecialchars(
                            isset($PQR['Fecha_Creacion']) && $PQR['Fecha_Creacion'] !== ''
                                ? date('d/m/Y g:i:s A', strtotime($PQR['Fecha_Creacion']))
                                : ''
                        );
                        $Fecha_Respuesta = (
                            isset($PQR['Fecha_Actualizacion']) && $PQR['Fecha_Actualizacion'] !== '' &&
                            $PQR['Fecha_Actualizacion'] !== $PQR['Fecha_Creacion']
                        ) ? htmlspecialchars(date('d/m/Y g:i:s A', strtotime($PQR['Fecha_Actualizacion']))) : 'Sin respuesta';
                        $identificacion = htmlspecialchars($PQR['Identificacion'] ?? '');
                        $NombreUsuario = htmlspecialchars($PQR['Nombre'] ?? '') . ' ' . htmlspecialchars($PQR['Apellidos'] ?? '');
                        $Email = htmlspecialchars($PQR['Email'] ?? '');
                        $Empresa = htmlspecialchars($PQR['NombreEmpresa'] ?? '');

                        $hostBaseURL = ($_SERVER['HTTP_HOST'] === 'localhost') 
                            ? 'http://localhost/Internal_hawks_capital/FilesPQRs/' 
                            : 'https://hawkscapitalx.com/Internal_hawks_capital/FilesPQRs/';
                        
                        $Archivos = $PQRS->GetAllArchiveByPQRSController($Id);
                        $ArchivosData = array_map(function($Archivo) use ($hostBaseURL) {
                            return [
                                'nombre' => htmlspecialchars($Archivo['NombreArchivo'] ?? ''),
                                'ruta'   => $hostBaseURL . basename($Archivo['RutaArchivo']),
                                'tipo'   => htmlspecialchars($Archivo['TipoArchivo'] ?? ''),
                            ];
                        }, $Archivos);

                        $dataArchivos = htmlspecialchars(json_encode($ArchivosData), ENT_QUOTES, 'UTF-8');

                        return compact('Id', 'Tipo', 'Estado', 'Asunto', 'Descripcion', 'Respuesta', 'Fecha_Creacion', 'Fecha_Respuesta', 'NombreUsuario', 'Email', 'identificacion', 'Empresa', 'dataArchivos');
                    }
                ?>

                <!-- PQR Grid View (Default) -->
                <div class="pqr-container grid-view" id="pqr-grid">

                    <?php if (is_array($AllPQRS) && !empty($AllPQRS)) {
                        foreach ($AllPQRS as $PQR) {
                            $datos = prepararDatosPQR($PQR, $PQRS);
                            extract($datos);
                    ?>
                    <!-- PQR Card -->
                    <div class="pqr-item"
                        data-id="<?= $Id; ?>"
                        data-type="<?= ucfirst(strtolower($Tipo)); ?>"
                        data-status="<?= ucfirst(str_replace('-', ' ', strtolower($Estado))); ?>"
                        data-asunto="<?= $Asunto; ?>"
                        data-descripcion="<?= $Descripcion; ?>"
                        data-respuesta="<?= $Respuesta; ?>"
                        data-fecha-creacion="<?= $Fecha_Creacion; ?>"
                        data-fecha-respuesta="<?= $Fecha_Respuesta; ?>"
                        data-usuario="<?= $NombreUsuario; ?>"
                        data-correo="<?= $Email; ?>"
                        data-identificacion="<?= $identificacion; ?>"
                        data-empresa="<?= $Empresa; ?>"
                        data-archivos="<?= $dataArchivos; ?>">

                        <div class="pqr-item-header">
                            <div class="pqr-badge <?php echo $Tipo; ?>">   <?php echo ucfirst(strtolower($Tipo)); ?></div>
                            <div class="pqr-status <?php echo $Estado; ?>"><?php echo ucfirst(str_replace('-', ' ', strtolower($Estado))); ?></div>
                        </div>
                        <div class="pqr-item-body">
                            <h3 class="pqr-title"><?php echo $Asunto; ?></h3>
                            <p class="pqr-description"><?php echo $Descripcion; ?></p>
                        </div>
                        <div class="pqr-item-meta">
                            <div class="pqr-meta-item">
                                <i class="fas fa-user"></i>
                                <span><?php echo $NombreUsuario; ?></span>
                            </div>
                            <div class="pqr-meta-item">
                                <p>Creado: </p>
                                <i class="fas fa-calendar-alt"></i>
                                <span><?php echo $Fecha_Creacion; ?></span>
                            </div>
                            <div class="pqr-meta-item">
                                <p>Respuesta: </p>
                                <i class="fas fa-calendar-alt"></i>
                                <span><?php echo $Fecha_Respuesta; ?></span>
                            </div>
                        </div>
                        <div class="pqr-item-footer">
                            <div class="pqr-priority medium">
                                <i class="fas fa-flag"></i>
                                <span></span>
                            </div>
                            <div class="pqr-actions">
                                <?php if (isset($_SESSION['Rol']) && $_SESSION['Rol'] === 'Administrador'){ ?>
                                    <button class="action-btn edit-pqr-btn" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                <?php } else{ ?>
                                    <button class="action-btn edit-pqr-btn" title="Editar" style="display: none;">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                <?php } ?>
                                <button class="action-btn view-pqr-btn" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </button>

                            </div>
                        </div>
                    </div>
                    <?php 
                        }
                    }
                    ?>
                </div>

                <!-- PQR List View (Hidden by default) -->
                <div class="pqr-container list-view" id="pqr-list">
                    <div class="pqr-list-header">
                        <div class="pqr-list-cell">Asunto</div>
                        <div class="pqr-list-cell">Tipo</div>
                        <div class="pqr-list-cell">Solicitante</div>
                        <div class="pqr-list-cell">Fecha Registro</div>
                        <div class="pqr-list-cell">Estado</div>
                        <div class="pqr-list-cell">Fecha Respuesta</div>
                        <div class="pqr-list-cell">Acciones</div>
                    </div>
                        <?php if (is_array($AllPQRS) && !empty($AllPQRS)) {
                            foreach ($AllPQRS as $PQR) {
                                $datos = prepararDatosPQR($PQR, $PQRS);
                                extract($datos);
                        ?>
                    <!-- PQR Row -->
                    <div class="pqr-list-row"  
                        data-id="<?= $Id; ?>"
                        data-type="<?= ucfirst(strtolower($Tipo)); ?>"
                        data-status="<?= ucfirst(str_replace('-', ' ', strtolower($Estado))); ?>"
                        data-asunto="<?= $Asunto; ?>"
                        data-descripcion="<?= $Descripcion; ?>"
                        data-respuesta="<?= $Respuesta; ?>"
                        data-fecha-creacion="<?= $Fecha_Creacion; ?>"
                        data-fecha-respuesta="<?= $Fecha_Respuesta; ?>"
                        data-usuario="<?= $NombreUsuario; ?>"
                        data-correo="<?= $Email; ?>"
                        data-identificacion="<?= $identificacion; ?>"
                        data-empresa="<?= $Empresa; ?>"
                        data-archivos="<?= $dataArchivos; ?>">
                        <div class="pqr-list-cell"><?php echo $Asunto; ?></div>
                        <div class="pqr-list-cell"><span class="pqr-badge <?php echo $Tipo; ?>"><?php echo ucfirst(strtolower($Tipo)); ?></span></div>
                        <div class="pqr-list-cell"><?php echo $NombreUsuario; ?></div>
                        <div class="pqr-list-cell"><?php echo $Fecha_Creacion; ?></div>
                        <div class="pqr-list-cell"><span class="pqr-status <?php echo $Estado; ?>"><?php echo ucfirst(str_replace('-', ' ', strtolower($Estado))); ?></span></div>
                        <div class="pqr-list-cell"><span class="pqr-priority medium"><?php echo $Fecha_Creacion; ?></span></div>
                        <div class="pqr-list-cell">
                            <div class="pqr-actions">
                                <?php if (isset($_SESSION['Rol']) && $_SESSION['Rol'] === 'Administrador'){ ?>
                                    <button class="action-btn edit-pqr-btn" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                <?php } else{ ?>
                                    <button class="action-btn edit-pqr-btn" title="Editar" style="display: none;">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                <?php } ?>
                                <button class="action-btn view-pqr-btn" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    }
                    ?>
                </div>

                <!-- Pagination
                <div class="pqr-pagination">
                    <button class="pagination-btn" disabled>
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="pagination-btn active">1</button>
                    <button class="pagination-btn">2</button>
                    <button class="pagination-btn">3</button>
                    <span class="pagination-ellipsis">...</span>
                    <button class="pagination-btn">10</button>
                    <button class="pagination-btn">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div> -->
            </div>
        </div>
    </div>

    <!-- Modal para añadir/editar PQR -->
    <div class="modal" id="pqr-modal">
        <div class="modal-backdrop"></div>
        <div class="modal-container">
            <div class="modal-header">
                <h2 id="modal-title">Nuevo PQR</h2>
                <button class="modal-close" id="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="pqr-form" action="XZ" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" id="csrf_token_input"
                        value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                    
                    <div class="form-section">
                        <h3 class="form-section-title">Información del PQR</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="pqr-type">Tipo de PQR</label>
                                <select name="TIPO" id="pqr-type" class="form-select" required>
                                    <option value="">Seleccionar tipo</option>
                                    <option value="peticion">Petición</option>
                                    <option value="queja">Queja</option>
                                    <option value="reclamo">Reclamo</option>
                                    <option value="sugerencia">Sugerencia</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pqr-subject">Asunto</label>
                            <input type="text" name="ASUNTO" id="pqr-subject" class="form-input" placeholder="Asunto del PQR" required>
                        </div>
                        <div class="form-group">
                            <label for="pqr-description">Descripción</label>
                            <textarea name="DESCRIPCION" id="pqr-description" class="form-textarea" placeholder="Descripción detallada del PQR" required></textarea>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h3 class="form-section-title">Archivos Adjuntos</h3>
                        <div class="form-group">
                            <div class="file-upload-container">
                                <div class="file-upload-area" id="file-upload-area">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p>Arrastra archivos aquí o <span class="file-upload-browse">selecciona archivos</span></p>
                                    <p>Solo se permiten archivos <span class="file-upload-browse"><em>jpg, jpeg, png, pdf, docx, xlsx, txt </em></span></p>
                                    
                                </div>
                                <input type="file" name="ADJUNTOS[]" id="pqr-attachments-input" multiple hidden>
                                <div class="file-list" id="file-list"></div>
                            </div>
                        </div>
                    </div>
                        <input type="hidden" name="accionRegistrarPQRS" value="RegistrarPQRS">
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn-secondary" id="cancel-pqr" type="button">Cancelar</button>
                <button class="btn-primary" id="save-pqr-externo" type="button">Guardar PQR</button>
            </div>
        </div>
    </div>

    <!-- Modal para ver detalles del PQR -->
    <div class="modal" id="pqr-details-modal">
        <div class="modal-backdrop"></div>
        <div class="modal-container modal-large">
            <div class="modal-header">
                <h2 id="details-modal-title">Detalles del PQRS</h2>
                <button class="modal-close" id="details-modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="details-header">
                    <div class="details-badges">
                        <span class="pqr-badge peticion" id="details-type"></span>
                        <span class="pqr-status pendiente" id="details-status"></span>
                    </div>
                    <div class="details-date">
                        <i class="fas fa-calendar-alt"></i>
                        <span id="details-date"></span>
                    </div>
                </div>
                
                <div class="details-content">
                    <h3 id="details-subject"></h3>
                    <div class="details-description">
                        <p id="details-description"></p>
                    </div>
                </div>
                
                <div class="details-section">
                    <h4 class="details-section-title"></h4>
                    <div class="details-info-grid">
                        <div class="details-info-item">
                            <span class="details-info-label">Nombre:</span>
                            <span class="details-info-value" id="details-name"></span>
                        </div>
                        <div class="details-info-item">
                            <span class="details-info-label">Correo:</span>
                            <span class="details-info-value" id="details-email"></span>
                        </div>
                        <div class="details-info-item">
                            <span class="details-info-label">Identificación:</span>
                            <span class="details-info-value" id="details-id"></span>
                        </div>
                        <div class="details-info-item">
                            <span class="details-info-label">Empresa:</span>
                            <span class="details-info-value" id="details-company"></span>
                        </div>
                    </div>
                </div>
                
                <div class="details-section">
                    <h4 class="details-section-title">Archivos Adjuntos</h4>
                    <div class="details-attachments" id="details-attachments">
                        <!-- Los archivos se llenarán dinámicamente con JavaScript -->
                        <!-- Word -->
                        <div class="attachment-item">
                            <div class="attachment-icon word">
                                <i class="fas fa-file-word"></i>
                            </div>
                            <div class="attachment-info">
                                <span class="attachment-name">Documento Word.docx</span>
                                <span class="attachment-size">150 KB</span>
                            </div>
                            <a href="#" class="attachment-download" title="Descargar">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>

                        <!-- Excel -->
                        <div class="attachment-item">
                            <div class="attachment-icon excel">
                                <i class="fas fa-file-excel"></i>
                            </div>
                            <div class="attachment-info">
                                <span class="attachment-name">Reporte Excel.xlsx</span>
                                <span class="attachment-size">300 KB</span>
                            </div>
                            <a href="#" class="attachment-download" title="Descargar">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>

                        <!-- TXT -->
                        <div class="attachment-item">
                            <div class="attachment-icon text">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="attachment-info">
                                <span class="attachment-name">Notas.txt</span>
                                <span class="attachment-size">2 KB</span>
                            </div>
                            <a href="#" class="attachment-download" title="Descargar">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>

                    </div>
                </div>
                
                <div class="details-section">
                    <h4 class="details-section-title">Historial de Respuestas</h4>
                    <div class="details-timeline" id="details-responses">
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-comment-alt"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-header">
                                    <span class="timeline-author">Administrador</span>
                                    <span class="timeline-date" id="timeline-date">12/05/2023 10:30</span>
                                </div>
                                <div class="timeline-body">
                                    <p>Estamos revisando su solicitud y nos pondremos en contacto con usted a la brevedad.</p>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <div class="details-timeline" id="details-responses-admin" style="display: none;">
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-comment-alt"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-header">
                                    <span class="timeline-author">Administrador</span>
                                    <span class="timeline-date" id="timeline-date-respond"></span>
                                </div>
                                <div class="timeline-body">
                                    <p id="timeline-body-respond"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <?php if (isset($_SESSION['Rol']) && $_SESSION['Rol'] === 'Administrador'): ?>
                        <div class="details-response-form">
                            <h4 class="details-section-title">Añadir Respuesta</h4>
                            <form method="POST" action="XZ" enctype="multipart/form-data">
                                <input type="hidden" name="csrf_token" id="csrf_token_input" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                                <input type="hidden" name="Id_PQRS" id="hidden-pqr-id">

                                <div class="form-group">
                                    <textarea id="response-text" name="RESPUESTA" class="form-textarea" placeholder="Escriba su respuesta aquí..."></textarea>
                                </div>
                                <div class="form-actions">
                                    <input type="hidden" name="accion_Guardar_Respuesta" value="Guardar_Respuesta">
                                    <input class="btn-primary" type="submit" value="Enviar Respuesta">
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-secondary" id="close-details">Cerrar</button>
                <?php if (isset($_SESSION['Rol']) && $_SESSION['Rol'] === 'Administrador'){ ?>
                <button class="btn-primary" id="edit-from-details">Editar PQR</button>
                <?php } else{ ?>
                <button class="btn-primary" id="edit-from-details" style="display: none;">Editar PQR</button>
                <?php } ?>
            </div>
        </div>
    </div>

    <script src="Funcion_Menu"></script>
    <script src="Funcion_Sincronizacion"></script>
    <script src="Funcion_PQRS_ALLS"></script>
</body>

</html>