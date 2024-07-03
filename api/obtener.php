<?php
require 'db.php';

$stmt = $pdo->query("SELECT * FROM libros");
$libros = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($libros);
?>
