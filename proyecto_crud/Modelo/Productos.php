<?php
// Modelo/Productos.php
require_once 'conexion.php';

class Producto {
    private $db;
    
    public function __construct() {
        $this->db = new DB();
    }
    
    public function guardar($codigo, $producto, $precio, $cantidad) {
        $sql = "INSERT INTO productos (codigo, producto, precio, cantidad) VALUES (?, ?, ?, ?)";
        return $this->db->insertSeguro($sql, [$codigo, $producto, $precio, $cantidad]);
    }
    
    public function editar($id, $codigo, $producto, $precio, $cantidad) {
        $sql = "UPDATE productos SET codigo = ?, producto = ?, precio = ?, cantidad = ? WHERE id = ?";
        return $this->db->updateSeguro($sql, [$codigo, $producto, $precio, $cantidad, $id]);
    }
    
    public function buscar($termino = '') {
        if (empty($termino)) {
            $sql = "SELECT * FROM productos ORDER BY id DESC";
            return $this->db->query($sql);
        } else {
            $sql = "SELECT * FROM productos WHERE codigo LIKE ? OR producto LIKE ? ORDER BY id DESC";
            return $this->db->query($sql, ["%$termino%", "%$termino%"]);
        }
    }
}
?>