<?php 
    require_once(__DIR__ . '/../../Controller/UserController.php');
    $userController = new UserController();
    $userDetails = $userController->GetUserBySessionController();
    $userCompany = $userController->GetReportByCompanyController();


    $rolUsuario = isset($userDetails['Rol']) ? $userDetails['Rol'] : 'Empleado'; // valor por defecto
    // Se asume que el usuario solo pertenece a una empresa, por lo que el nombre de la empresa es el de la primera fila.
    $companyName = (!empty($userCompany) && isset($userCompany[0]['Empresa'])) ? $userCompany[0]['Empresa'] : 'Sin Empresa';
?>
<div class="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <div class="logo-circle">
                <i class="fas fa-cube"></i>
            </div>
            <span class="logo-text">Axion</span>
        </div>
        <button id="sidebar-toggle" class="sidebar-toggle" title="Toggle Sidebar">
            <i class="fas fa-chevron-left"></i>
        </button>
    </div>

    <div class="sidebar-menu">
        <ul>

            <li>
                <a href="Tablero">
                    <i class="fas fa-house"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <?php if ($rolUsuario === 'Administrador'){ ?>
            <li>
                <a href="Empresas">
                    <i class="fas fa-layer-group"></i>
                    <span>Empresas</span>
                </a>
            </li>
            <li>
                <a href="Usuarios">
                    <i class="fa-solid fa-users"></i>
                    <span>Usuarios</span>
                </a>
            </li>
            <li>
                <a href="Reportes">
                   <i class="fas fa-chart-bar"></i>
                    <span>Reportes</span>
                </a>
            </li>
            <?php } ?>
            <!-- Menú dinámico basado en la empresa del usuario y sus planes -->
            <?php 
                if (!empty($userCompany)) {
                    // Agrupar informes por empresa
                    $empresas = [];
                    foreach ($userCompany as $reporte) {
                        $empresaNombre = $reporte['Empresa'];
                        $empresas[$empresaNombre][] = $reporte;
                    }
                }
                ?>

                <?php if (!empty($empresas)): ?>
                    <?php foreach ($empresas as $empresa => $informes): ?>
                        <li class="has-submenu">
                            <a href="#<?php echo htmlspecialchars($empresa); ?>">
                                <i class="fas fa-building"></i>
                                <span><?php echo htmlspecialchars($empresa); ?></span>
                                <i class="fas fa-chevron-right submenu-arrow"></i>
                            </a>
                            <ul class="submenu">
                                <?php foreach ($informes as $informe): ?>
                                    <li>
                                        <a href="Informes?i=<?= urlencode($informe['Id_Informe']) ?>&e=<?= urlencode($informe['Id_Empresa']) ?>">
                                            <?= htmlspecialchars($informe['Nombre_Informe']) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="has-submenu">
                        <a href="#no-company">
                            <i class="fas fa-building"></i>
                            <span>Sin Empresa</span>
                            <i class="fas fa-chevron-right submenu-arrow"></i>
                        </a>
                        <ul class="submenu">
                            <li><a href="#">No hay informes</a></li>
                        </ul>
                    </li>
                <?php endif; ?>


            <li>
                <a href="PQRS">
                    <i class="fas fa-message"></i>
                    <span>PQRS</span>
                </a>
            </li>
             <li>
                <a href="Planes">
                 <i class="fas fa-briefcase"></i>
                    <span>Planes</span>
                </a>
            </li>
            <li>
                <a href="Tutoriales">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Tutoriales</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="sidebar-footer">
        <a href="Configuracion" class="active">
            <i class="fas fa-gear"></i>
            <span>Configuración</span>
        </a>
        <a href="Log">
            <i class="fas fa-arrow-right-from-bracket"></i>
            <span>Cerrar Sesión</span>
        </a>
    </div>
</div>
<!-- Botón flotante para mostrar el sidebar -->
<button id="show-sidebar-btn" class="show-sidebar-btn" title="Show Sidebar">
    <i class="fas fa-bars"></i>
</button>