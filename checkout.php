<?php
session_start();
require 'conexion.php';
header('Content-Type: application/json');

if (!isset($_SESSION['cart_id'])) {
    echo json_encode(['success' => false, 'message' => 'Sesión no iniciada']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$name = $data['name'] ?? '';
$email = $data['email'] ?? '';

if (empty($name) || empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Nombre y email son requeridos']);
    exit;
}

// Obtener ítems del carrito
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
$total = 0;
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
    $total += $row['cantidad'] * $row['precio'];
}
$stmt->close();

if (empty($items)) {
    echo json_encode(['success' => false, 'message' => 'El carrito está vacío']);
    exit;
}

// Validar stock
$conexion->begin_transaction();
try {
    foreach ($items as $item) {
        if ($item['cantidad'] > $item['stock']) {
            throw new Exception("Stock insuficiente para el producto: {$item['nombre']}");
        }
    }

    // Crear la venta
    $stmt = $conexion->prepare("
        INSERT INTO ventas (session_id, nombre_cliente, email_cliente, total, fecha_venta) 
        VALUES (?, ?, ?, ?, NOW())
    ");
    $stmt->bind_param("sssd", $_SESSION['cart_id'], $name, $email, $total);
    $stmt->execute();
    $venta_id = $conexion->insert_id;
    $stmt->close();

    // Insertar detalles de la venta
    $stmt = $conexion->prepare("
        INSERT INTO detalles_venta (venta_id, producto_id, cantidad, precio_unitario) 
        VALUES (?, ?, ?, ?)
    ");
    foreach ($items as $item) {
        $stmt->bind_param("iiid", $venta_id, $item['producto_id'], $item['cantidad'], $item['precio']);
        $stmt->execute();

        // Actualizar stock
        $update_stmt = $conexion->prepare("
            UPDATE productos 
            SET stock = stock - ? 
            WHERE id = ?
        ");
        $update_stmt->bind_param("ii", $item['cantidad'], $item['producto_id']);
        $update_stmt->execute();
        $update_stmt->close();
    }
    $stmt->close();

    // Vaciar el carrito
    $stmt = $conexion->prepare("DELETE FROM carrito WHERE session_id = ?");
    $stmt->bind_param("s", $_SESSION['cart_id']);
    $stmt->execute();
    $stmt->close();

    $conexion->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $conexion->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conexion->close();
?>