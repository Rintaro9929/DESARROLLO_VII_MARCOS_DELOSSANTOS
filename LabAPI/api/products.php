<?php

require_once __DIR__ . '/../config/config.php';

class Products
{
    private $conn;

    public function __construct()
    {
        $this->conn = new PDO(
            "mysql:host=" . DB_HOST .
            ";port=" . DB_PORT .
            ";dbname=" . DB_NAME .
            ";charset=utf8mb4",
            DB_USER,
            DB_PASS
        );

        $this->conn->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );
    }

    public function get()
    {
        $stmt = $this->conn->query(
            "SELECT * FROM productos"
        );

        echo json_encode(
            $stmt->fetchAll(PDO::FETCH_ASSOC)
        );
    }

    public function post($data)
    {
        $sql = "INSERT INTO productos
                (codigo, producto, precio, cantidad)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            $data['codigo'],
            $data['producto'],
            $data['precio'],
            $data['cantidad']
        ]);

        http_response_code(201);

        echo json_encode([
            "mensaje" => "Producto agregado"
        ]);
    }

    public function put($data)
    {
        $sql = "UPDATE productos
                SET codigo=?,
                    producto=?,
                    precio=?,
                    cantidad=?
                WHERE id=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            $data['codigo'],
            $data['producto'],
            $data['precio'],
            $data['cantidad'],
            $data['id']
        ]);

        echo json_encode([
            "mensaje" => "Producto actualizado"
        ]);
    }

    public function delete($data)
    {
        $sql = "DELETE FROM productos
                WHERE id=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            $data['id']
        ]);

        echo json_encode([
            "mensaje" => "Producto eliminado"
        ]);
    }
}