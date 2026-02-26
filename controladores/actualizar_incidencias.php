<?php
// Archivo: Actualiza el estatus de una incidencia y asigna un técnico (si se proporciona)
require_once '../config/bd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $estatus = $_POST['estatus'];
    $tecnico_id = !empty($_POST['tecnico_id']) ? $_POST['tecnico_id'] : NULL;
    $tecnico_id = !empty($_POST['tecnico_id']) ? $_POST['tecnico_id'] : NULL;
    if ($tecnico_id !== NULL) {
        $sql_check = "SELECT COUNT(*) FROM incidencias WHERE tecnico_id = ? AND estatus != 'Cerrada' AND id != ?";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->execute([$tecnico_id, $id]);
        $is_ocupado = $stmt_check->fetchColumn();
        if ($is_ocupado > 0) {
            die("Error de seguridad: El técnico seleccionado ya tiene una incidencia activa. Por favor, asigna a otro técnico o espera a que cierre su incidencia actual.");
        }
    }
    if (!empty($id) && !empty($estatus)) {
        try {
            $sql = "UPDATE incidencias SET estatus = ?, tecnico_id = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$estatus, $tecnico_id, $id]);
            header("Location: ../vistas/index.php?mensaje=actualizado");
            exit();
        } catch (PDOException $e) {
            die("Error al actualizar la incidencia: " . $e->getMessage());
        }
    } else {
        die("Error: Faltan datos requeridos.");
    }
} else {
    die("Acceso no permitido.");
}
?>