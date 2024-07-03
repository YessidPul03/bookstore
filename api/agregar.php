<?php
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['titulo']) || !isset($data['autor']) || !isset($data['ano_publicacion']) || !isset($data['genero'])) {
    echo json_encode(['error' => 'Todos los campos son obligatorios']);
    exit;
}

$titulo = $data['titulo'];
$autor = $data['autor'];
$ano_publicacion = $data['ano_publicacion'];
$genero = $data['genero'];

$stmt = $pdo->prepare("INSERT INTO libros (titulo, autor, ano_publicacion, genero) VALUES (?, ?, ?, ?)");
$stmt->execute([$titulo, $autor, $ano_publicacion, $genero]);

echo json_encode(['message' => 'Libro agregado exitosamente']);
?>
