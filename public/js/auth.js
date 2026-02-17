/**
 * auth.js
 * Maneja la autenticación de usuarios
 */

// Esperar a que el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const errorMessage = document.getElementById('errorMessage');
    const loginBtn = document.getElementById('loginBtn');
    
    // Manejar envío del formulario
    loginForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Obtener valores del formulario
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value;
        
        // Validar campos
        if (!username || !password) {
            mostrarError('Por favor complete todos los campos');
            return;
        }
        
        // Mostrar loader
        mostrarLoader(true);
        
        try {
            // Realizar petición de login
            const response = await fetch('../api/login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    username: username,
                    password: password
                })
            });
            
            const data = await response.json();
            
            if (data.exito) {
                // Login exitoso
                // Guardar información del usuario en localStorage
                localStorage.setItem('usuario', JSON.stringify(data.usuario));
                localStorage.setItem('logged_in', 'true');
                
                // Animación de éxito
                errorMessage.style.display = 'none';
                loginForm.style.opacity = '0.5';
                
                // Redirigir al dashboard
                setTimeout(() => {
                    window.location.href = 'dashboard.html';
                }, 500);
            } else {
                // Login fallido
                mostrarError(data.mensaje || 'Usuario o contraseña incorrectos');
                mostrarLoader(false);
            }
            
        } catch (error) {
            console.error('Error en login:', error);
            mostrarError('Error de conexión. Verifique que XAMPP esté ejecutándose');
            mostrarLoader(false);
        }
    });
    
    /**
     * Muestra un mensaje de error
     */
    function mostrarError(mensaje) {
        errorMessage.textContent = mensaje;
        errorMessage.style.display = 'block';
        
        // Animación de shake
        errorMessage.style.animation = 'shake 0.5s';
        setTimeout(() => {
            errorMessage.style.animation = '';
        }, 500);
    }
    
    /**
     * Muestra/oculta el loader del botón
     */
    function mostrarLoader(mostrar) {
        const btnText = loginBtn.querySelector('.btn-text');
        const btnLoader = loginBtn.querySelector('.btn-loader');
        
        if (mostrar) {
            btnText.style.display = 'none';
            btnLoader.style.display = 'block';
            loginBtn.disabled = true;
        } else {
            btnText.style.display = 'block';
            btnLoader.style.display = 'none';
            loginBtn.disabled = false;
        }
    }
});

// Animación de shake para errores
const style = document.createElement('style');
style.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }
`;
document.head.appendChild(style);
