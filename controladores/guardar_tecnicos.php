<?php
// Archivo: Control para insercion de nuevo técnico en la base de datos
require_once '../config/bd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $rol = 'tecnico'; 
    if (!empty($nombre)) {
        try {
            $sql = "INSERT INTO usuarios (nombre, rol) VALUES (?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nombre, $rol]);
            header("Location: ../vistas/tecnicos.php?mensaje=exito");
            exit();
        } catch (PDOException $e) {
            die("Error al guardar el técnico: " . $e->getMessage());
        }
    } else {
        die("Error: El nombre es obligatorio.");
    }
} else {
    die("Acceso no permitido.");
}
?>