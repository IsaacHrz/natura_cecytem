<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['cart_id'])) {
    $_SESSION['cart_id'] = bin2hex(random_bytes(16));
}
echo json_encode(['session_id' => $_SESSION['cart_id']]);
?>