<?php
// Archivo: Para guardar una nueva incidencia en la base de datos
require_once '../config/bd.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $prioridad = $_POST['prioridad']; 
    if (!empty($titulo) && !empty($descripcion)) {
        try {
            $sql = "INSERT INTO incidencias (titulo, descripcion, prioridad) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$titulo, $descripcion, $prioridad]);
            header("Location: ../vistas/index.php?mensaje=exito");
            exit();
        } catch (PDOException $e) {
            die("Error al guardar la incidencia: " . $e->getMessage());
        }
    } else {
        die("Error: Todos los campos son obligatorios.");
    }
} else {
    die("Acceso no permitido.");
}
?>