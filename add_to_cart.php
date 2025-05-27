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
$quantity = $data['quantity'] ?? 1;

if ($product_id <= 0 || $quantity <= 0) {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    exit;
}

$stmt = $conexion->prepare("SELECT stock, precio FROM productos WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product || $product['stock'] < $quantity) {
    echo json_encode(['success' => false, 'message' => 'Producto no disponible o sin stock suficiente']);
    exit;
}

$stmt = $conexion->prepare("SELECT cantidad FROM carrito WHERE session_id = ? AND producto_id = ?");
$stmt->bind_param("si", $_SESSION['cart_id'], $product_id);
$stmt->execute();
$result = $stmt->get_result();
$existing = $result->fetch_assoc();

if ($existing) {
    $new_quantity = $existing['cantidad'] + $quantity;
    if ($new_quantity > $product['stock']) {
        echo json_encode(['success' => false, 'message' => 'Cantidad excede el stock disponible']);
        exit;
    }
    $stmt = $conexion->prepare("UPDATE carrito SET cantidad = ?, fecha_agregado = NOW() WHERE session_id = ? AND producto_id = ?");
    $stmt->bind_param("isi", $new_quantity, $_SESSION['cart_id'], $product_id);
} else {
    $stmt = $conexion->prepare("INSERT INTO carrito (session_id, producto_id, cantidad) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $_SESSION['cart_id'], $product_id, $quantity);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $conexion->error]);
}

$stmt->close();
$conexion->close();
?>