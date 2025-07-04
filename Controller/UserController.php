<?php
require_once(__DIR__ . '/../Modal/UserModal.php');

class UserController{

    /**
     * Registra un nuevo usuario después de validar los campos y el token CSRF.
     * @return void
     */
    public function RegisterUserController() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Verificación CSRF
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $_SESSION['Mensaje'] = "Por seguridad, tu sesión ha expirado. Intenta nuevamente.";
                $_SESSION['MensajeTipo'] = "error";
                header("Location: Inicio");
                exit;
            }

            // Verificar campos obligatorios
            $required = ['CC', 'NOMBRES', 'APELLIDOS', 'EMAIL', 'CONTRA', 'ROL'];
            foreach ($required as $campo) {
                if (!isset($_POST[$campo])) {
                    $_SESSION['Mensaje'] = "Error: Falta el campo $campo.";
                    $_SESSION['MensajeTipo'] = "error";
                    header("Location: Usuarios");
                    exit;
                }
            }

            // Validación
            $Cedula = filter_var($_POST['CC'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);
            $Nombre = htmlspecialchars(trim($_POST['NOMBRES']), ENT_QUOTES, 'UTF-8');
            $Apellidos = htmlspecialchars(trim($_POST['APELLIDOS']), ENT_QUOTES, 'UTF-8');
            $Correo = filter_var(trim($_POST['EMAIL']), FILTER_VALIDATE_EMAIL);
            $Telefono = trim($_POST['TELEFONO']);
            $Contrasena = trim($_POST['CONTRA']);
            $Rol = htmlspecialchars(trim($_POST['ROL']), ENT_QUOTES, 'UTF-8');
            $Empresa = htmlspecialchars(trim($_POST['EMPRESA']), ENT_QUOTES, 'UTF-8');

            if ($Cedula && $Nombre && $Apellidos && $Correo && $Contrasena && $Rol) {
                $usuario = new UsuarioModel();
                $registro_exitoso = $usuario->RegisterUserModel($Empresa, $Cedula, $Nombre, $Apellidos, $Correo, $Contrasena, $Telefono, $Rol, $Fotos ?? null);

                if ($registro_exitoso === true) {
                    $_SESSION['Mensaje'] = "¡El usuario fue registrado correctamente!";
                    $_SESSION['MensajeTipo'] = "success";
                } elseif (is_string($registro_exitoso)) {
                    $_SESSION['Mensaje'] = $registro_exitoso;
                    $_SESSION['MensajeTipo'] = "error";
                } else {
                    $_SESSION['Mensaje'] = "Advertencia: Los datos no son válidos.";
                    $_SESSION['MensajeTipo'] = "error";
                }
            } else {
                $_SESSION['Mensaje'] = "Advertencia: Algunos datos no son válidos.";
                $_SESSION['MensajeTipo'] = "error";
            }

            header("Location: Usuarios");
            exit;
        }
    }

    /**
     * Verifica las credenciales del usuario y lo autentica si son válidas.
     * @return void
     */
    public function IniciarSesionController() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['Mensaje'] = "Método de solicitud no permitido.";
            $_SESSION['MensajeTipo'] = "error";
            header('Location: Inicio');
            exit;
        }

        // Validar CSRF (si no lo haces en un archivo intermedio)
        if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
            !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            $_SESSION['Mensaje'] = "Por seguridad, tu sesión ha expirado. Intenta nuevamente.";
            $_SESSION['MensajeTipo'] = "error";
            header('Location: Inicio');
            exit;
        }

        // Sanitización de inputs
        $email = filter_input(INPUT_POST, 'EMAIL', FILTER_VALIDATE_EMAIL);
        $contrasena = filter_input(INPUT_POST, 'CONTRASENA', FILTER_SANITIZE_STRING);

        if (!$email || !$contrasena) {
            $_SESSION['Mensaje'] = 'Por favor, ingresa un correo y contraseña válidos.';
            $_SESSION['MensajeTipo'] = 'error';
            header('Location: Inicio');
            exit;
        }

        // Validación contra base de datos
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->IniciarSesionModel($email, $contrasena);

        if ($usuario) {
            // Proteger la sesión
            session_regenerate_id(true);

            $_SESSION['usuario_id'] = $usuario['Id_Usuario'];
            $_SESSION['nombre_usu'] = $usuario['Nombre'];
            // $_SESSION['rol'] = $usuario['Rol']; // Descomenta si lo usas

            header('Location: Tablero'); // Redirige al dashboard
            exit;
        } else {
            $_SESSION['Mensaje'] = 'Credenciales incorrectas. Intenta de nuevo.';
            $_SESSION['MensajeTipo'] = 'error';
            header('Location: Inicio');
            exit;
        }
    }

    /**
     * Obtiene los datos del usuario en sesión.
     * @return array|null
     */
    public function GetUserBySessionController(){
        
        if (session_status() == PHP_SESSION_NONE) {
        session_start();
            }   

        // Verificar si el usuario ha iniciado sesión
        if (isset($_SESSION['usuario_id'])) {
            $usuarioID = $_SESSION['usuario_id'];

            // Obtener los datos del usuario desde el modelo
            $usuarioModel = new UsuarioModel();
            $usuario = $usuarioModel->GetUserByIdModel($usuarioID);

            // Cargar la vista para mostrar el perfil
            return $usuario;
        } else {
            // Redirigir al inicio de sesión si el usuario no ha iniciado sesión
            $_SESSION['Mensaje'] = "Por seguridad, tu sesión ha expirado. Intenta nuevamente.";
            $_SESSION['MensajeTipo'] = "success";
            header('Location: Inicio');
            exit();
        }
    }

    /**
     * Obtiene los planes de la empresa asociada al usuario autenticado.
     * @return array|null
     */
    public function GetPlansByCompanyController() {
        // Inicia la sesión si aún no se ha iniciado
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Verificar si el usuario ha iniciado sesión
        if (isset($_SESSION['usuario_id'])) {
            $usuarioID = $_SESSION['usuario_id'];
            
            // Obtener los planes correspondientes a la empresa del usuario desde el modelo
            $usuarioModel = new UsuarioModel();
            $planes = $usuarioModel->GetPlansByCompany($usuarioID);
            
            // Retornar los planes para usarlos en la vista o para procesamiento adicional
            return $planes;
        } else {
            // Si no hay sesión, redirigir al inicio de sesión
            $_SESSION['Mensaje'] = "Por seguridad, tu sesión ha expirado. Intenta nuevamente.";
            $_SESSION['MensajeTipo'] = "success";
            header('Location: Inicio');
            exit();
        }
    }
    
    /**
     * Obtiene los reportes de un plan específico asociado a una empresa.
     * @param string $planId
     * @param string $empresaId
     * @return array|null
     */
    public function GetReportsByPlansController($planId, $empresaId) {
        // Inicia la sesión si aún no se ha iniciado
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Verificar si el usuario ha iniciado sesión
        if (isset($_SESSION['usuario_id'])) {            
            // Obtener los planes correspondientes a la empresa del usuario desde el modelo
            $usuarioModel = new UsuarioModel();
            $planes = $usuarioModel->GetPlanByUrl($planId, $empresaId);
            
            // Retornar los planes para usarlos en la vista o para procesamiento adicional
            return $planes;
        } else {
            // Si no hay sesión, redirigir al inicio de sesión
            $_SESSION['Mensaje'] = "Por seguridad, tu sesión ha expirado. Intenta nuevamente.";
            $_SESSION['MensajeTipo'] = "success";
            header('Location: Inicio');
            exit();
        }
    }

    /**
     * Obtiene los datos del perfil del usuario en sesión.
     * @return array|null
     */
    public function GetUserForProfileController() {

        if (session_status() == PHP_SESSION_NONE) {
        session_start();
            }   

        // Verificar si el usuario ha iniciado sesión
        if (isset($_SESSION['usuario_id'])) {
            $usuarioID = $_SESSION['usuario_id'];

            // Obtener los datos del usuario desde el modelo
            $usuarioModel = new UsuarioModel();
            $usuario = $usuarioModel->GetUserForProfileModal($usuarioID);

            // Cargar la vista para mostrar el perfil
            return $usuario;
        } else {
            // Redirigir al inicio de sesión si el usuario no ha iniciado sesión
            $_SESSION['Mensaje'] = "Por seguridad, tu sesión ha expirado. Intenta nuevamente.";
            $_SESSION['MensajeTipo'] = "success";
            header('Location: Inicio');
            exit();
        }
    }

    /**
     * Edita los datos del perfil del usuario incluyendo la foto si fue subida.
     * @param string $nombre
     * @param string $apellidos
     * @param string $email
     * @param int $telefono
     * @return void
     */
    public function EditUserForProfileController($nombre, $apellidos, $email, $telefono) {
        if (session_status() == PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['usuario_id'])) {
            $_SESSION['Mensaje'] = "Por seguridad, tu sesión ha expirado. Intenta nuevamente.";
            $_SESSION['MensajeTipo'] = "error";
            header("Location: Inicio");
            exit();
        }

        $usuarioID = $_SESSION['usuario_id'];

        $nombre = trim($nombre);
        $apellidos = trim($apellidos);
        $telefono = trim($telefono);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Correo no válido");
        }

        $fotoFinal = $_POST['FOTO_ACTUAL']; // Valor por defecto
        $rutaFotos = __DIR__ . '/../PicturesUsers/';

        if (isset($_FILES['FOTO']) && $_FILES['FOTO']['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['FOTO']['tmp_name'];
            $extension = pathinfo($_FILES['FOTO']['name'], PATHINFO_EXTENSION);
            $nuevoNombre = uniqid('profile_', true) . '.' . $extension;
            $destino = $rutaFotos . $nuevoNombre;

            // Eliminar la foto anterior si existe
            if (!empty($_POST['FOTO_ACTUAL'])) {
                $fotoAnterior = $rutaFotos . $_POST['FOTO_ACTUAL'];
                if (file_exists($fotoAnterior)) {
                    unlink($fotoAnterior);
                }
            }

            // Mover la nueva imagen
            move_uploaded_file($tmp_name, $destino);
            $fotoFinal = $nuevoNombre;
        }

        $usuarioModel = new UsuarioModel();
        $usuarioModel->EditUserForProfile($usuarioID, $nombre, $apellidos, $email, $fotoFinal, $telefono);
        $_SESSION['Mensaje'] = "¡Los datos del usuario han sido actualizados correctamente!";
        $_SESSION['MensajeTipo'] = "success";
        header("Location: Configuracion");
        exit();
    }

    /**
     * Retorna todos los usuarios junto a su empresa.
     * @return array
     */
    public function GetAllUserController() {
        $Users = new UsuarioModel();
        $User = $Users->GetAllUsersWithCompanyModel();
        return $User;
    }

    /**
     * Actualiza la contraseña del usuario autenticado.
     * 
     * Verifica el método POST, que el usuario esté autenticado y que el token CSRF sea válido.
     * Valida la contraseña actual y la nueva antes de actualizarla en la base de datos.
     * Informa mediante mensajes de sesión el resultado del proceso.
     * 
     * @return void
     */
    public function UpdatePasswordController() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificación de sesión activa
            if (!isset($_SESSION['usuario_id'])) {
                $_SESSION['Mensaje'] = "Por seguridad, tu sesión ha expirado. Intenta nuevamente.";
                $_SESSION['MensajeTipo'] = "error";
                header("Location: Inicio");
                exit();
            }

            // Verificación de token CSRF
            if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $_SESSION['Mensaje'] = "Solicitud inválida. Intenta nuevamente.";
                $_SESSION['MensajeTipo'] = "error";
                header("Location: Configuracion#security");
                exit();
            }

            $userId = $_SESSION['usuario_id'];

            // Sanitización y validación básica
            $CurrentPassword = trim($_POST['PASSWORD_CURRENT'] ?? '');
            $NewPassword     = trim($_POST['PASSWORD_NEW'] ?? '');
            $ConfirmPassword = trim($_POST['PASSWORD_CONFIRM'] ?? '');

            // Validación de nueva contraseña
            if (strlen($NewPassword) < 8) {
                $_SESSION['Mensaje'] = "La nueva contraseña debe tener al menos 8 caracteres.";
                $_SESSION['MensajeTipo'] = "error";
                header("Location: Configuracion#security");
                exit();
            }

            if ($NewPassword !== $ConfirmPassword) {
                $_SESSION['Mensaje'] = "La nueva contraseña y la confirmación no coinciden.";
                $_SESSION['MensajeTipo'] = "error";
                header("Location: Configuracion#security");
                exit();
            }

            $UsersModel = new UsuarioModel();
            $UserData = $UsersModel->GetUserById($userId);

            if (!$UserData || !password_verify($CurrentPassword, $UserData['Contrasena'])) {
                $_SESSION['Mensaje'] = "La contraseña actual es incorrecta.";
                $_SESSION['MensajeTipo'] = "error";
                header("Location: Configuracion#security");
                exit();
            }

            // Actualización de contraseña
            $NewHashedPassword = password_hash($NewPassword, PASSWORD_BCRYPT);
            $UsersModel->UpdatePassword($userId, $NewHashedPassword);

            // Regeneración del token CSRF por seguridad
            unset($_SESSION['csrf_token']);
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

            $_SESSION['Mensaje'] = "Contraseña actualizada correctamente.";
            $_SESSION['MensajeTipo'] = "success";
            header("Location: Configuracion#security");
            exit();
        }
    }

    /**
     * Controlador que permite a un administrador editar los datos de un usuario.
     * Incluye validaciones de seguridad, validaciones de imagen, respaldo de imagen anterior,
     * y actualización en base de datos usando el modelo UsuarioModel.
     */
    public function EditUserByAdminController() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // 1. Verificar si hay sesión activa
            if (!isset($_SESSION['usuario_id'])) {
                $_SESSION['Mensaje'] = "Por seguridad, tu sesión ha expirado. Intenta nuevamente.";
                $_SESSION['MensajeTipo'] = "error";
                header("Location: Inicio");
                exit();
            }

            // 2. Verificar token CSRF para prevenir ataques de falsificación de solicitudes
            if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $_SESSION['Mensaje'] = "Solicitud inválida. Por seguridad, tu sesión ha expirado. Intenta nuevamente.";
                $_SESSION['MensajeTipo'] = "error";
                header("Location: Inicio");
                exit();
            }

            // 3. Recolectar datos del formulario
            $id = trim($_POST['ID_USUARIO']);
            $cc = trim($_POST['CC']);
            $nombres = trim($_POST['NOMBRES']);
            $apellidos = trim($_POST['APELLIDOS']);
            $email = trim($_POST['EMAIL']);
            $Telefono = trim($_POST['TELEFONO']);
            $empresa = trim($_POST['EMPRESA']);
            $rol = trim($_POST['ROL']);
            $estado = trim($_POST['ESTADO']);
            $fotoActual = $_POST['FOTO_ACTUAL'] ?? null;
            $nuevaFoto = $_FILES['foto'] ?? null;
            $rutaFinal = $fotoActual; // Por defecto se conserva la misma foto

            // 4. Validación básica del correo electrónico
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['Mensaje'] = "El correo electrónico no es válido.";
                $_SESSION['MensajeTipo'] = "error";
                header("Location: Usuarios");
                exit();
            }

            // 5. Procesar nueva imagen si se subió
            if ($nuevaFoto && $nuevaFoto['name'][0] !== '') {
                $directorioBase = __DIR__ . '/../PicturesUsers/';
                $directorioBackup = __DIR__ . '/../BackUps/PicturesUsers/';

                // Crear directorios si no existen
                if (!is_dir($directorioBackup)) mkdir($directorioBackup, 0777, true);
                if (!is_dir($directorioBase)) mkdir($directorioBase, 0777, true);

                // Extraer información del archivo subido
                $tmpName = $nuevaFoto['tmp_name'][0];
                $originalName = $nuevaFoto['name'][0];
                $fileSize = $nuevaFoto['size'][0];
                $fileType = mime_content_type($tmpName);
                $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];

                // Validar extensión
                if (!in_array($ext, $extensionesPermitidas)) {
                    $_SESSION['Mensaje'] = "La imagen debe ser JPG, JPEG, PNG o WEBP.";
                    $_SESSION['MensajeTipo'] = "error";
                    header("Location: Usuarios");
                    exit();
                }

                // Validar tipo MIME
                if (!str_starts_with($fileType, 'image/')) {
                    $_SESSION['Mensaje'] = "El archivo cargado no es una imagen válida.";
                    $_SESSION['MensajeTipo'] = "error";
                    header("Location: Usuarios");
                    exit();
                }

                // Validar tamaño (máximo 5MB)
                if ($fileSize > 5 * 1024 * 1024) {
                    $_SESSION['Mensaje'] = "La imagen no debe superar los 5MB.";
                    $_SESSION['MensajeTipo'] = "error";
                    header("Location: Usuarios");
                    exit();
                }

                // Respaldar imagen anterior si existe
                $rutaFotoActual = $directorioBase . $fotoActual;
                if ($fotoActual && file_exists($rutaFotoActual)) {
                    rename($rutaFotoActual, $directorioBackup . $fotoActual);
                }

                // Generar nombre único con código aleatorio y número de cédula
                $codigoAleatorio = substr(bin2hex(random_bytes(5)), 0, 10); // 10 caracteres aleatorios
                $nombreNuevo = "user_" . $codigoAleatorio . "_" . $cc . "." . $ext;
                $rutaNueva = $directorioBase . $nombreNuevo;

                // Guardar nueva imagen
                if (!move_uploaded_file($tmpName, $rutaNueva)) {
                    $_SESSION['Mensaje'] = "Error al guardar la nueva imagen de perfil.";
                    $_SESSION['MensajeTipo'] = "error";
                    header("Location: Usuarios");
                    exit();
                }

                $rutaFinal = $nombreNuevo; // Actualizar variable con nueva ruta
            }

            // 6. Intentar actualizar el usuario en la base de datos
            try {
                $userModel = new UsuarioModel();
                $userModel->UpdateUserByAdmin($id, $cc, $nombres, $apellidos, $email, $Telefono, $empresa, $rol, $estado, $rutaFinal);

                $_SESSION['Mensaje'] = "¡El usuario ha sido actualizado correctamente!";
                $_SESSION['MensajeTipo'] = "success";
            } catch (Exception $e) {
                $_SESSION['Mensaje'] = "Error al actualizar el usuario: " . $e->getMessage();
                $_SESSION['MensajeTipo'] = "error";
            }

            // 7. Regenerar el token CSRF para evitar reenvíos con el mismo token
            unset($_SESSION['csrf_token']);
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

            // 8. Redirigir a la vista de usuarios
            header("Location: Usuarios");
            exit();
        }
    }
}
?>
