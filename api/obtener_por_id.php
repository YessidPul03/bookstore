<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "libreria";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["message" => "Conexión fallida: " . $conn->connect_error]));
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM libros WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $libro = $result->fetch_assoc();
        echo json_encode($libro);
    } else {
        echo json_encode(["message" => "No se encontró ningún libro con el ID $id."]);
    }

    $stmt->close();
} else {
    echo json_encode(["message" => "ID no válido."]);
}

$conn->close();
?>
