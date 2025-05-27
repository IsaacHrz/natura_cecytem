<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$name = $data['name'] ?? '';
$email = $data['email'] ?? '';
$subject = $data['subject'] ?? '';
$message = $data['message'] ?? '';

if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Por favor completa todos los campos']);
    exit;
}

// Aquí podrías implementar el envío de correo o guardar el mensaje en una base de datos
// Por ahora, simulamos el éxito
echo json_encode(['success' => true]);
?>