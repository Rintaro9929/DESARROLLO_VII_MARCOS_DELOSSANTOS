<?php

header('Content-Type: application/json');

require_once 'seguridad.php';
require_once 'api/products.php';

$products = new Products();

$method = $_SERVER['REQUEST_METHOD'];

$data = json_decode(
    file_get_contents("php://input"),
    true
);

switch ($method) {

    case 'GET':
        $products->get();
        break;

    case 'POST':
        $products->post($data);
        break;

    case 'PUT':
        $products->put($data);
        break;

    case 'DELETE':
        $products->delete($data);
        break;

    default:

        http_response_code(405);

        echo json_encode([
            "error" => "Método no permitido"
        ]);
}