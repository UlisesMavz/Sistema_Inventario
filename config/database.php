<?php
/**
 * Clase Database
 * Maneja la conexión a la base de datos MySQL usando PDO
 * Implementa el patrón Singleton para una única instancia de conexión
 */
class Database {
    // Configuración de la base de datos
    private $host = "localhost";
    private $db_name = "inventario_db";
    private $username = "root";
    private $password = "";
    private $charset = "utf8mb4";
    
    // Instancia de conexión PDO
    private $conn = null;
    
    /**
     * Obtiene la conexión a la base de datos
     * @return PDO|null Retorna la conexión PDO o null en caso de error
     */
    public function getConnection() {
        // Si ya existe una conexión, retornarla
        if ($this->conn !== null) {
            return $this->conn;
        }
        
        try {
            // Crear DSN (Data Source Name)
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=" . $this->charset;
            
            // Opciones de PDO
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lanzar excepciones en errores
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch asociativo por defecto
                PDO::ATTR_EMULATE_PREPARES => false, // Usar prepared statements reales
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4" // Configurar charset
            ];
            
            // Crear conexión PDO
            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
            
        } catch(PDOException $e) {
            // Registrar error (en producción, usar un sistema de logs)
            error_log("Error de conexión a la base de datos: " . $e->getMessage());
            return null;
        }
        
        return $this->conn;
    }
    
    /**
     * Cierra la conexión a la base de datos
     */
    public function closeConnection() {
        $this->conn = null;
    }
    
    /**
     * Inicia una transacción
     * @return bool True si la transacción se inició correctamente
     */
    public function beginTransaction() {
        if ($this->conn !== null) {
            return $this->conn->beginTransaction();
        }
        return false;
    }
    
    /**
     * Confirma una transacción
     * @return bool True si la transacción se confirmó correctamente
     */
    public function commit() {
        if ($this->conn !== null) {
            return $this->conn->commit();
        }
        return false;
    }
    
    /**
     * Revierte una transacción
     * @return bool True si la transacción se revirtió correctamente
     */
    public function rollback() {
        if ($this->conn !== null) {
            return $this->conn->rollBack();
        }
        return false;
    }
}
?>
