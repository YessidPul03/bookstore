<?php
// tests/bootstrap.php
require __DIR__ . '/../vendor/autoload.php';

$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$charset = 'utf8mb4';
$socket = getenv('DB_SOCKET');

$dsn = "mysql:host=$host;dbname=$db;charset=$charset;unix_socket=$socket";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$GLOBALS['pdo'] = $pdo;

// Incluir archivos de la API
require_once __DIR__ . '/../api/agregar.php';
require_once __DIR__ . '/../api/editar.php';
require_once __DIR__ . '/../api/eliminar.php';
require_once __DIR__ . '/../api/obtener.php';
require_once __DIR__ . '/../api/obtener_por_id.php';
