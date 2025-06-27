document.addEventListener('DOMContentLoaded', function() {
    // Manejo de la foto de perfil
    const profileInput = document.getElementById('profile-photo');
    const profilePreview = document.getElementById('profile-preview');
    
    profileInput.addEventListener('change', function(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
          // Limpiar el contenido actual
          profilePreview.innerHTML = '';
          
          // Crear y añadir la imagen
          const img = document.createElement('img');
          img.src = e.target.result;
          img.alt = 'Foto de perfil';
          profilePreview.appendChild(img);
        };
        
        reader.readAsDataURL(file);
      }
    });
    
    // Validación de contraseña
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm-password');
    const strengthText = document.getElementById('password-strength-text');
    const strengthSegments = [
      document.getElementById('strength-1'),
      document.getElementById('strength-2'),
      document.getElementById('strength-3'),
      document.getElementById('strength-4')
    ];
    
    passwordInput.addEventListener('input', function() {
      const password = passwordInput.value;
      const strength = checkPasswordStrength(password);
      
      // Actualizar el medidor de fuerza
      updateStrengthMeter(strength);
    });
    
    // Validación del formulario
    const form = document.querySelector('.register-form');
    
    form.addEventListener('submit', function(event) {
      event.preventDefault();
      
      const password = passwordInput.value;
      const confirmPassword = confirmPasswordInput.value;
      
      // Verificar que las contraseñas coincidan
      if (password !== confirmPassword) {
        alert('Las contraseñas no coinciden');
        return;
      }
      
      // Verificar la fuerza de la contraseña
      const strength = checkPasswordStrength(password);
      if (strength < 2) {
        alert('Por favor, utilice una contraseña más segura');
        return;
      }
      
      // Recopilar datos del formulario
      const formData = {
        nombre: document.getElementById('nombre').value,
        apellido: document.getElementById('apellido').value,
        email: document.getElementById('email').value,
        telefono: document.getElementById('telefono').value,
        identificacion: document.getElementById('identificacion').value,
        // La foto se manejaría con FormData en una implementación real
      };
      
      console.log('Datos del formulario:', formData);
      alert('¡Registro exitoso! En una implementación real, estos datos se enviarían a un servidor.');
    });
    
    // Función para verificar la fuerza de la contraseña
    function checkPasswordStrength(password) {
      let strength = 0;
      
      // Longitud mínima
      if (password.length >= 8) strength += 1;
      
      // Contiene números
      if (/\d/.test(password)) strength += 1;
      
      // Contiene letras minúsculas y mayúsculas
      if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 1;
      
      // Contiene caracteres especiales
      if (/[^a-zA-Z0-9]/.test(password)) strength += 1;
      
      return strength;
    }
    
    // Actualizar el medidor de fuerza visualmente
    function updateStrengthMeter(strength) {
      // Resetear clases
      strengthSegments.forEach(segment => {
        segment.className = 'strength-segment';
      });
      
      // Actualizar texto
      if (strength === 0) {
        strengthText.textContent = 'Contraseña muy débil';
      } else if (strength === 1) {
        strengthText.textContent = 'Contraseña débil';
        strengthSegments[0].classList.add('weak');
      } else if (strength === 2) {
        strengthText.textContent = 'Contraseña media';
        strengthSegments[0].classList.add('medium');
        strengthSegments[1].classList.add('medium');
      } else if (strength === 3) {
        strengthText.textContent = 'Contraseña fuerte';
        strengthSegments[0].classList.add('strong');
        strengthSegments[1].classList.add('strong');
        strengthSegments[2].classList.add('strong');
      } else {
        strengthText.textContent = 'Contraseña muy fuerte';
        strengthSegments.forEach(segment => {
          segment.classList.add('strong');
        });
      }
    }
  });