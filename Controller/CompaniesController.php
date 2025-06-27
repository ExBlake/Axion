<?php
require_once(__DIR__ . '/../Modal/CompaniesModal.php');

class CompaniesController {
    /**
     * Controlador para registrar una nueva empresa.
     *
     * Este método valida la solicitud POST, verifica el token CSRF,
     * sanitiza y valida los campos obligatorios, maneja la subida del logo,
     * y finalmente llama al modelo para guardar los datos en la base de datos.
     */

    public function RegisterCompaniesController() {
        // 1) Solo POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['Mensaje'] = "Método de solicitud no permitido.";
            $_SESSION['MensajeTipo'] = "error";
            header("Location: Empresas");
            exit;
        }

        // 2) CSRF
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['Mensaje'] = "Por seguridad, tu sesión ha expirado. Intenta nuevamente.";
            $_SESSION['MensajeTipo'] = "error";
            header("Location: Inicio");
            exit;
        }

        // 3) Sanitizar campos
        $NIT         = trim(filter_var($_POST['NIT'], FILTER_SANITIZE_STRING));
        $Nombre      = trim(filter_var($_POST['NOMBRE'], FILTER_SANITIZE_STRING));
        $Categoria   = trim(filter_var($_POST['INDUSTRIA'], FILTER_SANITIZE_STRING));
        $Estado      = trim(filter_var($_POST['ESTADO'], FILTER_SANITIZE_STRING));
        $Descripcion = trim(filter_var($_POST['DESCRIPCION'], FILTER_SANITIZE_STRING));
        $Ubicacion   = trim(filter_var($_POST['UBICACION'], FILTER_SANITIZE_STRING));
        $Web         = trim(filter_var($_POST['WEB'], FILTER_SANITIZE_URL));

        // 4) Validar campos obligatorios
        $required = compact('NIT','Nombre','Categoria','Estado','Descripcion','Ubicacion');
        $errors = [];
        foreach ($required as $field => $value) {
            if ($value === '') {
                $errors[] = "El campo {$field} es obligatorio.";
            }
        }

        if (!empty($errors)) {
            $_SESSION['Mensaje'] = implode("<br>", $errors);
            $_SESSION['MensajeTipo'] = "error";
            header("Location: Empresas");
            exit;
        }

        // 5) Validar y mover logo
        if (!isset($_FILES['LOGO']) || $_FILES['LOGO']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['Mensaje'] = "Debes subir un logo válido para la empresa.";
            $_SESSION['MensajeTipo'] = "error";
            header("Location: Empresas");
            exit;
        }

        $allowed = ['image/jpeg','image/jpg','image/png'];
        $mime    = mime_content_type($_FILES['LOGO']['tmp_name']);
        if (!in_array($mime, $allowed)) {
            $_SESSION['Mensaje'] = "El logo debe ser una imagen en formato JPG, JPEG o PNG.";
            $_SESSION['MensajeTipo'] = "error";
            header("Location: Empresas");
            exit;
        }

        $ext      = pathinfo($_FILES['LOGO']['name'], PATHINFO_EXTENSION);
        $logoName = uniqid('logo_') . '.' . $ext;
        $destino  = __DIR__ . '/../PicturesCompanies/' . $logoName;

        if (!move_uploaded_file($_FILES['LOGO']['tmp_name'], $destino)) {
            $_SESSION['Mensaje'] = "Ocurrió un error al guardar el logo. Intenta nuevamente.";
            $_SESSION['MensajeTipo'] = "error";
            header("Location: Empresas");
            exit;
        }

        // 6) Llamar al modelo
        $model = new CompaniesModel();
        $ok = $model->RegisterCompaniesModel(
            $NIT,
            $Nombre,
            $Descripcion,
            $Categoria,
            $Estado,
            $Ubicacion,
            $Web,
            $logoName
        );

        // 7) Respuesta
        if ($ok === true) {
            $_SESSION['Mensaje'] = "¡La empresa fue registrada correctamente!";
            $_SESSION['MensajeTipo'] = "success";
        } else {
            $_SESSION['Mensaje'] = "Ocurrió un error al registrar la empresa. Por favor, verifica los datos e intenta de nuevo.";
            $_SESSION['MensajeTipo'] = "error";
        }

        header("Location: Empresas");
        exit;
    }

    /**
     * Controlador para obtener todas las empresas registradas.
     *
     * @return array Lista de empresas.
     */
    public function GetAllCompaniesController() {
        $User = new CompaniesModel();
        return $GetUsers = $User->GetAllCompaniesModel();
    }

    /**
     * Controlador para obtener todas las empresas junto con estadísticas.
     *
     * @return array Lista de empresas con estadísticas.
     */
    public function GetAllCompaniesWithStatsController() {
        $User = new CompaniesModel();
        return $GetUsers = $User->GetAllCompaniesWithStatsModel();
    }

    public function EditCompanyByAdminController() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // 1. Verificar si hay sesión activa
            if (!isset($_SESSION['usuario_id'])) {
                $_SESSION['Mensaje'] = "Por seguridad, tu sesión ha expirado. Intenta nuevamente.";
                $_SESSION['MensajeTipo'] = "error";
                header("Location: Inicio");
                exit();
            }

            // 2. Verificar token CSRF
            if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $_SESSION['Mensaje'] = "Solicitud inválida. Por seguridad, tu sesión ha expirado. Intenta nuevamente.";
                $_SESSION['MensajeTipo'] = "error";
                header("Location: Inicio");
                exit();
            }

            // 3. Recibir y limpiar datos del formulario
            $id = trim($_POST['ID_EMPRESA'] ?? '');
            $nit = trim($_POST['NIT']);
            $nombres = trim($_POST['NOMBRE']);
            $categoria = trim($_POST['INDUSTRIA']);
            $estado = trim($_POST['ESTADO']);
            $descripcion = trim($_POST['DESCRIPCION']);
            $ubicacion = trim($_POST['UBICACION']);
            $web = trim($_POST['WEB']);
            $fotoActual = $_POST['FOTO_ACTUAL'] ?? null;
            $nuevaFoto = $_FILES['LOGO'] ?? null;
            $rutaFinal = $fotoActual; // Por defecto se conserva la misma foto

            // 4. Procesar nueva imagen si se subió
            if ($nuevaFoto && $nuevaFoto['name'] !== '') {
                $directorioBase = __DIR__ . '/../PicturesCompanies/';
                $directorioBackup = __DIR__ . '/../BackUps/PicturesCompanies/';

                // Crear directorios si no existen
                if (!is_dir($directorioBackup)) mkdir($directorioBackup, 0777, true);
                if (!is_dir($directorioBase)) mkdir($directorioBase, 0777, true);

                // Extraer información del archivo subido
                $tmpName = $nuevaFoto['tmp_name'];
                $originalName = $nuevaFoto['name'];
                $fileSize = $nuevaFoto['size'];
                $fileType = mime_content_type($tmpName);
                $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];

                // Validar extensión
                if (!in_array($ext, $extensionesPermitidas)) {
                    $_SESSION['Mensaje'] = "La imagen debe ser JPG, JPEG, PNG o WEBP.";
                    $_SESSION['MensajeTipo'] = "error";
                    header("Location: Empresas");
                    exit();
                }

                // Validar tipo MIME
                if (!str_starts_with($fileType, 'image/')) {
                    $_SESSION['Mensaje'] = "El archivo cargado no es una imagen válida.";
                    $_SESSION['MensajeTipo'] = "error";
                    header("Location: Empresas");
                    exit();
                }

                // Validar tamaño (máximo 5MB)
                if ($fileSize > 5 * 1024 * 1024) {
                    $_SESSION['Mensaje'] = "El logo no debe superar los 5MB.";
                    $_SESSION['MensajeTipo'] = "error";
                    header("Location: Empresas");
                    exit();
                }

                // Respaldar imagen anterior si existe
                $rutaFotoActual = $directorioBase . $fotoActual;
                if ($fotoActual && file_exists($rutaFotoActual)) {
                    rename($rutaFotoActual, $directorioBackup . $fotoActual);
                }

                // Generar nombre único
                $codigoAleatorio = substr(bin2hex(random_bytes(5)), 0, 10); // 10 caracteres
                $nombreNuevo = "com_" . $codigoAleatorio . "_" . $nit . "." . $ext;
                $rutaNueva = $directorioBase . $nombreNuevo;

                // Guardar nueva imagen
                if (!move_uploaded_file($tmpName, $rutaNueva)) {
                    $_SESSION['Mensaje'] = "Error al guardar el nuevo logo.";
                    $_SESSION['MensajeTipo'] = "error";
                    header("Location: Empresas");
                    exit();
                }

                $rutaFinal = $nombreNuevo; // Usar la nueva imagen
            }

            // 5. Actualizar la empresa en la base de datos
            try {
                $companyModel = new CompaniesModel();
                $companyModel->UpdateCompanyByAdmin($id, $nit, $nombres, $categoria, $estado, $descripcion, $ubicacion, $web, $rutaFinal);

                $_SESSION['Mensaje'] = "¡La empresa ha sido actualizada correctamente!";
                $_SESSION['MensajeTipo'] = "success";
            } catch (Exception $e) {
                $_SESSION['Mensaje'] = "Error al actualizar la empresa: " . $e->getMessage();
                $_SESSION['MensajeTipo'] = "error";
            }

            // 6. Regenerar token CSRF
            unset($_SESSION['csrf_token']);
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

            // 7. Redirigir a la vista de empresas
            header("Location: Empresas");
            exit();
        }
    }

}
