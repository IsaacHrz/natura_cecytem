<?php
require 'conexion.php';
header('Content-Type: application/json');

$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;

$stmt = $conexion->prepare("SELECT nombre_usuario, comentario, valoracion, fecha FROM comentarios WHERE producto_id = ? AND aprobado = 1");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$comments = [];
while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
}
echo json_encode($comments);
$stmt->close();
$conexion->close();
?>