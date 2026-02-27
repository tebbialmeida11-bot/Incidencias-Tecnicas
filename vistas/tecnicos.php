<?php
// Archivo: Formulario para crear un nuevo técnico, mostrando el listado de técnicos registrados
require_once '../config/bd.php';
try {
    $sql = "SELECT id, nombre FROM usuarios WHERE rol = 'tecnico' ORDER BY nombre ASC";
    $stmt = $pdo->query($sql);
    $tecnicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al consultar técnicos: " . $e->getMessage());
}
?>
<?php include 'encabezado.php'; ?>
<div class="header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Administración de Técnicos</h2>
    <a href="nuevo_tecnico.php" style="background-color: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px;">+ Nuevo Técnico</a>
</div>
<?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'exito'): ?>
    <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
        Técnico registrado correctamente.
    </div>
<?php endif; ?>
<table>
    <thead>
        <tr>
            <th width="20%">ID</th>
            <th width="80%">Nombre del Técnico</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($tecnicos) > 0): ?>
            <?php foreach ($tecnicos as $tec): ?>
                <tr>
                    <td>#<?php echo $tec['id']; ?></td>
                    <td><?php echo htmlspecialchars($tec['nombre']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="2" style="text-align: center;">No hay técnicos registrados.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php include 'pie.php'; ?>