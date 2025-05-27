<?php
session_start();
require 'conexion.php';
header('Content-Type: application/json');

if (!isset($_SESSION['cart_id'])) {
    echo json_encode(['items' => []]);
    exit;
}

$stmt = $conexion->prepare("
    SELECT c.producto_id, c.cantidad, p.nombre, p.precio, p.stock 
    FROM carrito c 
    JOIN productos p ON c.producto_id = p.id 
    WHERE c.session_id = ?
");
$stmt->bind_param("s", $_SESSION['cart_id']);
$stmt->execute();
$result = $stmt->get_result();
$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}
echo json_encode(['items' => $items]);
$stmt->close();
$conexion->close();
?>