<?php
require_once 'conexion.php';

class Producto {
    private $db;

    public function __construct() {
        $this->db = new DB();
    }

    /**
     * Guardar un nuevo producto
     */
    public function guardar($codigo, $producto, $precio, $cantidad) {
        $sql = "INSERT INTO productos (codigo, producto, precio, cantidad) VALUES (?, ?, ?, ?)";
        $params = [$codigo, $producto, $precio, $cantidad];
        return $this->db->insertSeguro($sql, $params);
    }

    /**
     * Editar un producto existente
     */
    public function editar($id, $codigo, $producto, $precio, $cantidad) {
        $sql = "UPDATE productos SET codigo=?, producto=?, precio=?, cantidad=? WHERE id=?";
        $params = [$codigo, $producto, $precio, $cantidad, $id];
        return $this->db->updateSeguro($sql, $params);
    }

    /**
     * Buscar productos por código o nombre
     */
    public function buscar($termino = '') {
        if ($termino === '') {
            $sql = "SELECT * FROM productos ORDER BY id DESC";
            $params = [];
        } else {
            $sql = "SELECT * FROM productos WHERE codigo LIKE ? OR producto LIKE ? ORDER BY id DESC";
            $params = ["%$termino%", "%$termino%"];
        }
        return $this->db->query($sql, $params);
    }
}
?>