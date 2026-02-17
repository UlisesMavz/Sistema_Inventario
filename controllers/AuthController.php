<?php
// Iniciar sesión
session_start();

// Incluir dependencias
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../utils/Validacion.php';

/**
 * Clase AuthController
 * Maneja la autenticación y autorización de usuarios
 */
class AuthController {
    private $db;
    private $conn;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }
    
    /**
     * Autentica un usuario con username y password
     * 
     * @param string $username Nombre de usuario
     * @param string $password Contraseña en texto plano
     * @return array Array con 'exito' (bool), 'mensaje' (string), 'usuario' (array|null)
     */
    public function login($username, $password) {
        // Validar credenciales
        $validacion = Validacion::validarCredenciales($username, $password);
        
        if (!$validacion['valido']) {
            return [
                'exito' => false,
                'mensaje' => implode(', ', $validacion['errores']),
                'usuario' => null
            ];
        }
        
        // Sanitizar username
        $username = Validacion::sanitizarString($username);
        
        try {
            // Buscar usuario en la base de datos
            $query = "SELECT id, username, password, nombre_completo, fecha_creacion 
                      FROM usuarios 
                      WHERE username = :username 
                      LIMIT 1";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            
            // Verificar si el usuario existe
            if ($stmt->rowCount() == 0) {
                return [
                    'exito' => false,
                    'mensaje' => 'Usuario o contraseña incorrectos',
                    'usuario' => null
                ];
            }
            
            // Obtener datos del usuario
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verificar la contraseña
            if (!Usuario::verifyPassword($password, $row['password'])) {
                return [
                    'exito' => false,
                    'mensaje' => 'Usuario o contraseña incorrectos',
                    'usuario' => null
                ];
            }
            
            // Crear objeto usuario
            $usuario = Usuario::fromArray($row);
            
            // Guardar información en la sesión
            $_SESSION['usuario_id'] = $usuario->id;
            $_SESSION['username'] = $usuario->username;
            $_SESSION['nombre_completo'] = $usuario->nombre_completo;
            $_SESSION['logged_in'] = true;
            
            // Registrar login en logs
            $this->registrarLog($usuario->id, 'LOGIN', 'Usuario inició sesión');
            
            return [
                'exito' => true,
                'mensaje' => 'Login exitoso',
                'usuario' => $usuario->toArray()
            ];
            
        } catch (PDOException $e) {
            error_log("Error en login: " . $e->getMessage());
            return [
                'exito' => false,
                'mensaje' => 'Error en el servidor',
                'usuario' => null
            ];
        }
    }
    
    /**
     * Verifica si hay una sesión activa
     * 
     * @return bool True si hay sesión activa
     */
    public function verificarSesion() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
    
    /**
     * Obtiene el ID del usuario actual
     * 
     * @return int|null ID del usuario o null si no hay sesión
     */
    public function obtenerUsuarioId() {
        return $_SESSION['usuario_id'] ?? null;
    }
    
    /**
     * Cierra la sesión del usuario
     * 
     * @return array Array con 'exito' (bool) y 'mensaje' (string)
     */
    public function logout() {
        // Registrar logout en logs
        if ($this->verificarSesion()) {
            $this->registrarLog($_SESSION['usuario_id'], 'LOGOUT', 'Usuario cerró sesión');
        }
        
        // Destruir todas las variables de sesión
        $_SESSION = array();
        
        // Destruir la sesión
        session_destroy();
        
        return [
            'exito' => true,
            'mensaje' => 'Sesión cerrada correctamente'
        ];
    }
    
    /**
     * Registra una acción en la tabla de logs
     * 
     * @param int $usuarioId ID del usuario
     * @param string $accion Tipo de acción
     * @param string $descripcion Descripción de la acción
     */
    private function registrarLog($usuarioId, $accion, $descripcion) {
        try {
            $query = "INSERT INTO logs (usuario_id, accion, descripcion) 
                      VALUES (:usuario_id, :accion, :descripcion)";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':usuario_id', $usuarioId);
            $stmt->bindParam(':accion', $accion);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Error al registrar log: " . $e->getMessage());
        }
    }
}
?>
