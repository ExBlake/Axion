<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empresas</title>
    <link rel="icon" type="image/x-icon" href="Icono">
    <link rel="stylesheet" href="Estilos_Menu">
    <link rel="stylesheet" href="Estilos_Empresas">
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
        /****************** ALL USERS ***********************************/
        require_once(__DIR__ . '/../Controller/CompaniesController.php');
        /****************************************************************/
        $Company = new CompaniesController();
        $Companies = $Company->GetAllCompaniesController();
        $Plans_and_Users = $Company->GetAllCompaniesWithStatsController();

    ?>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php include 'Layout/HeaderLeft.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navigation Bar -->
            <?php include 'Layout/HeaderUp.php'; ?>

            <!-- Companies Content -->
            <div class="dashboard-content">
                <div class="section-header">
                    <h1>Empresas</h1>
                    <div class="header-actions">
                        <button id="add-company-btn" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            <span>Nueva Empresa</span>
                        </button>
                    </div>
                </div>

                <!-- Companies Filters and Actions -->
                <div class="companies-actions">
                    <div class="search-filter">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" placeholder="Buscar empresas..." id="company-search">
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
                    function prepararEmpresa($AllCompany, $Plans_and_Users) {
                        $Id_Empresa = htmlspecialchars($AllCompany['Id_Empresa'] ?? 'Desconocido');
                        $NIT = htmlspecialchars($AllCompany['NIT'] ?? 'Desconocido');
                        $Nombre = htmlspecialchars($AllCompany['Nombre'] ?? 'Desconocido');
                        $Descripcion = htmlspecialchars($AllCompany['Descripcion'] ?? 'Desconocido');
                        $Categoria = htmlspecialchars($AllCompany['Categoria'] ?? 'Desconocido');
                        $Estado = htmlspecialchars($AllCompany['Estado'] ?? 'Desconocido');
                        $Ubicacion = htmlspecialchars($AllCompany['Ubicacion'] ?? 'Desconocido');
                        $Web = htmlspecialchars($AllCompany['Sitio_Web'] ?? 'No Aplica');
                        $Foto = htmlspecialchars($AllCompany['Logo'] ?? '');
                        $Fecha_Creacion = htmlspecialchars(
                            isset($AllCompany['Fecha_Creacion']) && $AllCompany['Fecha_Creacion'] !== ''
                                ? date('d/m/Y', strtotime($AllCompany['Fecha_Creacion']))
                                : ''
                        );
                        $Fecha_Actualizacion = htmlspecialchars(
                            isset($AllCompany['Fecha_Actualizacion']) && $AllCompany['Fecha_Actualizacion'] !== ''
                                ? date('d/m/Y g:i:s A', strtotime($AllCompany['Fecha_Actualizacion']))
                                : ''
                        );
                        $imgPath = !empty($Foto) ? "PImageCompany/" . $Foto : "PImageUser/User_Unknown.jpg";

                        $Plans = 0;
                        $Users = 0;
                        foreach ($Plans_and_Users as $stats) {
                            if ($stats['Id_Empresa'] === $AllCompany['Id_Empresa']) {
                                $Plans = htmlspecialchars($stats['TotalPlanes']);
                                $Users = htmlspecialchars($stats['TotalUsuarios']);
                                break;
                            }
                        }

                        return compact(
                            'Id_Empresa', 'NIT','Nombre', 'Descripcion', 'Categoria', 'Estado',
                            'Ubicacion', 'Web', 'Foto', 'Fecha_Creacion', 'Fecha_Actualizacion',
                            'imgPath', 'Plans', 'Users'
                        );
                    }
                    ?>

                <!-- Companies Grid View (Default) -->
                <div class="companies-grid" id="companies-grid">
                        <?php foreach($Companies as $AllCompany){
                            extract(prepararEmpresa($AllCompany, $Plans_and_Users));
                        ?>


                        <!-- Company Card -->
                        <div class="company-card"  
                            data-id="<?php echo $Id_Empresa; ?>"
                            data-nit="<?php echo $NIT; ?>"
                            data-nombre="<?php echo $Nombre; ?>"
                            data-categoria="<?php echo $Categoria; ?>"
                            data-descripcion="<?php echo $Descripcion; ?>"
                            data-web="<?php echo $Web; ?>"
                            data-estado="<?php echo $Estado; ?>"
                            data-ubicacion="<?php echo $Ubicacion; ?>"
                            data-fechacreacion="<?php echo $Fecha_Creacion; ?>"
                            data-fechaactualizacion="<?php echo $Fecha_Actualizacion; ?>"
                            data-planes="<?php echo $Plans; ?>"
                            data-usuarios="<?php echo $Users; ?>"
                            data-logo="<?php echo $imgPath; ?>">
                            <div class="company-card-header">
                                <div class="company-logo tech">
                                    <img src="<?php echo $imgPath; ?>"
                                        alt="<?php echo $Nombre; ?>">
                                </div>
                                <div class="company-actions">
                                    <button class="btn-icon edit-company-btn" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button class="btn-icon view-company-btn" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="company-info">
                                <h3><?php echo $Nombre; ?></h3>
                                <div class="company-tagets">
                                    <span class="company-industry"><?php echo $Categoria; ?></span>
                                    <span class="company-industry"><?php echo $Estado; ?></span>
                                </div>
                                
                                <p class="company-description"><?php echo $Descripcion; ?></p>
                            </div>
                            <div class="company-meta">
                                <div class="meta-item">
                                    <i class="fas fa-id-badge"></i>
                                    <span><?php echo $NIT; ?></span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-users"></i>
                                    <span><?php echo $Ubicacion; ?></span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-calendar"></i>
                                    <span><?php echo $Fecha_Actualizacion; ?></span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-globe"></i>
                                    <span><?php echo $Web; ?></span>
                                </div>
                            </div>
                            <div class="company-stats">
                                <div class="stat-item">
                                    <span class="stat-value"><?php echo $Users; ?></span>
                                    <span class="stat-label">Usuarios</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-value"><?php echo $Plans; ?></span>
                                    <span class="stat-label">Planes</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-value"><?php echo $Fecha_Creacion; ?></span>
                                    <span class="stat-label">Contratación</span>
                                </div>
                            </div>
                            <div class="company-status active">
                                <span></span>
                            </div>
                        </div>
                    <?php 
                        } 
                    ?>
                </div>

                <!-- Companies List View (Hidden by default) -->
                <div class="companies-list" id="companies-list">
                    <div class="companies-table">
                        <div class="table-row table-header">
                            <div class="table-cell cell-name">Empresa</div>
                            <div class="table-cell cell-id">NIT</div>
                            <div class="table-cell cell-industry">Categoria</div>
                            <div class="table-cell cell-plans">Planes</div>
                            <div class="table-cell cell-users">Usuarios</div>
                            <div class="table-cell cell-status">Estado</div>
                            <div class="table-cell cell-actions">Acciones</div>
                        </div>
                            <?php foreach($Companies as $AllCompany){
                                extract(prepararEmpresa($AllCompany, $Plans_and_Users));
                            ?>


                            <div class="table-row"
                                data-id="<?php echo $Id_Empresa; ?>"
                                data-nit="<?php echo $NIT; ?>"
                                data-nombre="<?php echo $Nombre; ?>"
                                data-categoria="<?php echo $Categoria; ?>"
                                data-descripcion="<?php echo $Descripcion; ?>"
                                data-web="<?php echo $Web; ?>"
                                data-estado="<?php echo $Estado; ?>"
                                data-ubicacion="<?php echo $Ubicacion; ?>"
                                data-fechacreacion="<?php echo $Fecha_Creacion; ?>"
                                data-fechaactualizacion="<?php echo $Fecha_Actualizacion; ?>"
                                data-planes="<?php echo $Plans; ?>"
                                data-usuarios="<?php echo $Users; ?>"
                                data-logo="<?php echo $imgPath; ?>">

                                <div class="table-cell cell-name">
                                    <div class="company-logo-small tech">
                                        <img src="<?php echo $imgPath; ?>" alt="Logo">
                                    </div>
                                    <span><?php echo $Nombre; ?></span>
                                </div>
                                <div class="table-cell cell-id"><?php echo $NIT; ?></div>
                                <div class="table-cell cell-industry">
                                    <span class="industry-badge tech"><?php echo $Categoria; ?></span>
                                </div>
                                <div class="table-cell cell-plans"><?php echo $Plans; ?></div>
                                <div class="table-cell cell-users"><?php echo $Users; ?></div>
                                <div class="table-cell cell-status">
                                    <span class="status-badge <?php echo $Estado; ?>"><?php echo $Estado; ?></span>
                                </div>
                                <div class="table-cell cell-actions">
                                    <button class="btn-icon edit-company-btn" title="Editar"><i class="fas fa-pen"></i></button>
                                    <button class="btn-icon view-company-btn" title="Ver detalles"><i class="fas fa-eye"></i></button>
                                </div>
                            </div>
                            <?php } ?>
                    </div>
                </div>


                <!-- Pagination
                <div class="pagination">
                    <button class="pagination-btn" disabled title="Previous Page">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="pagination-btn active">1</button>
                    <button class="pagination-btn">2</button>
                    <button class="pagination-btn">3</button>
                    <span class="pagination-ellipsis">...</span>
                    <button class="pagination-btn">10</button>
                    <button class="pagination-btn" title="Next Page">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div> -->
            </div>
        </div>
    </div>

    <!-- Modal para añadir/editar empresa -->
    <div class="modal" id="company-modal">
        <div class="modal-backdrop"></div>
        <div class="modal-container">
            <div class="modal-header">
                <h2 id="modal-title">Nueva Empresa</h2>
                <button class="modal-close" id="modal-close" title="Cerrar modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="company-form" action="XZ" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" id="csrf_token_input"
                        value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <div class="form-group">
                        <label for="company-name">NIT</label>
                        <input type="hidden" name="ID_EMPRESA" id="company-id">
                        <input type="text" name="NIT" id="company-nit" class="form-input" placeholder="Identificación"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="company-name">Nombre de la empresa</label>
                        <input type="text" name="NOMBRE" id="company-name" class="form-input"
                            placeholder="Nombre de la empresa" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="company-industry">Industria</label>
                            <input type="text" name="INDUSTRIA" id="company-industry" class="form-input" placeholder="Categoría de la empresa"
                            required>
                        </div>
                        <div class="form-group">
                            <label for="company-status">Estado</label>
                            <select name="ESTADO" id="company-status" class="form-select" required>
                                <option value="">Seleccionar estado</option>
                                <option value="Activa">Activa</option>
                                <option value="Inactiva">Inactiva</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="company-description">Descripción</label>
                        <textarea name="DESCRIPCION" id="company-description" class="form-textarea"
                            placeholder="Descripción breve de la empresa" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="company-logo">Logo</label>
                        <div class="avatar-upload">
                            <div class="avatar-preview">
                                <div id="logo-preview-image"></div>
                            </div>
                            <label for="company-logo-input" class="avatar-upload-btn">
                                <i class="fas fa-camera"></i>
                                <span>Subir logo</span>
                            </label>
                            <input type="file" name="LOGO" id="company-logo-input" accept="image/*" hidden>
                            <input type="hidden" name="FOTO_ACTUAL" id="foto_actual_edit">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="company-ubicacion">Ubicación</label>
                            <input type="text" name="UBICACION" id="company-ubicacion" class="form-input"
                                placeholder="Ciudad, País" required>
                        </div>
                        <div class="form-group">
                            <label for="company-website">Sitio web</label>
                            <input type="url" name="WEB" id="company-website" class="form-input"
                                placeholder="www.ejemplo.com">
                        </div>
                    </div>
                    <input type="hidden" name="accionCompany" id="accion-form" value="">
                    <!-- <input type="hidden" name="accionSaveCompany" value="Registrar_Empresa">
                    <input type="hidden" name="accionEditCompany" value="Editar_Empresa"> -->
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="cancel-company">Cancelar</button>
                <input class="btn btn-primary" type="button" id="save-company" value="Guardar" style="display: none;">
                <input class="btn btn-primary" type="button" id="edit-company" value="Editar" style="display: none;">
            </div>
        </div>
    </div>

    <!-- Modal para ver detalles de la empresa -->
    <div class="modal" id="company-details-modal">
        <div class="modal-backdrop"></div>
        <div class="modal-container">
            <div class="modal-header">
                <h2 id="details-modal-title">Editar Empresa</h2>
                <button class="modal-close" id="details-modal-close" title="Cerrar detalles">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="company-details-header">
                    <div class="company-details-logo" id="details-logo">
                        <!-- Logo se cargará dinámicamente -->
                    </div>
                    <div class="company-details-info">
                        <h3 id="details-name">Nombre de la Empresa</h3>
                        <span class="company-industry" id="details-industry">Industria</span>
                        <div class="company-statu-details" id="details-status"></div>
                    </div>
                </div>
                <div class="company-details-section">
                    <h4>Descripción</h4>
                    <p id="details-description">Descripción de la empresa...</p>
                </div>
                <div class="company-details-section">
                    <h4>Información General</h4>
                    <div class="details-grid">
                        <div class="details-item">
                            <span class="details-label">NIT</span>
                            <span class="details-value" id="details-location">Ciudad, País</span>
                        </div>
                        <div class="details-item">
                            <span class="details-label">Sitio Web</span>
                            <span class="details-value" id="details-website">website.com</span>
                        </div>
                        <div class="details-item">
                            <span class="details-label">Ubicación</span>
                            <span class="details-value" id="details-employees">1000</span>
                        </div>
                        <div class="details-item">
                            <span class="details-label">Actualización</span>
                            <span class="details-value" id="details-founded">2010</span>
                        </div>
                    </div>
                </div>
                <div class="company-details-section">
                    <h4>Estadísticas</h4>
                    <div class="details-stats">
                        <div class="details-stat-item">
                            <span class="details-stat-value" id="details-market-value">$1.2B</span>
                            <span class="details-stat-label">Usuarios</span>
                        </div>
                        <div class="details-stat-item">
                            <span class="details-stat-value" id="details-projects">42</span>
                            <span class="details-stat-label">Planes</span>
                        </div>
                        <div class="details-stat-item">
                            <span class="details-stat-value" id="details-rating">A+</span>
                            <span class="details-stat-label">Contratación</span>
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
    <script src="Funcion_Empresa"></script>
    <script src="Funcion_Sincronizacion"></script>
</body>

</html>