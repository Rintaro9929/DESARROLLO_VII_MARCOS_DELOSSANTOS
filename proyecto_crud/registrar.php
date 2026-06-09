<?php
header("Content-Type: application/json");
require_once __DIR__ . '/Modelo/Productos.php';  // ✅ Ruta absoluta

$productoObj = new Producto();
$response = [
    'success' => false, 
    'message' => '', 
    'accion' => '', 
    'errors' => [],
    'data' => []
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    switch ($accion) {
        // ========== GUARDAR PRODUCTO ==========
        case 'Guardar':
            $codigo = trim($_POST['codigo'] ?? '');
            $producto = trim($_POST['producto'] ?? '');
            $precio = $_POST['precio'] ?? '';
            $cantidad = $_POST['cantidad'] ?? '';

            // Validaciones
            if (empty($codigo)) {
                $response['errors']['codigo'] = 'El código es obligatorio';
            }
            if (empty($producto)) {
                $response['errors']['producto'] = 'El nombre del producto es obligatorio';
            }
            if ($precio === '' || $precio <= 0) {
                $response['errors']['precio'] = 'El precio debe ser mayor a 0';
            }
            if ($cantidad === '' || $cantidad < 1) {
                $response['errors']['cantidad'] = 'La cantidad mínima es 1';
            }

            if (empty($response['errors'])) {
                try {
                    $productoObj->guardar($codigo, $producto, $precio, $cantidad);
                    $response['success'] = true;
                    $response['message'] = 'Producto guardado correctamente';
                    $response['accion'] = 'Guardar';
                } catch (Exception $e) {
                    $response['message'] = 'Error al guardar: ' . $e->getMessage();
                }
            } else {
                $response['message'] = 'Por favor corrija los errores del formulario';
            }
            break;

        // ========== MODIFICAR PRODUCTO ==========
        case 'Modificar':
            $id = $_POST['id'] ?? '';
            $codigo = trim($_POST['codigo'] ?? '');
            $producto = trim($_POST['producto'] ?? '');
            $precio = $_POST['precio'] ?? '';
            $cantidad = $_POST['cantidad'] ?? '';

            // Validaciones
            if (empty($id)) {
                $response['errors']['id'] = 'ID de producto no recibido';
            }
            if (empty($codigo)) {
                $response['errors']['codigo'] = 'El código es obligatorio';
            }
            if (empty($producto)) {
                $response['errors']['producto'] = 'El nombre del producto es obligatorio';
            }
            if ($precio === '' || $precio <= 0) {
                $response['errors']['precio'] = 'El precio debe ser mayor a 0';
            }
            if ($cantidad === '' || $cantidad < 0) {
                $response['errors']['cantidad'] = 'La cantidad no puede ser negativa';
            }

            if (empty($response['errors'])) {
                try {
                    $productoObj->editar($id, $codigo, $producto, $precio, $cantidad);
                    $response['success'] = true;
                    $response['message'] = 'Producto modificado correctamente';
                    $response['accion'] = 'Modificar';
                } catch (Exception $e) {
                    $response['message'] = 'Error al modificar: ' . $e->getMessage();
                }
            } else {
                $response['message'] = 'Por favor corrija los errores del formulario';
            }
            break;

        // ========== BUSCAR PRODUCTOS ==========
        case 'Buscar':
            $termino = $_POST['termino'] ?? '';
            try {
                $resultados = $productoObj->buscar($termino);
                $response['success'] = true;
                $response['data'] = $resultados;
                $response['accion'] = 'Buscar';
                $response['message'] = 'Búsqueda realizada con éxito';
            } catch (Exception $e) {
                $response['message'] = 'Error al buscar: ' . $e->getMessage();
            }
            break;

        default:
            $response['message'] = 'Acción no válida';
            break;
    }
}

echo json_encode($response);
exit;
?>