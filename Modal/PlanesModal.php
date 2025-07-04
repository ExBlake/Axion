<?php
require_once(__DIR__ . '/../DataBase/DB.php');

class PlanReportModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Registra un nuevo informe en la base de datos.
     *
     * @param string $Empresa 
     * @param string $URL 
     * @param string $Plan 
     * @return true|string Retorna true si se insertó correctamente o un mensaje de error.
     */
    public function RegisterReportingModel($Nombre, $Empresa, $URL, $Plan) {
        $conn = $this->db->getConnection();
        if (!$conn) {
            return "Error de conexión a la base de datos.";
        }

        if (!isset($_SESSION['usuario_id'])) {
            return "Error: Usuario no autenticado.";
        }

        $Id_Informe = bin2hex(random_bytes(16));

        $Nombre  = html_entity_decode($Nombre, ENT_QUOTES, 'UTF-8');
        $Empresa = html_entity_decode($Empresa, ENT_QUOTES, 'UTF-8');
        $URL     = html_entity_decode($URL, ENT_QUOTES, 'UTF-8');
        $Plan    = html_entity_decode($Plan, ENT_QUOTES, 'UTF-8');
        $Estado  = "Activo";

        $stmt = $conn->prepare("INSERT INTO Informes (Id_Informe, Id_Planes, Id_Empresa, Nombre, Url, Estado) VALUES (?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            error_log("Error al preparar consulta Informe: " . $conn->error);
            return "Error al preparar la consulta Informe.";
        }

        $stmt->bind_param("ssssss", $Id_Informe, $Plan, $Empresa, $Nombre, $URL, $Estado);
        if (!$stmt->execute()) {
            $_SESSION['Mensaje'] = "Error al insertar Informe: " . $stmt->error;
            $_SESSION['MensajeTipo'] = "error";
        }

        return true;
    }

    /**
     * Obtiene todos los planes registrados en la tabla Planes.
     *
     * @return array|string Arreglo de planes o mensaje de error
     */
    public function GetAllPlanesModel() {
        $conn = $this->db->getConnection();
        if (!$conn) {
            return "Error de conexión: " . mysqli_connect_error();
        }

        $Planes = [];
        $sql = "SELECT * FROM Planes";

        if ($stmt = $conn->prepare($sql)) {
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $Planes[] = $row;
                }
            } else {
                error_log("Error al ejecutar consulta: " . $stmt->error);
                return "Error al ejecutar la consulta.";
            }
            $stmt->close();
        } else {
            error_log("Error al preparar consulta: " . $conn->error);
            return "Error al preparar la consulta.";
        }

        return $Planes;
    }

    public function GetAllReportingModel() {
        // 1. Verificar sesión activa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario_id'])) {
            error_log("Acceso no autorizado: sesión no iniciada.");
            return "Error: Sesión no iniciada.";
        }


        // 2. Conexión a la base de datos
        $conn = $this->db->getConnection();
        if (!$conn || $conn->connect_error) {
            error_log("Conexión fallida: " . $conn->connect_error);
            return "Error de conexión con la base de datos.";
        }

        // 3. Consulta SQL preparada
        $sql = "
            SELECT 
                i.Id_Informe,
                i.Nombre AS Nombre_Informe,
                i.Url,
                i.Estado,
                i.Fecha_Creacion,
                i.Fecha_Actualizacion,
                
                p.Id_Planes,
                p.Nombre AS Nombre_Plan,
                
                e.Id_Empresa,
                e.Nombre AS Nombre_Empresa
            FROM 
                informes i
            INNER JOIN planes p ON i.Id_Planes = p.Id_Planes
            INNER JOIN empresas e ON i.Id_Empresa = e.Id_Empresa
        ";

        $reportes = [];

        if ($stmt = $conn->prepare($sql)) {
            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $reportes[] = $row;
                    }
                } else {
                    return "No se encontraron informes registrados.";
                }

            } else {
                error_log("Error al ejecutar la consulta GetAllReportingModel: " . $stmt->error);
                return "Ocurrió un error al consultar los informes.";
            }

            $stmt->close();

        } else {
            error_log("Error al preparar la consulta GetAllReportingModel: " . $conn->error);
            return "No se pudo preparar la consulta.";
        }

        return $reportes;
    }

    public function UpdateReportById($id, $nombres, $empresa, $url, $plan){
        $conn = $this->db->getConnection();
        if (!$conn) {
            throw new Exception("Error de conexión: " . mysqli_connect_error());
        }

        $sql = "UPDATE Informes SET Id_Planes = ?, Id_Empresa = ?, Nombre = ?, Url = ? WHERE Id_Informe = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $plan, $empresa, $nombres, $url, $id);

        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

}
?>
