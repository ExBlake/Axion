<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro</title>
  <link rel="icon" type="image/x-icon" href="Icono">
  <link rel="stylesheet" href="Estilos_Inicio_Sesion">
  <link rel="stylesheet" href="Estilos_Registros">
</head>
<body>
  <div class="grid">
    <div class="flex-col">
      <div class="header">
        <a href="index.html" class="logo">
          <div class="logo-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M3 8h18"></path>
              <path d="M10 2v6"></path>
              <path d="M14 8v14"></path>
              <path d="M3 12h4"></path>
              <path d="M3 16h4"></path>
              <path d="M3 20h7"></path>
            </svg>
          </div>
          Acme Inc.
        </a>
      </div>
      <div class="form-container">
        <div class="form-wrapper register-form-wrapper">
          <form class="login-form register-form">
            <div class="form-header">
              <h1>Crear una cuenta</h1>
              <p>Complete el formulario para registrarse</p>
            </div>
            <div class="form-fields">
              <!-- Foto de perfil -->
              <div class="profile-photo-container">
                <div class="profile-photo" id="profile-preview">
                  <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                  </svg>
                </div>
                <div class="profile-upload">
                  <label for="profile-photo" class="btn btn-outline btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7"></path>
                      <path d="m18 2 4 4-10 10H8v-4L18 2z"></path>
                    </svg>
                    Subir foto
                  </label>
                  <input type="file" id="profile-photo" accept="image/*" class="hidden">
                </div>
              </div>

              <!-- Datos personales -->
              <div class="form-row">
                <div class="form-group">
                  <label for="nombre">Nombre</label>
                  <input id="nombre" type="text" placeholder="Juan" required>
                </div>
                <div class="form-group">
                  <label for="apellido">Apellido</label>
                  <input id="apellido" type="text" placeholder="Pérez" required>
                </div>
              </div>

              <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input id="email" type="email" placeholder="juan.perez@ejemplo.com" required>
              </div>

              <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input id="telefono" type="tel" placeholder="+34 612 345 678" required>
              </div>

              <div class="form-group">
                <label for="identificacion">Identificación</label>
                <input id="identificacion" type="text" placeholder="DNI/NIE/Pasaporte" required>
              </div>

              <div class="form-group">
                <label for="password">Contraseña</label>
                <input id="password" type="password" required>
                <div class="password-strength">
                  <div class="strength-meter">
                    <div class="strength-segment" id="strength-1"></div>
                    <div class="strength-segment" id="strength-2"></div>
                    <div class="strength-segment" id="strength-3"></div>
                    <div class="strength-segment" id="strength-4"></div>
                  </div>
                  <span class="strength-text" id="password-strength-text">Fuerza de la contraseña</span>
                </div>
              </div>

              <div class="form-group">
                <label for="confirm-password">Confirmar contraseña</label>
                <input id="confirm-password" type="password" required>
              </div>

              <div class="form-group checkbox-group">
                <input type="checkbox" id="terms" required>
                <label for="terms" class="checkbox-label">
                  Acepto los <a href="#" class="text-link">términos y condiciones</a> y la <a href="#" class="text-link">política de privacidad</a>
                </label>
              </div>

              <button type="submit" class="btn btn-primary">Registrarse</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="image-container">
      <img src="PImageRecurso/HAWKS CAPITAL COMPLETO.png" alt="Image">
    </div>
  </div>

  <script src="Funcion_Registro"></script>
</body>
</html>