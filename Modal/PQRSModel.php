<?php
require_once(__DIR__ . '/../DataBase/DB.php');

/**
 * Modelo para gestionar solicitudes PQRS (Peticiones, Quejas, Reclamos y Sugerencias).
 * Incluye registro de PQRS, consulta general, estadísticas y archivos adjuntos.
 *
 * Requiere una instancia de conexión a base de datos (Database).
 */

class PQRSModel {
    private $db;

    /**
     * Constructor que inicializa la conexión a la base de datos.
     */

    public function __construct() {
        $this->db = new Database();
    }
    /**
     * Registra una nueva solicitud PQRS en la base de datos.
     * Si hay archivos adjuntos, también los almacena en el sistema de archivos y en la base de datos.
     *
     * @param string $Tipo Tipo de solicitud (petición, queja, etc.).
     * @param string $Asunto Asunto de la solicitud.
     * @param string $Descripcion Descripción detallada de la solicitud.
     * @return bool|string `true` si fue exitoso, o un mensaje de error en caso contrario.
     */
    public function RegisterPQRSModel($Tipo, $Asunto, $Descripcion) {
        $conn = $this->db->getConnection();
        if (!$conn) {
            return "Error de conexión a la base de datos.";
        }

        // Validar sesión y usuario
        if (!isset($_SESSION['usuario_id'])) {
            return "Error: Usuario no autenticado.";
        }

        $Id_PQRS = bin2hex(random_bytes(16));
        $Id_Usuario = $_SESSION['usuario_id'];
        $Estado = "pendiente";
        
        // Si ya tienes datos con entidades HTML que necesitas decodificar
        $Asunto = html_entity_decode($Asunto, ENT_QUOTES, 'UTF-8');
        $Descripcion = html_entity_decode($Descripcion, ENT_QUOTES, 'UTF-8');

        // Insertar en tabla PQRS
        $stmt = $conn->prepare("INSERT INTO PQRS (Id_PQRS, Id_Usuario, Tipo, Asunto, Descripcion, Estado) VALUES (?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            error_log("Error al preparar consulta PQRS: " . $conn->error);
            return "Error al preparar la consulta PQRS.";
        }

        $stmt->bind_param("ssssss", $Id_PQRS, $Id_Usuario, $Tipo, $Asunto, $Descripcion, $Estado);
        if (!$stmt->execute()) {
            error_log("Error al insertar PQRS: " . $stmt->error);
            return "Error al insertar PQRS: " . $stmt->error;
        }

        // Manejo de archivos adjuntos
        if (!empty($_FILES['ADJUNTOS']['name'][0])) {
            $ruta_base = realpath(__DIR__ . '/../FilesPQRs') . '/';

            // Verificar si la ruta existe y tiene permisos
            if (!is_dir($ruta_base)) {
                if (!mkdir($ruta_base, 0777, true)) {
                    error_log("Error al crear directorio: $ruta_base");
                    return "Error: No se pudo crear el directorio de archivos.";
                }
            }

            if (!is_writable($ruta_base)) {
                error_log("Directorio no escribible: $ruta_base");
                return "Error: Directorio de archivos no escribible.";
            }

            foreach ($_FILES['ADJUNTOS']['name'] as $key => $nombre_original) {
                $tmp = $_FILES['ADJUNTOS']['tmp_name'][$key];
                $extension = strtolower(pathinfo($nombre_original, PATHINFO_EXTENSION));
                $tipo_archivo = mime_content_type($tmp);

                // Validar tipos permitidos
                $ext_permitidas = ['jpg', 'jpeg', 'png', 'pdf', 'docx', 'xlsx', 'txt'];
                if (!in_array($extension, $ext_permitidas)) {
                    error_log("Extensión no permitida: $extension en $nombre_original");
                    continue;
                }

                $Id_Archivo = bin2hex(random_bytes(16));
                $nombre_unico = $Id_Archivo . '.' . $extension;
                $ruta_destino = $ruta_base . $nombre_unico;

                // Mover archivo al destino
                if (!move_uploaded_file($tmp, $ruta_destino)) {
                    error_log("Error al mover archivo: $nombre_original desde $tmp a $ruta_destino");
                    continue;
                }

                // Insertar metadatos del archivo en base de datos
                $stmt_archivo = $conn->prepare("INSERT INTO PQRS_Archivos (Id_Archivo, Id_PQRS, NombreArchivo, RutaArchivo, TipoArchivo) VALUES (?, ?, ?, ?, ?)");
                if (!$stmt_archivo) {
                    error_log("Error al preparar inserción archivo: " . $conn->error);
                    continue;
                }

                $stmt_archivo->bind_param("sssss", $Id_Archivo, $Id_PQRS, $nombre_original, $ruta_destino, $tipo_archivo);
                if (!$stmt_archivo->execute()) {
                    error_log("Error al guardar metadatos archivo: " . $stmt_archivo->error);
                    continue;
                }
            }
        }

        return true;
    }

    /**
     * Recupera todas las solicitudes PQRS visibles para el usuario actual.
     * - Si es administrador, obtiene todas.
     * - Si es usuario normal, obtiene solo las propias.
     *
     * @return array|string Lista de PQRS como array asociativo o mensaje de error.
     */
    public function GetAllPQRSModel() {
        $conn = $this->db->getConnection();
        if (!$conn) {
            return "Error de conexión a la base de datos.";
        }

        // Validar sesión
        if (!isset($_SESSION['usuario_id'])) {
            return "Error: Usuario no autenticado.";
        }

        $usuarioId = $_SESSION['usuario_id'];

        // Obtener el rol del usuario
        $stmt = $conn->prepare("SELECT Rol FROM Usuarios WHERE Id_Usuario = ?");
        $stmt->bind_param("s", $usuarioId);
        $stmt->execute();
        $result = $stmt->get_result();
        

        if (!$result || $result->num_rows === 0) {
            return "Error: Usuario no encontrado.";
        }

        $row = $result->fetch_assoc();
        $rol = $row['Rol'];
        //Guardamos el rol en la sesión
        $_SESSION['Rol'] = $rol;

        // Consulta según el rol
        if ($rol === 'Administrador') {
            $query = "
                SELECT 
                    PQRS.Id_PQRS,
                    PQRS.Tipo,
                    PQRS.Asunto,
                    PQRS.Descripcion,
                    PQRS.Respuesta,
                    PQRS.Estado,
                    PQRS.Fecha_Creacion,
                    PQRS.Fecha_Actualizacion,
                    Usuarios.Id_Usuario,
                    Usuarios.Nombre,
                    Usuarios.Apellidos,
                    Usuarios.Email,
                    Usuarios.Identificacion,
                    Empresas.Nombre AS NombreEmpresa
                FROM PQRS
                INNER JOIN Usuarios ON PQRS.Id_Usuario = Usuarios.Id_Usuario
                INNER JOIN Empresas ON Usuarios.Id_Empresa = Empresas.Id_Empresa
                ORDER BY PQRS.Fecha_Creacion DESC;

            ";
            $stmt = $conn->prepare($query);
        } else {
            $query = "
                SELECT 
                    PQRS.Id_PQRS,
                    PQRS.Tipo,
                    PQRS.Asunto,
                    PQRS.Descripcion,
                    PQRS.Respuesta,
                    PQRS.Estado,
                    PQRS.Fecha_Creacion,
                    PQRS.Fecha_Actualizacion,
                    Usuarios.Id_Usuario,
                    Usuarios.Nombre,
                    Usuarios.Apellidos,
                    Usuarios.Email,
                    Usuarios.Identificacion,
                    Empresas.Nombre AS NombreEmpresa
                FROM PQRS
                INNER JOIN Usuarios ON PQRS.Id_Usuario = Usuarios.Id_Usuario
                INNER JOIN Empresas ON Usuarios.Id_Empresa = Empresas.Id_Empresa
                WHERE PQRS.Id_Usuario = ?
                ORDER BY PQRS.Fecha_Creacion DESC;

            ";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $usuarioId);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            return "Error en la consulta: " . $conn->error;
        }

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    /**
     * Obtiene estadísticas de PQRS por tipo.
     * - Muestra el total y cuántas están pendientes.
     * - Filtra por tipo de solicitud.
     *
     * @param string $Tipo Tipo de PQRS a consultar (ej. 'queja', 'sugerencia').
     * @return array|string Arreglo con estadísticas por usuario o mensaje de error.
     */
    public function GetAllStadisticsModel($Tipo){
        $conn = $this->db->getConnection();
        if (!$conn) {
            return "Error de conexión a la base de datos.";
        }

        // Validar sesión y usuario
        if (!isset($_SESSION['usuario_id'])) {
            return "Error: Usuario no autenticado.";
        }

        $usuarioId = $_SESSION['usuario_id'];

        // Obtener el rol
        $stmt = $conn->prepare("SELECT Rol FROM Usuarios WHERE Id_Usuario = ?");
        $stmt->bind_param("s", $usuarioId);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result || $result->num_rows === 0) {
            return "Error: Usuario no encontrado.";
        }

        $row = $result->fetch_assoc();
        $rol = $row['Rol'];

        // Consulta adaptada
        if ($rol === 'Administrador') {
            $stmt = $conn->prepare("
                SELECT 
                    U.Id_Usuario, 
                    U.Nombre, 
                    COUNT(P.Id_PQRS) AS Total,
                    COUNT(CASE WHEN P.Estado = 'pendiente' THEN 1 END) AS Pendientes
                FROM PQRS P
                JOIN Usuarios U ON U.Id_Usuario = P.Id_Usuario
                WHERE P.Tipo = ?
                GROUP BY U.Id_Usuario, U.Nombre
            ");
            $stmt->bind_param("s", $Tipo);
        } else {
            $stmt = $conn->prepare("
                SELECT 
                    U.Id_Usuario, 
                    U.Nombre, 
                    COUNT(P.Id_PQRS) AS Total,
                    COUNT(CASE WHEN P.Estado = 'pendiente' THEN 1 END) AS Pendientes
                FROM PQRS P
                JOIN Usuarios U ON U.Id_Usuario = P.Id_Usuario
                WHERE P.Tipo = ? AND U.Id_Usuario = ?
                GROUP BY U.Id_Usuario, U.Nombre
            ");
            $stmt->bind_param("ss", $Tipo, $usuarioId);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            return "Error al ejecutar la consulta.";
        }

        // Devolver resultados
        $estadisticas = [];
        while ($row = $result->fetch_assoc()) {
            $estadisticas[] = $row;
        }

        return $estadisticas;
    }

    
    /**
     * Obtiene una solicitud PQRS específica junto con los datos del usuario que la realizó.
     *
     * @param string $idPQR ID único de la solicitud PQRS.
     * @return array|null Datos combinados de la PQRS y el usuario, o `null` si falla.
     */
    public function GetPQRWithUserById($idPQR) {
        // 1) Obtenemos la conexión mysqli
        $conn = $this->db->getConnection();
        if (!$conn) {
            error_log("GetPQRWithUserById: Conexión a la base de datos fallida.");
            return null;
        }

        // 2) Preparamos la sentencia SQL con placeholder
        $sql = "
            SELECT 
                p.*, 
                u.Nombre, 
                u.Apellidos, 
                u.Email, 
                u.Identificacion, 
                u.Id_Empresa 
            FROM PQRS p 
            JOIN Usuarios u ON p.Id_Usuario = u.Id_Usuario 
            WHERE p.Id_PQRS = ?
        ";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            error_log("GetPQRWithUserById prepare error: " . $conn->error);
            return null;
        }

        // 3) Enlazamos parámetro. Si Id_PQRS es entero en BD, usar 'i'; si es VARCHAR, usar 's'.
        //    Aquí asumimos que es INT. Ajusta a 's' si es cadena.
        if (!$stmt->bind_param('s', $idPQR)) {
            error_log("GetPQRWithUserById bind_param error: " . $stmt->error);
            $stmt->close();
            return null;
        }

        // 4) Ejecutamos
        if (!$stmt->execute()) {
            error_log("GetPQRWithUserById execute error: " . $stmt->error);
            $stmt->close();
            return null;
        }

        // 5) Obtenemos el resultado
        $result = $stmt->get_result();
        if (!$result) {
            error_log("GetPQRWithUserById get_result error: " . $stmt->error);
            $stmt->close();
            return null;
        }

        $row = $result->fetch_assoc();
        $stmt->close();

        // 6) Retornamos el array asociativo o null si no encontró nada
        return $row ?: null;
    }

    /**
     * Obtiene todos los archivos asociados a una PQR.
     * @param int|string $idPQR  El ID de la PQR cuyas entradas de PQRS_Archivos buscamos.
     * @return array             Lista de arrays asociativos (vacío si no hay archivos o falla).
     */
    public function GetArchivosByPQRModel($idPQR) {
        $conn = $this->db->getConnection();
        if (!$conn) {
            error_log("GetArchivosByPQRModel: Conexión a la base de datos fallida.");
            return [];
        }

        $sql = "
            SELECT * FROM PQRS_Archivos WHERE Id_PQRS = ?
        ";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            error_log("GetArchivosByPQRModel prepare error: " . $conn->error);
            return [];
        }

        // Enlazamos parámetro con 'i' si Id_PQRS es entero
        if (!$stmt->bind_param('s', $idPQR)) {
            error_log("GetArchivosByPQRModel bind_param error: " . $stmt->error);
            $stmt->close();
            return [];
        }

        if (!$stmt->execute()) {
            error_log("GetArchivosByPQRModel execute error: " . $stmt->error);
            $stmt->close();
            return [];
        }

        $result = $stmt->get_result();
        if (!$result) {
            error_log("GetArchivosByPQRModel get_result error: " . $stmt->error);
            $stmt->close();
            return [];
        }

        $archivos = [];
        while ($row = $result->fetch_assoc()) {
            $archivos[] = $row;
        }
        $stmt->close();

        return $archivos;
    }
    
     /**
     * Edita la respuesta de una PQRS.
     * 
     * @param string $id ID de la PQRS.
     * @param string $respuesta Nueva respuesta.
     * @param string $nuevoEstado Nuevo estado de la PQRS.
     * Nota: Hay un trigger en la base de datos que actualiza automáticamente
     * la fecha de respuesta al modificar la respuesta.
     */
    public function EditResponseForPQRS($id, $respuesta) {
        $db = new Database();
        $conn = $db->getConnection();

        // Supongamos que al responder un PQRS, se cambia el estado a 'resuelto'
        $nuevoEstado = 'resuelto';

        $stmt = $conn->prepare("UPDATE PQRS SET Respuesta = ?, Estado = ? WHERE Id_PQRS = ?");
        $stmt->bind_param("sss", $respuesta, $nuevoEstado, $id);
        $stmt->execute();

        $stmt->close();
        $conn->close();
    }
}
