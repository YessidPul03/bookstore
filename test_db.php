<?php
$host = '127.0.0.1';
$db = 'libreria';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';
$socket = '/var/run/mysqld/mysqld.sock';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset;unix_socket=$socket";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "Connected successfully";
} catch (\PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
