<?php
require 'conexion.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$productId = $data['productId'] ?? 0;
$name = $data['name'] ?? '';
$email = $data['email'] ?? '';
$rating = $data['rating'] ?? 0;
$comment = $data['comment'] ?? '';

if (empty($name) || empty($email) || empty($comment) || $rating < 1 || $rating > 5 || $productId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos o valoración inválida']);
    exit;
}

$stmt = $conexion->prepare("
    INSERT INTO comentarios (producto_id, nombre_usuario, email, comentario, valoracion, fecha, aprobado) 
    VALUES (?, ?, ?, ?, ?, NOW(), 0)
");
$stmt->bind_param("isssi", $productId, $name, $email, $comment, $rating);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $conexion->error]);
}

$stmt->close();
$conexion->close();
?>