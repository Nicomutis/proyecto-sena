<?php
$host = 'localhost';
$db = 'ComparadorDePrecios';
$user = 'root'; // usuario de MySQL en XAMPP
$pass = ''; // contraseña

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass);
    // Establecer el modo de error de PDO a excepción
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error en la conexión: ' . $e->getMessage();
}
?>
