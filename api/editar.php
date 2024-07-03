<?php
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id']) || !isset($data['titulo']) || !isset($data['autor']) || !isset($data['ano_publicacion']) || !isset($data['genero'])) {
    echo json_encode(['error' => 'Todos los campos son obligatorios']);
    exit;
}

$id = $data['id'];
$titulo = $data['titulo'];
$autor = $data['autor'];
$ano_publicacion = $data['ano_publicacion'];
$genero = $data['genero'];

$stmt = $pdo->prepare("UPDATE libros SET titulo = ?, autor = ?, ano_publicacion = ?, genero = ? WHERE id = ?");
$stmt->execute([$titulo, $autor, $ano_publicacion, $genero, $id]);

echo json_encode(['message' => 'Libro editado exitosamente']);
?>
