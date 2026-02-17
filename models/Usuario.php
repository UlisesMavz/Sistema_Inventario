<?php
/**
 * Clase Usuario
 * Representa un usuario del sistema
 */
class Usuario {
    // Propiedades del usuario
    public $id;
    public $username;
    public $password;
    public $nombre_completo;
    public $fecha_creacion;
    
    /**
     * Constructor
     * @param string $username Nombre de usuario
     * @param string $password Contraseña (sin hashear)
     * @param string $nombre_completo Nombre completo del usuario
     * @param int $id ID de la base de datos (opcional)
     */
    public function __construct($username = null, $password = null, $nombre_completo = null, $id = null) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->nombre_completo = $nombre_completo;
    }
    
    /**
     * Hashea la contraseña usando bcrypt
     * @param string $password Contraseña en texto plano
     * @return string Contraseña hasheada
     */
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }
    
    /**
     * Verifica si una contraseña coincide con el hash
     * @param string $password Contraseña en texto plano
     * @param string $hash Hash almacenado
     * @return bool True si la contraseña es correcta
     */
    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
    
    /**
     * Convierte el objeto Usuario a un array asociativo
     * @param bool $includePassword Si se debe incluir la contraseña (por defecto false)
     * @return array Array con los datos del usuario
     */
    public function toArray($includePassword = false) {
        $data = [
            'id' => $this->id,
            'username' => $this->username,
            'nombre_completo' => $this->nombre_completo,
            'fecha_creacion' => $this->fecha_creacion
        ];
        
        if ($includePassword) {
            $data['password'] = $this->password;
        }
        
        return $data;
    }
    
    /**
     * Crea un objeto Usuario desde un array asociativo
     * @param array $data Array con los datos del usuario
     * @return Usuario Objeto Usuario creado
     */
    public static function fromArray($data) {
        $usuario = new Usuario(
            $data['username'] ?? null,
            $data['password'] ?? null,
            $data['nombre_completo'] ?? null,
            $data['id'] ?? null
        );
        
        $usuario->fecha_creacion = $data['fecha_creacion'] ?? null;
        
        return $usuario;
    }
    
    /**
     * Valida que los datos del usuario sean correctos
     * @return array Array con 'valido' (bool) y 'errores' (array)
     */
    public function validar() {
        $errores = [];
        
        // Validar username
        if (empty($this->username) || trim($this->username) === '') {
            $errores[] = "El nombre de usuario no puede estar vacío";
        }
        
        // Validar password
        if (empty($this->password) || trim($this->password) === '') {
            $errores[] = "La contraseña no puede estar vacía";
        }
        
        // Validar nombre completo
        if (empty($this->nombre_completo) || trim($this->nombre_completo) === '') {
            $errores[] = "El nombre completo no puede estar vacío";
        }
        
        return [
            'valido' => empty($errores),
            'errores' => $errores
        ];
    }
}
?>
