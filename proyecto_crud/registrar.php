<?php
// registrar.php
header('Content-Type: application/json');

error_reporting(0);
ini_set('display_errors', 0);
ob_clean();

require_once __DIR__ . '/Modelo/Productos.php';

$response = [
    'success' => false,
    'message' => '',
    'data' => [],
    'accion' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    
    try {
        $producto = new Producto();
        
        switch ($accion) {
            case 'Guardar':
                $codigo = trim($_POST['codigo'] ?? '');
                $nombre = trim($_POST['producto'] ?? '');
                $precio = floatval($_POST['precio'] ?? 0);
                $cantidad = intval($_POST['cantidad'] ?? 0);
                
                if (empty($codigo) || empty($nombre) || $precio <= 0 || $cantidad < 1) {
                    $response['message'] = 'Todos los campos son obligatorios';
                } else {
                    $producto->guardar($codigo, $nombre, $precio, $cantidad);
                    $response['success'] = true;
                    $response['message'] = 'Producto guardado correctamente';
                    $response['accion'] = 'Guardar';
                }
                break;
                
            case 'Modificar':
                $id = intval($_POST['id'] ?? 0);
                $codigo = trim($_POST['codigo'] ?? '');
                $nombre = trim($_POST['producto'] ?? '');
                $precio = floatval($_POST['precio'] ?? 0);
                $cantidad = intval($_POST['cantidad'] ?? 0);
                
                if ($id <= 0 || empty($codigo) || empty($nombre) || $precio <= 0) {
                    $response['message'] = 'Datos inválidos para modificar';
                } else {
                    $producto->editar($id, $codigo, $nombre, $precio, $cantidad);
                    $response['success'] = true;
                    $response['message'] = 'Producto modificado correctamente';
                    $response['accion'] = 'Modificar';
                }
                break;
                
            case 'Buscar':
                $termino = $_POST['termino'] ?? '';
                $response['data'] = $producto->buscar($termino);
                $response['success'] = true;
                $response['message'] = 'Búsqueda realizada';
                $response['accion'] = 'Buscar';
                break;
        }
    } catch (Exception $e) {
        $response['message'] = 'Error: ' . $e->getMessage();
    }
}

ob_clean();
echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit;
?>