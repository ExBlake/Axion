<?php
require_once(__DIR__ . '/../DataBase/DB.php');

/**
 * Modelo CompaniesModel
 * 
 * Este modelo gestiona todas las operaciones relacionadas con la tabla `Empresas`.
 * 
 * Nota importante:
 * Este modelo NO maneja sesiones ni mensajes (`$_SESSION['message']`), ya que su única 
 * responsabilidad es comunicarse con la base de datos. Toda la lógica de sesión, redirección 
 * o mensajes al usuario debe estar en el controlador que llame a estos métodos.
 */

class CompaniesModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Registra una nueva empresa en la base de datos.
     * 
     * @param string $NIT         ID o NIT único de la empresa (clave primaria)
     * @param string $Nombre      Nombre de la empresa
     * @param string $Descripcion Breve descripción
     * @param string $Categoria   Categoría de la empresa
     * @param string $Estado      Estado o condición actual (activo/inactivo)
     * @param string $Ubicacion   Dirección o ubicación
     * @param string $Web         URL del sitio web
     * @param string $logoName    Nombre del archivo del logo (guardado en disco)
     * 
     * @return bool|string        Retorna true si se insertó correctamente, o un mensaje de error si falla
     */
    public function RegisterCompaniesModel($NIT,$Nombre,$Descripcion,$Categoria,$Estado,$Ubicacion,$Web,$logoName) {
        $conn = $this->db->getConnection();
        if (!$conn) {
            return "Error de conexión: " . mysqli_connect_error();
        }

        try {
            // 1) Verificar NIT único
            $check = $conn->prepare("SELECT COUNT(*) FROM Empresas WHERE Id_Empresa = ?");
            $check->bind_param("s", $NIT);
            $check->execute();
            $check->bind_result($count);
            $check->fetch();
            $check->close();
            if ($count > 0) {
                return "Error: Ya existe una empresa con ese NIT.";
            }
            $token = bin2hex(random_bytes(16));
            // 2) Insertar
            $sql = "INSERT INTO Empresas
                (Id_Empresa, NIT, Nombre, Descripcion, Categoria, Estado, Ubicacion, Sitio_Web, Logo)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                return "Error en preparación: " . $conn->error;
            }
            $stmt->bind_param(
                "sisssssss",
                $token,
                $NIT,
                $Nombre,
                $Descripcion,
                $Categoria,
                $Estado,
                $Ubicacion,
                $Web,
                $logoName
            );
            if (!$stmt->execute()) {
                return "Error en inserción: " . $stmt->error;
            }
            $stmt->close();
            return true;

        } catch (Exception $e) {
            return "Excepción: " . $e->getMessage();
        } finally {
            $conn->close();
        }
    }
    /**
     * Obtiene todas las empresas registradas.
     * 
     * @return array|string Lista de empresas como array asociativo, o mensaje de error
     */
    public function GetAllCompaniesModel() {
        $conn = $this->db->getConnection();
        if (!$conn) {
            return "Error de conexión: " . mysqli_connect_error();
        }

        $empresas = [];
        $sql = "SELECT * FROM Empresas";

        if ($stmt = $conn->prepare($sql)) {
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $empresas[] = $row;
                }
            } else {
                error_log("Error al ejecutar consulta: " . $stmt->error);
            }
            $stmt->close();
        } else {
            error_log("Error al preparar consulta: " . $conn->error);
        }

        return $empresas;
    }
    /**
     * Obtiene todas las empresas con estadísticas adicionales:
     * - Total de usuarios por empresa
     * - Total de planes contratados por empresa
     * 
     * @return array|string Lista de empresas con estadísticas, o mensaje de error
     */
    public function GetAllCompaniesWithStatsModel() {
        $conn = $this->db->getConnection();
        if (!$conn) {
            return "Error de conexión: " . mysqli_connect_error();
        }

        $empresas = [];

        $sql = "
            SELECT 
                e.Id_Empresa,
                e.Nombre AS NombreEmpresa,
                COUNT(DISTINCT u.Id_Usuario) AS TotalUsuarios,
                COUNT(DISTINCT ep.Id_Planes) AS TotalPlanes
            FROM Empresas e
            LEFT JOIN Usuarios u ON e.Id_Empresa = u.Id_Empresa
            LEFT JOIN Empresas_Planes ep ON e.Id_Empresa = ep.Id_Empresa
            GROUP BY e.Id_Empresa, e.Nombre, e.Fecha_Creacion, e.Fecha_Actualizacion
        ";

        if ($stmt = $conn->prepare($sql)) {
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $empresas[] = $row;
                }
            } else {
                error_log("Error al ejecutar consulta: " . $stmt->error);
            }
            $stmt->close();
        } else {
            error_log("Error al preparar consulta: " . $conn->error);
        }

        return $empresas;
    }

    public function UpdateCompanyByAdmin($id, $nit, $nombres, $categoria, $estado, $descripcion, $ubicacion, $web, $rutaFinal){
        $conn = $this->db->getConnection();
        if (!$conn) {
            throw new Exception("Error de conexión: " . mysqli_connect_error());
        }

        $sql = "UPDATE Empresas SET NIT = ?, Nombre = ?, Descripcion = ?, Categoria = ?, Estado = ?, Ubicacion = ?, Sitio_Web = ?, Logo = ? WHERE Id_Empresa = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssssss", $nit, $nombres, $descripcion, $categoria, $estado, $ubicacion, $web, $rutaFinal, $id);

        $stmt->execute();
        $stmt->close();
        $conn->close();
    }
}
