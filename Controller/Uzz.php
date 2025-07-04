<?php
session_start();
require_once(__DIR__ . '/UserController.php');
require_once(__DIR__ . '/CompaniesController.php');
require_once(__DIR__ . '/PQRSController.php');
require_once(__DIR__ . '/PlanReportController.php');

//**********************************************/
// CONTROLADOR PRINCIPAL PARA ENRUTAR LOS FORMULARIOS POST
//**********************************************/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //**********************************************/
    // VERIFICACIÓN DE SEGURIDAD CSRF
    //**********************************************/

    if (isset($_SESSION['csrf_token'], $_POST['csrf_token']) &&
        hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {

        // Instancia de controladores
        $User = new UserController();
        $Company = new CompaniesController();
        $PQRS = new PQRSController();
        $Reporting = new PlanesReportController();

        
        //**********************************************/
        // USUARIOS - REGISTRO
        //**********************************************/

        if (isset($_POST['accionRegistrarUsuario']) && $_POST['accionRegistrarUsuario'] === 'RegistrarUsuario') {
            $UserReg = $User->RegisterUserController();
        } 

        //**********************************************/
        // USUARIOS - INICIO DE SESIÓN
        //**********************************************/

        elseif (isset($_POST['accionIniciarSesion']) && $_POST['accionIniciarSesion'] === 'Iniciar_Sesion') {
            $Login = $User->IniciarSesionController();
        }
        
        //**********************************************/
        // USUARIOS - ACTUALIZAR PERFIL
        //**********************************************/

        elseif (isset($_POST['accion_Guardar_Perfil']) && $_POST['accion_Guardar_Perfil'] === 'Guardar_Perfil') {
            $nombre = $_POST['NOMBRE'] ?? '';
            $apellidos = $_POST['APELLIDOS'] ?? '';
            $email = $_POST['EMAIL'] ?? '';
            $telefono = $_POST['TELEFONO'] ?? '';

            $UserEditProfile = $User->EditUserForProfileController($nombre, $apellidos, $email, $telefono);
        }
        
        //**********************************************/
        // USUARIOS - ACTUALIZAR CONTRASEÑA
        //**********************************************/
        elseif (isset($_POST['accion_Actualizar_Contrasena']) && $_POST['accion_Actualizar_Contrasena'] === 'Actualizar_Contrasena') {
            $Actual = trim($_POST['PASSWORD_CURRENT'] ?? '');
            $Clave_Nueva = trim($_POST['PASSWORD_NEW'] ?? '');
            $Confirmar_Clave = trim($_POST['PASSWORD_CONFIRM'] ?? '');
            $UserEditPassword = $User->UpdatePasswordController($Actual, $Clave_Nueva, $Confirmar_Clave);
        }

        //**********************************************/
        // USUARIOS - EDITAR USUARIO POR ADMIN
        //**********************************************/
        elseif (isset($_POST['accionEditarUsuario']) && $_POST['accionEditarUsuario'] === 'Editar_Usuario') {
            $User->EditUserByAdminController();
        }

        //**********************************************/
        // EMPRESAS - REGISTRO
        //**********************************************/
        if (isset($_POST['accionCompany']) && $_POST['accionCompany'] === 'Registrar_Empresa') {
            $CompanyReg = $Company->RegisterCompaniesController();
        } 
        
        //**********************************************/
        // EMPRESAS - EDITAR
        //**********************************************/
        elseif (isset($_POST['accionCompany']) && $_POST['accionCompany'] === 'Editar_Empresa') {
            $CompanyEdit = $Company->EditCompanyByAdminController();
        }


        //**********************************************/
        // PQRS - REGISTRO
        //**********************************************/
        if(isset($_POST['accionRegistrarPQRS']) && $_POST['accionRegistrarPQRS'] === 'RegistrarPQRS') {
            $PQRSNew = $PQRS->RegisterPQRSController();
        }

        //**********************************************/
        // PQRS - RESPUESTA PQRS
        //**********************************************/
        elseif (isset($_POST['accion_Guardar_Respuesta']) && $_POST['accion_Guardar_Respuesta'] === 'Guardar_Respuesta') {
            $respuesta = $_POST['RESPUESTA'] ?? '';
            $idPQRS = $_POST['Id_PQRS'] ?? '';
            $PQRSResponse = $PQRS->EditRespondToPQRController($idPQRS, $respuesta);
        }

        //**********************************************/
        // REPORTING - REGISTRO
        //**********************************************/
        if(isset($_POST['accionReporting']) && $_POST['accionReporting'] === 'Registrar_Reporting') {
            $RepotingNew = $Reporting->RegisterReportingController();
        }
        
        elseif(isset($_POST['accionReporting']) && $_POST['accionReporting'] === 'Editar_Reporting'){
            $RepotingEdit = $Reporting->EditReportController();
        }


    } else {
        //**********************************************/
        // ERROR DE VERIFICACIÓN CSRF
        //**********************************************/
        $_SESSION['Mensaje'] = "Token no válido.";
        $_SESSION['MensajeTipo'] = "error";
        header("Location: Inicio");
        exit;
    }
}
?>


