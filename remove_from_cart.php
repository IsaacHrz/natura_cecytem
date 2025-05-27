<?php
session_start();
require 'conexion.php';
header('Content-Type: application/json');

if (!isset($_SESSION['cart_id'])) {
    echo json_encode(['success' => false, 'message' => 'Sesión no iniciada']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$product_id = $data['product_id'] ?? 0;

if ($product_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Producto inválido']);
    exit;
}

$stmt = $conexion->prepare("DELETE FROM carrito WHERE session_id = ? AND producto_id = ?");
$stmt->bind_param("si", $_SESSION['cart_id'], $product_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $conexion->error]);
}

$stmt->close();
$conexion->close();
?>