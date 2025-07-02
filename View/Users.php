<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="icon" type="image/x-icon" href="Icono">
    <link rel="stylesheet" href="Estilos_Menu">
    <link rel="stylesheet" href="Estilos_Configuracion">
    <link rel="stylesheet" href="Estilos_Usuarios">
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

        /****************** TOKEN ***********************/
        require_once(__DIR__.'/../Controller/Token.php');
        /************************************************/
        /****************** MESSAGES ***********************/
        include_once(__DIR__ . '/Layout/FlashMessage.php');
        /************************************************/
        /****************** Users Controllers ***********************/
        require_once(__DIR__.'/../Controller/UserController.php');
        /************************************************/
        /****************** Company Controllers ***********************/
        require_once(__DIR__.'/../Controller/CompaniesController.php');
        /************************************************/
        $Users = new UserController();
        $UsersAll = $Users->GetAllUserController();
        $Companies = new CompaniesController();
        $CompaniesAll = $Companies->GetAllCompaniesController();
    ?>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php include 'Layout/HeaderLeft.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navigation Bar -->
            <?php include 'Layout/HeaderUp.php'; ?>

            <!-- Users Content -->
            <div class="dashboard-content">
                <div class="section-header">
                    <h1>Usuarios</h1>
                    <div class="header-actions">
                        <button id="add-user-btn" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            <span>Nuevo Usuario</span>
                        </button>
                    </div>
                </div>

                <!-- Users Filters and Actions -->
                <div class="users-actions">
                    <div class="search-filter">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" placeholder="Buscar usuarios..." id="user-search">
                            <button class="clear-search" id="clear-search" title="Clear Search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="view-actions">
                        <div class="filter-chips">
                            <div class="filter-chip" data-filter="all">
                                <span>Todos</span>
                            </div>
                            <div class="filter-chip" data-filter="Administrador">
                                <span>Administradores</span>
                            </div>
                            <div class="filter-chip" data-filter="Empleado">
                                <span>Empleados</span>
                            </div>
                            <div class="filter-chip" data-filter="Usuario">
                                <span>Clientes</span>
                            </div>
                        </div>
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
                    function prepareUserData($user) {
                        $Id = htmlspecialchars($user['Id_Usuario'] ?? '');
                        $Id_Usuario = htmlspecialchars($user['Identificacion'] ?? 'Desconocido');
                        $Nombre = htmlspecialchars($user['Nombre'] ?? 'Desconocido');
                        $Apellidos = htmlspecialchars($user['Apellidos'] ?? 'Desconocido');
                        $Email = htmlspecialchars($user['Email'] ?? 'Desconocido');
                        $Telefono = htmlspecialchars($user['Telefono'] ?? 'Desconocido');
                        $Estado = htmlspecialchars($user['Estado'] ?? 'Desconocido');
                        $Id_Empresa = htmlspecialchars($user['Id_Empresa'] ?? '');
                        $Empresa = htmlspecialchars($user['NombreEmpresa'] ?? 'Sin Empresa');
                        $Rol = htmlspecialchars($user['Rol'] ?? 'Sin Rol');
                        $Foto = htmlspecialchars($user['Foto'] ?? '');

                        $Fecha_Creacion = isset($user['Fecha_Creacion']) && $user['Fecha_Creacion'] !== ''
                            ? date('d/m/Y', strtotime($user['Fecha_Creacion']))
                            : '';

                        $Fecha_Actualizacion = isset($user['Fecha_Actualizacion']) && $user['Fecha_Actualizacion'] !== ''
                            ? date('d/m/Y g:i:s A', strtotime($user['Fecha_Actualizacion']))
                            : '';

                        $Fecha_UltimoAcceso = isset($user['Fecha_UltimoAcceso']) && $user['Fecha_UltimoAcceso'] !== ''
                            ? date('d/m/Y g:i:s A', strtotime($user['Fecha_UltimoAcceso']))
                            : '';

                        $imgPath = !empty($Foto) ? "PImageUser/" . $Foto : "PImageUser/User_Unknown.jpg";

                        return compact(
                            'Id', 'Id_Usuario', 'Nombre', 'Apellidos', 'Email', 'Telefono','Estado',
                            'Empresa', 'Id_Empresa', 'Rol', 'Foto', 'Fecha_Creacion', 'Fecha_Actualizacion',
                            'Fecha_UltimoAcceso', 'imgPath'
                        );
                    }
                ?>

                <!-- Users Grid View (Default) -->
                <div class="users-grid" id="users-grid">
                    <?php 
                        foreach($UsersAll as $User){ 
                        $userData = prepareUserData($User);
                        extract($userData);
                    ?>
                        <!-- User Card -->
                        <div 
                            class="user-card" 
                            data-idneto="<?php echo $Id; ?>"
                            data-role="<?php echo $Rol; ?>" 
                            data-status="<?php echo $Estado; ?>"
                            data-id="<?php echo $Id_Usuario; ?>"
                            data-nombre="<?php echo $Nombre; ?>"
                            data-apellidos="<?php echo $Apellidos; ?>"
                            data-email="<?php echo $Email; ?>"
                            data-telefono="<?php echo $Telefono; ?>"
                            data-idempresa="<?php echo $Id_Empresa; ?>"
                            data-empresa="<?php echo $Empresa; ?>"
                            data-foto="<?php echo $imgPath; ?>"
                            >

                            <div class="user-card-header">
                                <div class="user-avatar">
                                    <img src="<?php echo $imgPath; ?>" alt="<?php echo $Nombre; echo " "; echo $Apellidos; ?>">
    
                                </div>
                                <div class="user-actions">
                                    <button class="btn-icon edit-user-btn" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                
                                </div>
                            </div>
                            <div class="user-info">
                                <h3><?php echo $Nombre; echo " "; echo $Apellidos; ?></h3>
                                <p class="user-email"><?php echo $Email; ?></p>
                                <div class="user-details">
                                    <p class="user-role <?php echo $Rol; ?>"><?php echo $Rol; ?></p>
                                    <p class="company-users"><?php echo $Empresa; ?></p>
                                </div>

                            </div>
                            <div class="user-meta">
                                <div class="meta-item">
                                    <i class="fa-solid fa-id-card"></i>
                                    <span class="data-id">Id: <?php echo $Id_Usuario; ?></span>
                                </div>
                                <div class="meta-item">
                                    <i class="fa-solid fa-mobile-screen-button"></i>
                                    <span>Cel: <?php echo $Telefono; ?></span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-calendar-plus"></i>
                                    <span>Se unió el <?php echo $Fecha_Creacion; ?></span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-edit"></i>
                                    <span>Actualización el <?php echo $Fecha_Actualizacion; ?></span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-clock"></i>
                                    <span>Última actividad el <?php echo $Fecha_UltimoAcceso; ?></span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-toggle-on"></i>
                                    <span>Estado: <?php echo $Estado; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <!-- Users List View (Hidden by default) -->
                <div class="users-list" id="users-list">
                    <div class="users-table">
                        <!-- Header de la tabla -->
                        <div class="table-header">
                            <div class="table-cell col-user">Usuario</div>
                            <div class="table-cell col-id">Identificación</div>
                            <div class="table-cell col-email">Email</div>
                            <div class="table-cell col-telefono">Telefono</div>
                            <div class="table-cell col-rol">Rol</div>
                            <div class="table-cell col-empresa">Empresa</div>
                            <div class="table-cell col-creado">Creado</div>
                            <div class="table-cell col-actualizado">Actualización</div>
                            <div class="table-cell col-actividad">Última actividad</div>
                            <div class="table-cell col-estado">Estado</div>
                            <div class="table-cell col-acciones">Acciones</div>
                        </div>

                        <?php 
                            foreach($UsersAll as $User){ 
                            $userData = prepareUserData($User);
                            extract($userData);
                        ?>
                            <!-- Fila de usuario -->
                            <div class="table-row" 
                                data-idneto="<?php echo $Id; ?>"
                                data-role="<?php echo $Rol; ?>" 
                                data-status="<?php echo $Estado; ?>"
                                data-id="<?php echo $Id_Usuario; ?>"
                                data-nombre="<?php echo $Nombre; ?>"
                                data-apellidos="<?php echo $Apellidos; ?>"
                                data-email="<?php echo $Email; ?>"
                                data-telefono="<?php echo $Telefono; ?>"
                                data-idempresa="<?php echo $Id_Empresa; ?>"
                                data-empresa="<?php echo $Empresa; ?>"
                                data-foto="<?php echo $imgPath; ?>"
                            >
                                <div class="table-cell col-user user-cell">
                                    <div class="user-avatar-small">
                                        <img src="<?php echo $imgPath; ?>" alt="<?php echo $Nombre; ?>">
                                        <span class="status-indicator active"></span>
                                    </div>
                                    <span><?php echo $Nombre . ' ' . $Apellidos; ?></span>
                                </div>
                                <div class="table-cell col-id"><span><?php echo $Id_Usuario; ?></span></div>
                                <div class="table-cell col-email"><span><?php echo $Email; ?></span></div>
                                <div class="table-cell col-telefono"><span><?php echo $Telefono; ?></span></div>
                                <div class="table-cell col-rol"><span class="role-badge <?php echo $Rol; ?>"><?php echo $Rol; ?></span></div>
                                <div class="table-cell col-empresa"><?php echo $Empresa; ?></div>
                                <div class="table-cell col-creado"><?php echo $Fecha_Creacion; ?></div>
                                <div class="table-cell col-actualizado"><?php echo $Fecha_Actualizacion; ?></div>
                                <div class="table-cell col-actividad"><?php echo $Fecha_UltimoAcceso; ?></div>
                                <div class="table-cell col-estado"><span class="status-badge <?php echo $Estado; ?>"><?php echo $Estado; ?></span></div>
                                <div class="table-cell col-acciones actions-cell">
                                    <button class="btn-icon edit-user-btn" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </button>
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

    <!-- Modal para añadir usuario -->
    <div class="modal" id="user-modal">
        <div class="modal-backdrop"></div>
        <div class="modal-container">
            <div class="modal-header">
                <h2 id="modal-title">Nuevo Usuario</h2>
                <button class="modal-close" id="modal-close" title="Cerrar modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="user-form" action="XZ" enctype="multipart/form-data" method="POST">
                    <input type="hidden" name="csrf_token" id="csrf_token_input"
                            value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="user-id">Identificación</label>
                            <input type="number" id="user-id" name="CC" class="form-input" placeholder="CC, NIT, ..." required>
                        </div>
                        <div class="form-group">
                            <label for="user-name">Nombre</label>
                            <input type="text" id="user-name" name="NOMBRES" class="form-input" placeholder="Nombre del usuario" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="user-lastname">Apellidos</label>
                            <input type="text" id="user-lastname" name="APELLIDOS" class="form-input" placeholder="Apellidos del usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="user-telefono">Telefono</label>
                            <input type="number" id="user-telefono" name="TELEFONO" class="form-input" placeholder="Telefono del usuario" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user-email">Email</label>
                        <input type="email" id="user-email" name="EMAIL" class="form-input" placeholder="correo@ejemplo.com" required>
                    </div>
                    <div class="form-group">
                        <label for="user-password">Contraseña</label>
                        <div class="password-input">
                            <input type="password" id="user-password" name="CONTRA" class="form-input" placeholder="Contraseña" required>
                            <button type="button" class="toggle-password" title="Mostrar/Ocultar contraseña">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="company-select">Empresa</label>
                        <select id="company-select" class="form-select" name="EMPRESA" required>
                            <option value="">Seleccionar empresa</option>
                            <?php
                            foreach ($CompaniesAll as $company) {
                                echo '<option value="' . htmlspecialchars($company['Id_Empresa']) . '">' . htmlspecialchars($company['Nombre']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="user-avatar">Foto de perfil</label>
                        <div class="avatar-upload">
                            <div class="avatar-preview">
                                <div id="avatar-preview-image"></div>
                            </div>
                            <label for="user-avatar-input" class="avatar-upload-btn">
                                <i class="fas fa-camera"></i>
                                <span>Subir imagen</span>
                            </label>
                            <input type="file" id="user-avatar-input" name="foto[]" accept="image/*" hidden>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user-role">Rol</label>
                        <select id="user-role" class="form-select" name="ROL" required>
                            <option value="">Seleccionar rol</option>
                            <option value="Administrador">Administrador</option>
                            <option value="Empleado">Empleado</option>
                            <option value="Usuario">Cliente</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" id="cancel-user">Cancelar</button>
                        <input type="hidden" name="accionRegistrarUsuario" value="RegistrarUsuario">
                        <input class="btn btn-primary" type="submit" name="Registrar" value="Guardar">
                    </div>
                </form>
            </div>
            <!-- <div class="modal-footer">
                <button class="btn btn-secondary" id="cancel-user">Cancelar</button>
                <input type="hidden" name="accionRegistrarUsuario" value="RegistrarUsuario">
                <input class="btn btn-primary" type="submit" name="Registrar" value="Guardar">
            </div> -->
        </div>
    </div>

    <!-- Modal para editar usuario -->
    <div class="modal" id="user-modal-edit">
        <div class="modal-backdrop"></div>
        <div class="modal-container">
            <div class="modal-header">
                <h2 id="modal-title">Editar Usuario</h2>
                <button class="modal-close" id="modal-close-edit" title="Cerrar modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="user-form-edit" action="XZ" enctype="multipart/form-data" method="POST">
                    <input type="hidden" name="csrf_token" id="csrf_token_input-edit"
                            value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <input type="hidden" name="ID_USUARIO" id="user-hidden-id-edit">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="user-id-edit">Identificación</label>
                            <input type="number" id="user-id-edit" name="CC" class="form-input" placeholder="CC, NIT, ..." required>
                        </div>
                        <div class="form-group">
                            <label for="user-name-edit">Nombre</label>
                            <input type="text" id="user-name-edit" name="NOMBRES" class="form-input" placeholder="Nombre del usuario" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="user-lastname-edit">Apellidos</label>
                            <input type="text" id="user-lastname-edit" name="APELLIDOS" class="form-input" placeholder="Apellidos del usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="user-telefono-edit">Telefono</label>
                            <input type="text" id="user-telefono-edit" name="TELEFONO" class="form-input" placeholder="Telefono del usuario" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user-email-edit">Email</label>
                        <input type="email" id="user-email-edit" name="EMAIL" class="form-input" placeholder="correo@ejemplo.com" required>
                    </div>
                    <div class="form-group">
                        <label for="company-select-edit">Empresa</label>
                        <select id="company-select-edit" class="form-select" name="EMPRESA" required>
                            <option value="">Seleccionar empresa</option>
                            <?php
                            foreach ($CompaniesAll as $company) {
                                echo '<option value="' . htmlspecialchars($company['Id_Empresa']) . '">' . htmlspecialchars($company['Nombre']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="user-avatar">Foto de perfil</label>
                        <div class="avatar-upload">
                            <div class="avatar-preview">
                                <div id="avatar-preview-image-edit"></div>
                            </div>
                            <label for="user-avatar-input-edit" class="avatar-upload-btn">
                                <i class="fas fa-camera"></i>
                                <span>Subir imagen</span>
                            </label>
                            <input type="file" id="user-avatar-input-edit" name="foto[]" accept="image/*" hidden>
                            <input type="hidden" name="FOTO_ACTUAL" id="foto_actual_edit">

                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="user-role-edit">Rol</label>
                            <select id="user-role-edit" class="form-select" name="ROL" required>
                                <option value="">Seleccionar rol</option>
                                <option value="Administrador">Administrador</option>
                                <option value="Empleado">Empleado</option>
                                <option value="Usuario">Cliente</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="user-status-edit">Estado</label>
                            <select id="user-status-edit" class="form-select" name="ESTADO" required>
                                <option value="">Seleccionar estado</option>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" id="cancel-user-edit">Cancelar</button>
                        <input type="hidden" name="accionEditarUsuario" value="Editar_Usuario">
                        <input class="btn btn-primary" type="submit" name="Editar" value="Editar Usuario">
                    </div>
                </form>
            </div>
            <!-- <div class="modal-footer">
                <button class="btn btn-secondary" id="cancel-user">Cancelar</button>
                <input type="hidden" name="accionRegistrarUsuario" value="RegistrarUsuario">
                <input class="btn btn-primary" type="submit" name="Registrar" value="Guardar">
            </div> -->
        </div>
    </div>

    <script src="Funcion_Menu"></script>

    <script src="Funcion_Sincronizacion"></script>
    <script src="Funcion_Usuarios"></script>
</body>
</html>
