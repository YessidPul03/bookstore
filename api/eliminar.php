<?php
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id'])) {
    echo json_encode(['error' => 'El ID es obligatorio']);
    exit;
}

$id = $data['id'];

$stmt = $pdo->prepare("DELETE FROM libros WHERE id = ?");
$stmt->execute([$id]);

echo json_encode(['message' => 'Libro eliminado exitosamente']);
?>
