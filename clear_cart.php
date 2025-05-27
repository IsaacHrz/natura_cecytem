<?php
session_start();
require 'conexion.php';
header('Content-Type: application/json');

if (!isset($_SESSION['cart_id'])) {
    echo json_encode(['success' => false, 'message' => 'Sesión no iniciada']);
    exit;
}

$stmt = $conexion->prepare("DELETE FROM carrito WHERE session_id = ?");
$stmt->bind_param("s", $_SESSION['cart_id']);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $conexion->error]);
}

$stmt->close();
$conexion->close();
?>