<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $mensaje = $_POST['mensaje'];

    $sql = 'INSERT INTO Contactos (nombre, correo, mensaje) VALUES (?, ?, ?)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $correo, $mensaje]);

    echo "Mensaje enviado correctamente.";
}
?>
