<?php
require_once(__DIR__ . '/../Modal/PQRSModel.php');

class PQRSController {
    /**
     * Registra una nueva solicitud PQRS (Peticiones, Quejas, Reclamos, Sugerencias).
     * Este método:
     *   1. Verifica que el método de solicitud sea POST.
     *   2. Verifica la validez del token CSRF.
     *   3. Valida y sanitiza los campos obligatorios: tipo, asunto y descripción.
     *   4. Llama al modelo para insertar el registro en la base de datos.
     *   5. Establece mensajes de sesión según el resultado.
     */
    public function RegisterPQRSController() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificación CSRF
            if (!isset($_POST['csrf_token'], $_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
                $_SESSION['Mensaje'] = "Por seguridad, tu sesión ha expirado. Intenta nuevamente.";
                $_SESSION['MensajeTipo'] = "error";
                header("Location: Inicio");
                exit;
            }

            // Verificar campos obligatorios
            $required = ['TIPO', 'ASUNTO', 'DESCRIPCION'];
            foreach ($required as $campo) {
                if (empty($_POST[$campo])) {
                    $_SESSION['Mensaje'] = "Error: Falta el campo $campo.";
                    $_SESSION['MensajeTipo'] = "error";
                    header("Location: PQRS");
                    exit;
                }
            }

            // Sanitización
            $Tipo = filter_var(trim($_POST['TIPO']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $Asunto = filter_var(trim($_POST['ASUNTO']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $Descripcion = filter_var(trim($_POST['DESCRIPCION']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Validar longitud mínima o tipo si es necesario
            if (strlen($Tipo) < 3 || strlen($Asunto) < 3 || strlen($Descripcion) < 5) {
                $_SESSION['Mensaje'] = "Advertencia: Algunos campos no cumplen con los requisitos mínimos.";
                $_SESSION['MensajeTipo'] = "error";
                header("Location: PQRS");
                exit;
            }

            $pqrsModel = new PQRSModel();
            $registro_exitoso = $pqrsModel->RegisterPQRSModel($Tipo, $Asunto, $Descripcion);

            if ($registro_exitoso === true) {
                $_SESSION['Mensaje'] = "¡El PQRS fue registrada correctamente!";
                $_SESSION['MensajeTipo'] = "success";
            } elseif (is_string($registro_exitoso)) {
                $_SESSION['Mensaje'] = $registro_exitoso;
                $_SESSION['MensajeTipo'] = "error";
            } else {
                $_SESSION['Mensaje'] = "Error: No se pudo registrar la PQRS. Intenta nuevamente.";
                $_SESSION['MensajeTipo'] = "error";
            }

            header("Location: PQRS");
            exit;
        }
    }

    /**
     * Obtiene todas las PQRS registradas en el sistema.
     * @return array Lista de PQRS.
     */
    public function GetAllPQRsController(){
        $PQRs = new PQRSModel();
        return $GetPQRs = $PQRs->GetAllPQRSModel();
    }

    /**
     * Obtiene estadísticas de PQRS agrupadas por tipo.
     * @param string $Tipo Tipo de PQRS (ej: Petición, Queja, etc.)
     * @return array Estadísticas por tipo.
     */
    public function GetAllStadisticsController($Tipo){
        $PQRs = new PQRSModel();
        return $GetPQRs = $PQRs->GetAllStadisticsModel($Tipo);
    }
    
    /**
     * Obtiene los archivos adjuntos relacionados con una PQRS específica.
     * @param int $Id ID de la PQRS.
     * @return array Lista de archivos relacionados.
     */
    public function GetAllArchiveByPQRSController($Id){
        $PQRs = new PQRSModel();
        return $GetPQRs = $PQRs->GetArchivosByPQRModel($Id);
    }
    
     /**
     * Edita enviando una respuesta al usuario del PQRS.
     * @param string $respuesta Respuesta del PQRS.
     * @return void Redirige a la página de PQRS con un mensaje de éxito o error.
     */
    public function EditRespondToPQRController($idPQRS, $respuesta) {
        if (session_status() == PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['usuario_id'])) {
            $_SESSION['Mensaje'] = "Por seguridad, tu sesión ha expirado. Intenta nuevamente.";
            $_SESSION['MensajeTipo'] = "error";
            header("Location: Inicio");
            exit();
        }

        $respuesta = trim($respuesta);
        $idPQRS = trim($idPQRS);

        if (empty($respuesta)) {
            die("Respuesta no válida");
        }

        $pqrsModel = new PQRSModel();
        $pqrsModel->EditResponseForPQRS($idPQRS, $respuesta);
        $_SESSION['Mensaje'] = "¡La respuesta ha sido enviada correctamente!";
        $_SESSION['MensajeTipo'] = "success";
        header("Location: PQRS");
        exit();
    }
}


