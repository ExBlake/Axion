<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="icon" type="image/x-icon" href="Icono">
    <link rel="stylesheet" href="Estilos_Inicio_Sesion">
</head>

<body>
  <?php include 'Controller/Token.php'; 
        /****************** MESSAGES ***********************/
        include_once(__DIR__ . '/View/Layout/FlashMessage.php');
        /************************************************/
  ?>
    <div class="grid">
        <div class="flex-col">
            <div class="header">
                <a href="#" class="logo">
                    <div class="logo-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 8h18"></path>
                            <path d="M10 2v6"></path>
                            <path d="M14 8v14"></path>
                            <path d="M3 12h4"></path>
                            <path d="M3 16h4"></path>
                            <path d="M3 20h7"></path>
                        </svg>
                    </div>
                    Hawks Capital
                </a>
            </div>
            <div class="form-container">
                <div class="form-wrapper">
                    <form class="login-form" action="XZ" method="POST">
                        <input type="hidden" name="csrf_token" id="csrf_token_input"
                            value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                        <div class="form-header">
                            <h1>Inicia Sesión</h1>
                            <p>Ingresa tu correo y contraseña</p>
                        </div>
                        <div class="form-fields">
                            <div class="form-group">
                                <label for="email">Correo:</label>
                                <input id="email" type="email" name="EMAIL" placeholder="m@example.com" required>
                            </div>
                            <div class="form-group">
                                <div class="password-header">
                                    <label for="password">Contraseña</label>
                                    <!-- <a href="#" class="forgot-password">Forgot your password?</a> -->
                                </div>
                                <input id="password" name="CONTRASENA" type="password" placeholder="**********" required>
                            </div>
                            <input type="hidden" name="accionIniciarSesion" value="Iniciar_Sesion">
                            <input class="btn btn-primary" type="submit" value="Inicia Sesión">
                            <!-- <div class="divider">
                                <span>Or continue with</span>
                            </div>
                            <button type="button" class="btn btn-outline">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                                    <path
                                        d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"
                                        fill="currentColor" />
                                </svg>
                                Login with GitHub
                            </button> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="image-container">
            <img src="PImageRecurso/HAWKS CAPITAL.jpg" alt="Image">
        </div>
    </div>
    <script src="Funcion_Sincronizacion"></script>
</body>

</html>