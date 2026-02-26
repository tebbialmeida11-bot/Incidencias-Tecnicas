<?php
// Archivo: /views/reportes.php
require_once '../config/bd.php';
try {
    // 1. Consulta para contar incidencias por estatus
    $sql_estatus = "SELECT estatus, COUNT(*) as total FROM incidencias GROUP BY estatus";
    $stmt_estatus = $pdo->query($sql_estatus);
    $reporte_estatus = $stmt_estatus->fetchAll(PDO::FETCH_ASSOC);

    // 2. Consulta para contar incidencias asignadas a cada técnico
    // Usamos LEFT JOIN para que también salgan los técnicos que tienen 0 incidencias
    $sql_tecnicos = "SELECT u.nombre, COUNT(i.id) as total 
                     FROM usuarios u 
                     LEFT JOIN incidencias i ON u.id = i.tecnico_id AND i.estatus != 'Cerrada'
                     WHERE u.rol = 'tecnico' 
                     GROUP BY u.id";
    $stmt_tecnicos = $pdo->query($sql_tecnicos);
    $reporte_tecnicos = $stmt_tecnicos->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al generar reportes: " . $e->getMessage());
}
?>
<?php include 'encabezado.php'; ?>
<div class="container">
    <a href="index.php" class="btn-volver">&larr; Volver al panel principal</a>
    <h2>Resumen General</h2>
    <div class="grid-cards">
        <?php foreach ($reporte_estatus as $fila): ?>
            <?php 
                $clase = '';
                if ($fila['estatus'] == 'Abierta') $clase = 'card-abierta';
                if ($fila['estatus'] == 'En proceso') $clase = 'card-proceso';
                if ($fila['estatus'] == 'Cerrada') $clase = 'card-cerrada';
            ?>
            <div class="card <?php echo $clase; ?>">
                <h3><?php echo $fila['estatus']; ?></h3>
                <div class="numero"><?php echo $fila['total']; ?></div>
            </div>
        <?php endforeach; ?>
    </div>
    <h2>Carga de Trabajo (Incidencias Activas)</h2>
    <table>
        <thead>
            <tr>
                <th>Técnico</th>
                <th>Incidencias Asignadas</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reporte_tecnicos as $tec): ?>
                <tr>
                    <td><?php echo htmlspecialchars($tec['nombre']); ?></td>
                    <td><?php echo $tec['total']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php include 'pie.php'; ?>