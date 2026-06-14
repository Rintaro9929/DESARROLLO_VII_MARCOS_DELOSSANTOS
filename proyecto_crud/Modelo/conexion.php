<?php
// Modelo/conexion.php
class DB {
    private $host = 'localhost';
    private $port = '3307';        // ← Puerto correcto (3307)
    private $db = 'productosdb';
    private $user = 'root';
    private $pass = '';
    private $pdo;
    
    public function __construct() {
        try {
            // Usar el puerto 3307
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db};charset=utf8mb4";
            
            $this->pdo = new PDO($dsn, $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Enviar error como JSON para que Fetch lo pueda procesar
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Error BD: ' . $e->getMessage()]);
            exit;
        }
    }
    
    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    public function insertSeguro($sql, $params) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $this->pdo->lastInsertId();
    }
    
    public function updateSeguro($sql, $params) {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
}
?>