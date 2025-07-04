<?php
require_once(__DIR__ . '/../DataBase/DB.php');

/**
 * Modelo para la gestión de usuarios en el sistema.
 */

class UsuarioModel{
    private $db;

    /**
     * Constructor: Inicializa la conexión a la base de datos.
     */

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Verifica si un correo electrónico ya está registrado.
     * 
     * @param string $Correo Correo a verificar.
     * @param mysqli $conn Conexión a la base de datos.
     * @return bool Verdadero si ya existe.
     */

    private function checkIfEmailExists($Correo, $conn) {
        $checkEmailSql = "SELECT COUNT(*) FROM Usuarios WHERE Email = ?";
        $checkEmailStmt = $conn->prepare($checkEmailSql);
        $checkEmailStmt->bind_param("s", $Correo);
        $checkEmailStmt->execute();
        $checkEmailStmt->bind_result($count);
        $checkEmailStmt->fetch();
        $checkEmailStmt->close();
        return $count > 0;
    }

    /**
     * Verifica si una cédula ya está registrada.
     * 
     * @param int $Cedula Número de identificación.
     * @param mysqli $conn Conexión a la base de datos.
     * @return bool Verdadero si ya existe.
     */
    private function checkIfCedulaExists($Cedula, $conn) {
        $checkCedulaSql = "SELECT COUNT(*) FROM Usuarios WHERE Identificacion = ?";
        $checkCedulaStmt = $conn->prepare($checkCedulaSql);
        $checkCedulaStmt->bind_param("i", $Cedula);
        $checkCedulaStmt->execute();
        $checkCedulaStmt->bind_result($count);
        $checkCedulaStmt->fetch();
        $checkCedulaStmt->close();
        return $count > 0;
    }

    /**
     * Registra un nuevo usuario en el sistema.
     * 
     * @param int $Empresa ID de la empresa.
     * @param int $Cedula Cédula del usuario.
     * @param string $Nombre Nombres del usuario.
     * @param string $Apellidos Apellidos del usuario.
     * @param string $Correo Correo electrónico.
     * @param string $Contrasena Contraseña en texto plano.
     * @param int $Telefono Telefono del usuario.
     * @param string $Rol Rol asignado.
     * @param array $Fotos Fotos del usuario.
     * @return mixed True en caso de éxito, o mensaje de error.
     */
    public function RegisterUserModel($Empresa, $Cedula, $Nombre, $Apellidos, $Correo, $Contrasena, $Telefono, $Rol, $Fotos) {
        $conn = $this->db->getConnection();
        if (!$conn) {
            throw new Exception("Error de conexión: " . mysqli_connect_error());
        }

        try {
            // Verifica si el correo o la cédula ya existen
            $checkUserSql = "SELECT COUNT(*) FROM Usuarios WHERE Email = ? OR Identificacion = ?";
            $checkUserStmt = $conn->prepare($checkUserSql);
            if (!$checkUserStmt) throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            
            $checkUserStmt->bind_param("si", $Correo, $Cedula);
            $checkUserStmt->execute();
            $checkUserStmt->bind_result($count);
            $checkUserStmt->fetch();
            $checkUserStmt->close();

            if ($count > 0) {
                // Determina cuál es el error
                $emailExists = $this->checkIfEmailExists($Correo, $conn);
                $cedulaExists = $this->checkIfCedulaExists($Cedula, $conn);

                if ($cedulaExists) {
                    return "Error: Una persona ya existe con esa cédula. Por favor, utiliza otra cédula.";
                } elseif ($emailExists) {
                    return "Error: El correo electrónico ya está registrado. Por favor, utiliza otro correo.";
                }
            } else {
                // Validación de las fotos
                if (isset($_FILES['foto']) && is_array($_FILES['foto']['name'])) { // Asegúrate de que sea un array
                    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    $allFilesValid = true;

                    foreach ($_FILES['foto']['name'] as $key => $nombreFoto) {
                        if ($_FILES['foto']['error'][$key] == 0) {
                            $fileType = mime_content_type($_FILES['foto']['tmp_name'][$key]);
                            if (!in_array($fileType, $allowedTypes)) {
                                $allFilesValid = false;
                                break;
                            }
                        }
                    }

                    if ($allFilesValid) {
                        // Procesar las imágenes si son válidas
                        $Fotos = [];
                        foreach ($_FILES['foto']['name'] as $key => $nombreFoto) {
                            if ($_FILES['foto']['error'][$key] == 0) {
                                $uploadDir = __DIR__ . '/../PicturesUsers/';
                                $extension = pathinfo($nombreFoto, PATHINFO_EXTENSION);
                                $newFileName = uniqid('foto_') . '.' . $extension;
                                $targetPath = $uploadDir . $newFileName;

                                if (move_uploaded_file($_FILES['foto']['tmp_name'][$key], $targetPath)) {
                                    $Fotos[] = $newFileName; // Agregar nombre de archivo al array
                                }
                            }
                        }
                        $token = bin2hex(random_bytes(16));

                        // Encriptar la contraseña usando bcrypt
                        $hashedPassword = password_hash($Contrasena, PASSWORD_BCRYPT);

                        // Prepara la consulta de inserción
                        $sql = "INSERT INTO Usuarios (Id_Usuario, Id_Empresa, Identificacion, Nombre, Apellidos, Email, Contrasena, Telefono, Foto, Rol) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        if (!$stmt) return("Error en la preparación de la consulta de inserción: " . $conn->error);

                        // Convierte $Fotos a cadena si es un array
                        $Fotos = is_array($Fotos) ? implode(",", $Fotos) : "";

                        $stmt->bind_param("ssissssiss",  $token, $Empresa, $Cedula, $Nombre, $Apellidos, $Correo, $hashedPassword, $Telefono, $Fotos, $Rol);
                        $result = $stmt->execute();

                        if (!$result) {
                            $_SESSION['Mensaje'] = "Error en la ejecución";
                            $_SESSION['MensajeTipo'] = "error";
                        }

                        $stmt->close();
                        return true; // Registro exitoso
                    } else {
                        $_SESSION['Mensaje'] = "Error: Solo se permiten archivos JPG, JPEG y PNG para las fotos.";
                        $_SESSION['MensajeTipo'] = "error";
                        header("Location: Usuarios"); // Redirigir a la página adecuada
                        exit;
                    }
                } else {
                    $_SESSION['Mensaje'] = "Error: Debes subir al menos una foto válida.";
                    $_SESSION['MensajeTipo'] = "error";
                    header("Location: Usuarios"); // Redirigir a la página adecuada
                    exit;
                }
            }
        } catch (Exception $e) {
            $_SESSION['Mensaje'] = $e->getMessage();
            $_SESSION['MensajeTipo'] = "error";
            header("Location: Usuarios"); // Redirigir a la página adecuada
            exit;
        } finally {
            $conn->close(); // Cerrar la conexión
        }
    }

    /**
     * Inicia sesión para un usuario dado su correo y contraseña.
     * 
     * @param string $Correo Correo electrónico.
     * @param string $Contrasena Contraseña en texto plano.
     * @return mixed Arreglo con los datos del usuario o false.
     */
    public function IniciarSesionModel($Correo, $Contrasena) {
        $conn = $this->db->getConnection();
        
        // Preparamos la consulta para obtener el usuario por correo
        $sql = "SELECT * FROM Usuarios WHERE Email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $Correo);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        // Si el usuario existe
        if ($user) {
            // Compara la contraseña en texto plano con el hash almacenado
            if (password_verify($Contrasena, $user['Contrasena'])) {
                return $user;  // La contraseña es correcta
            } else {
                return false;  // La contraseña es incorrecta
            }
        } else {
            return false;  // No se encontró el usuario
        }
    }

    /**
     * Obtiene todos los usuarios junto con el nombre de su empresa.
     * 
     * @return array Lista de usuarios con empresa.
     */
    public function GetAllUsersWithCompanyModel() {
        $conn = $this->db->getConnection();
        $query = "
            SELECT 
                u.*,
                e.Nombre AS NombreEmpresa
            FROM 
                Usuarios u
            INNER JOIN 
                Empresas e ON u.Id_Empresa = e.Id_Empresa
        ";

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $usuarios = [];
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }

        return $usuarios;
    }

    /**
     * Obtiene los datos de un usuario por su ID.
     * 
     * @param string $usuarioID ID del usuario.
     * @return array|null Datos del usuario.
     */
    public function GetUserByIdModel($usuarioID) {
        $conn = $this->db->getConnection();
        $query = "SELECT * FROM Usuarios WHERE Id_Usuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $usuarioID); 
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    /**
     * Obtiene los planes disponibles para un usuario dependiendo de su empresa.
     * 
     * @param string $usuarioID ID del usuario.
     * @return array Lista de planes.
     */
    public function GetReportsByUser($usuarioID) {
        $conn = $this->db->getConnection();

        // 1. Obtener rol y empresa del usuario
        $queryUser = "SELECT u.Rol, u.Id_Empresa FROM Usuarios u WHERE u.Id_Usuario = ?";
        $stmtUser = $conn->prepare($queryUser);
        $stmtUser->bind_param("s", $usuarioID);
        $stmtUser->execute();
        $resultUser = $stmtUser->get_result();
        $user = $resultUser->fetch_assoc();
        $stmtUser->close();

        $rol = $user['Rol'] ?? '';
        $empresaID = $user['Id_Empresa'] ?? '';

        // 2. Si es Administrador, traer todos los informes
        if ($rol === 'Administrador') {
            $query = "
                SELECT 
                    e.Nombre AS Empresa,
                    e.Id_Empresa,
                    i.Id_Informe,
                    i.Nombre AS Nombre_Informe,
                    i.Url,
                    i.Estado,
                    i.Fecha_Creacion,
                    i.Fecha_Actualizacion
                FROM Informes i
                JOIN Empresas e ON i.Id_Empresa = e.Id_Empresa
                ORDER BY e.Nombre, i.Nombre
            ";
            $stmt = $conn->prepare($query);
        } else {
            // 3. Si no es administrador, solo los de su empresa
            $query = "
                SELECT 
                    e.Nombre AS Empresa,
                    e.Id_Empresa,
                    i.Id_Informe,
                    i.Nombre AS Nombre_Informe,
                    i.Url,
                    i.Estado,
                    i.Fecha_Creacion,
                    i.Fecha_Actualizacion
                FROM Informes i
                JOIN Empresas e ON i.Id_Empresa = e.Id_Empresa
                WHERE i.Id_Empresa = ?
                ORDER BY i.Nombre
            ";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $empresaID);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Obtiene los datos del plan y la URL del informe relacionado.
     * 
     * @param string $idInforme ID del informe.
     * @param int $empresaId ID de la empresa.
     * @return array|null Datos del plan con URL.
     */
    public function GetInformeById($idInforme, $empresaId) {
        $conn = $this->db->getConnection();
        $query = "
            SELECT 
                i.Id_Informe,
                i.Nombre AS Nombre_Informe,
                i.Url,
                p.Nombre AS Nombre_Plan,
                e.Nombre AS Nombre_Empresa
            FROM Informes i
            JOIN Planes p ON p.Id_Planes = i.Id_Planes
            JOIN Empresas e ON e.Id_Empresa = i.Id_Empresa
            WHERE i.Id_Informe = ? AND i.Id_Empresa = ?;
        ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $idInforme, $empresaId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }


    /**
     * Obtiene los datos de un usuario para mostrar en un modal de perfil.
     * 
     * @param string $Id ID del usuario.
     * @return array|null Datos del usuario.
     */
    public function GetUserForProfileModal($Id) {
        $db = new Database();
        $conn = $db->getConnection();

        // Validar que el ID sea seguro (opcional: puedes ajustarlo a tu formato)
        if (!preg_match('/^[a-zA-Z0-9]{1,64}$/', $Id)) {
            throw new Exception("ID de usuario no válido.");
        }

        $stmt = $conn->prepare("SELECT * FROM Usuarios WHERE Id_Usuario = ?");
        $stmt->bind_param("s", $Id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    /**
     * Edita los datos del perfil de un usuario.
     * 
     * @param string $id ID del usuario.
     * @param string $nombre Nombre.
     * @param string $apellidos Apellidos.
     * @param string $email Correo electrónico.
     * @param string $foto Nombre de la imagen.
     */
    public function EditUserForProfile($id, $nombre, $apellidos, $email, $foto, $telefono) {
        $db = new Database();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("UPDATE Usuarios SET Nombre = ?, Apellidos = ?, Email = ?, Telefono = ?, Foto = ? WHERE Id_Usuario = ?");
        $stmt->bind_param("sssiss", $nombre, $apellidos, $email, $telefono, $foto, $id);
        $stmt->execute();

        $stmt->close();
        $conn->close();
    }

    /**
     * Retorna la contraseña encriptada de un usuario específico por su ID.
     * 
     * @param string $userId ID del usuario.
     * @return array|null Arreglo asociativo con la contraseña o null si no se encuentra.
     */
    public function GetUserById($userId) {
        $conn = $this->db->getConnection();
        if (!$conn) {
            throw new Exception("Error de conexión: " . mysqli_connect_error());
        }

        $stmt = $conn->prepare("SELECT Contrasena FROM Usuarios WHERE Id_Usuario = ?");
        $stmt->bind_param("s", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Actualiza la contraseña encriptada de un usuario específico.
     * 
     * @param string $userId ID del usuario.
     * @param string $newPasswordHash Contraseña nueva ya encriptada.
     * @return void
     */
    public function UpdatePassword($userId, $newPasswordHash) {
        $conn = $this->db->getConnection();
        if (!$conn) {
            throw new Exception("Error de conexión: " . mysqli_connect_error());
        }

        $stmt = $conn->prepare("UPDATE Usuarios SET Contrasena = ? WHERE Id_Usuario = ?");
        $stmt->bind_param("ss", $newPasswordHash, $userId);
        $stmt->execute();
    }

    /**
     * Actualiza los datos de un usuario desde el panel de administrador.
     * Incluye actualización de empresa, identificación, nombres, apellidos,
     * email, estado, rol y foto.
     *
     * @param int $id            ID único del usuario a actualizar.
     * @param string $cc         Número de identificación del usuario.
     * @param string $nombres    Nombres del usuario.
     * @param string $apellidos  Apellidos del usuario.
     * @param string $email      Correo electrónico del usuario.
     * @param string $empresa    ID de la empresa asociada.
     * @param string $rol        Rol asignado al usuario (ej. admin, empleado).
     * @param string $estado     Estado del usuario (activo/inactivo).
     * @param string $foto       Nombre del archivo de imagen asociado al perfil.
     *
     * @throws Exception Si hay un error de conexión a la base de datos.
     */
    public function UpdateUserByAdmin($id, $cc, $nombres, $apellidos, $email, $Telefono, $empresa, $rol, $estado, $foto){
        $conn = $this->db->getConnection();
        if (!$conn) {
            throw new Exception("Error de conexión: " . mysqli_connect_error());
        }

        $sql = "UPDATE Usuarios SET Id_Empresa = ?, Identificacion = ?, Nombre = ?, Apellidos = ?, Email = ?, Telefono = ?, Estado = ?, Rol = ?, Foto = ? WHERE Id_Usuario = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sisssissss", $empresa, $cc, $nombres, $apellidos, $email, $Telefono, $estado, $rol, $foto, $id);

        $stmt->execute();
        $stmt->close();
        $conn->close();
    }
}
?>