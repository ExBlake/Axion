<?php
// Inicia o reanuda la sesión actual para poder acceder y manipular variables de sesión
session_start();

// Elimina todas las variables de sesión estableciendo $_SESSION como un arreglo vacío.
// Esto borra todos los datos almacenados durante la sesión actual.
$_SESSION = array();

// Si la configuración de PHP utiliza cookies para manejar sesiones,
// se procede a eliminar la cookie asociada a la sesión.
if (ini_get("session.use_cookies")) {
    // Obtiene los parámetros actuales de la cookie de sesión
    $params = session_get_cookie_params();

    // Se envía una nueva cookie con el mismo nombre que la de sesión,
    // pero con una fecha de expiración en el pasado, lo que provoca su eliminación en el navegador.
    setcookie(
        session_name(),         // Nombre de la cookie de sesión (por defecto, PHPSESSID)
        '',                     // Valor vacío
        time() - 42000,         // Fecha de expiración en el pasado (hace 42000 segundos)
        $params["path"],        // Ruta de la cookie
        $params["domain"],      // Dominio de la cookie
        $params["secure"],      // Solo se transmite por HTTPS si estaba configurado así
        $params["httponly"]     // Accesible solo desde HTTP (no desde JavaScript)
    );
}

// Destruye por completo la sesión en el servidor (el archivo temporal que contiene la sesión)
session_destroy();

// Redirige al usuario a la página de inicio de sesión o pública.
// Asegúrate de que esta ruta sea correcta (por ejemplo, "Inicio.php" si es un archivo PHP).
header("Location: Inicio");
exit; // Finaliza el script inmediatamente para evitar que se ejecute cualquier código adicional
?>
