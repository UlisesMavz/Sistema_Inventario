/**
 * main.js
 * Funciones auxiliares y utilidades generales
 */

/**
 * Verifica si el usuario está autenticado
 */
function verificarAutenticacion() {
    const loggedIn = localStorage.getItem('logged_in');
    if (!loggedIn || loggedIn !== 'true') {
        window.location.replace('index.html');
        return false;
    }
    return true;
}

// Prevenir acceso vía botón "Atrás" cargando desde la caché
window.addEventListener('pageshow', function(event) {
    if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
        const loggedIn = localStorage.getItem('logged_in');
        if (!loggedIn || loggedIn !== 'true') {
            window.location.replace('index.html');
        }
    }
});

/**
 * Obtiene información del usuario actual
 */
function obtenerUsuario() {
    const usuarioStr = localStorage.getItem('usuario');
    if (usuarioStr) {
        return JSON.parse(usuarioStr);
    }
    return null;
}

/**
 * Muestra una notificación temporal
 */
function mostrarNotificacion(mensaje, tipo = 'success') {
    const notification = document.getElementById('notification');
    notification.textContent = mensaje;
    notification.className = `notification ${tipo}`;
    notification.style.display = 'block';
    
    // Ocultar después de 3 segundos
    setTimeout(() => {
        notification.style.display = 'none';
    }, 3000);
}

/**
 * Formatea un número como precio
 */
function formatearPrecio(precio) {
    return new Intl.NumberFormat('es-MX', {
        style: 'currency',
        currency: 'MXN'
    }).format(precio);
}

/**
 * Formatea una fecha
 */
function formatearFecha(fecha) {
    if (!fecha) return '-';
    const date = new Date(fecha);
    return date.toLocaleDateString('es-MX', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Inicialización del dashboard
document.addEventListener('DOMContentLoaded', function() {
    // Verificar autenticación
    if (!verificarAutenticacion()) {
        return;
    }
    
    // Mostrar nombre de usuario
    const usuario = obtenerUsuario();
    if (usuario) {
        const userNameElement = document.getElementById('userName');
        if (userNameElement) {
            userNameElement.textContent = usuario.nombre_completo || usuario.username;
        }
    }
    
    // Manejar logout
    const logoutBtn = document.getElementById('logoutBtn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', async function() {
            // 1. Destruir sesión en el servidor (CRÍTICO)
            try {
                await fetch('../api/logout.php', {
                    method: 'POST',
                    credentials: 'include'
                });
            } catch (e) {
                // Si falla la red, igual limpiamos localmente
            }
            
            // 2. Limpiar estado local del navegador
            localStorage.removeItem('usuario');
            localStorage.removeItem('logged_in');
            sessionStorage.clear();
            
            // 3. Redirigir reemplazando el historial (sin dejar el dashboard en el historial)
            window.location.replace('index.html');
        });
    }
    
    // Manejar cambio de tipo de inserción
    const insertTipo = document.getElementById('insertTipo');
    const posicionGroup = document.getElementById('posicionGroup');
    
    if (insertTipo && posicionGroup) {
        insertTipo.addEventListener('change', function() {
            if (this.value === 'posicion') {
                posicionGroup.style.display = 'block';
            } else {
                posicionGroup.style.display = 'none';
            }
        });
    }
});
