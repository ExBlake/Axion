<?php
require_once(__DIR__ . '/../Modal/PlanesModal.php');

class PlanesReportController {

    public function RegisterReportingController() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['Mensaje'] = "Método de solicitud no permitido.";
            $_SESSION['MensajeTipo'] = "error";
            header("Location: Inicio");
            exit;
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['Mensaje'] = "Por seguridad, tu sesión ha expirado. Intenta nuevamente.";
            $_SESSION['MensajeTipo'] = "error";
            header("Location: Inicio");
            exit;
        }
        $Nombre    = isset($_POST['NOMBRE'])    ? trim($_POST['NOMBRE'])    : '';
        $Empresa = isset($_POST['EMPRESA']) ? trim($_POST['EMPRESA']) : '';
        $URL     = isset($_POST['URL'])     ? trim($_POST['URL'])     : '';
        $Plan    = isset($_POST['PLAN'])    ? trim($_POST['PLAN'])    : '';

        $required = compact('Empresa', 'URL', 'Plan', 'Nombre');
        $errors = [];
        foreach ($required as $field => $value) {
            if ($value === '') {
                $errors[] = "El campo {$field} es obligatorio.";
            }
        }

        if (!empty($errors)) {
            $_SESSION['Mensaje'] = implode("<br>", $errors);
            $_SESSION['MensajeTipo'] = "error";
            header("Location: Reportes");
            exit;
        }

        $model = new PlanReportModel();
        $ok = $model->RegisterReportingModel($Nombre, $Empresa, $URL, $Plan);

        if ($ok === true) {
            $_SESSION['Mensaje'] = "¡El plan fue registrado correctamente!";
            $_SESSION['MensajeTipo'] = "success";
        } else {
            $_SESSION['Mensaje'] = "Ocurrió un error al registrar el plan. Por favor, verifica los datos.";
            $_SESSION['MensajeTipo'] = "error";
        }

        header("Location: Reportes");
        exit;
    }


    public function GetAllPlanesController() {
        $Planes = new PlanReportModel();
        return $Planes->GetAllPlanesModel();
    }

    public function GetAllReportingController() {
        $model = new PlanReportModel();
        return $resultado = $model->GetAllReportingModel();
    }

    public function EditReportController() {
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
            $id = trim($_POST['ID_INFORME'] ?? '');
            $nombres = trim($_POST['NOMBRE']);
            $empresa = trim($_POST['EMPRESA']);
            $url = trim($_POST['URL']);
            $plan = trim($_POST['PLAN']);


            // 4. Actualizar la empresa en la base de datos
            try {
                $reportModel = new PlanReportModel();
                $reportModel->UpdateReportById($id, $nombres, $empresa, $url, $plan);

                $_SESSION['Mensaje'] = "¡El reporte ha sido actualizada correctamente!";
                $_SESSION['MensajeTipo'] = "success";
            } catch (Exception $e) {
                $_SESSION['Mensaje'] = "Error al actualizar el reporte: " . $e->getMessage();
                $_SESSION['MensajeTipo'] = "error";
            }

            // 6. Regenerar token CSRF
            unset($_SESSION['csrf_token']);
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

            // 7. Redirigir a la vista de empresas
            header("Location: Reportes");
            exit();
        }
    }

}
