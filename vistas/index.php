<?php
// Archivo:Página principal que muestra el listado de incidencias
require_once '../config/bd.php';
$filtro_estatus = isset($_GET['estatus']) ? $_GET['estatus'] : '';
try {
    if ($filtro_estatus == 'Abierta' || $filtro_estatus == 'En proceso' || $filtro_estatus == 'Cerrada') {
        $sql = "SELECT id, titulo, prioridad, estatus, fecha_registro 
                FROM incidencias 
                WHERE estatus = ? 
                ORDER BY fecha_registro DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$filtro_estatus]);
        $incidencias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } 
    else {
        $filtro_estatus = ''; 
        $sql = "SELECT id, titulo, prioridad, estatus, fecha_registro 
                FROM incidencias 
                ORDER BY fecha_registro DESC";
        $stmt = $pdo->query($sql);
        $incidencias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    die("Error al consultar las incidencias: " . $e->getMessage());
}
?>
<?php include 'encabezado.php'; ?>
    <div class="header">
        <h2>Listado de Incidencias</h2>
    </div>
    <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'exito'): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
            Incidencia registrada correctamente.
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'actualizado'): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
            Incidencia actualizada correctamente.
        </div>
    <?php endif; ?>

    <div style="background-color: #e9ecef; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <form action="index.php" method="GET" style="display: flex; gap: 10px; align-items: center;">
            <label for="filtro_estatus" style="margin: 0; font-weight: bold;">Filtrar por estatus:</label>
            <select name="estatus" id="filtro_estatus" style="padding: 8px; border-radius: 4px; border: 1px solid #ccc; width: 200px;">
                <option value="">-- Todas las incidencias --</option>
                <option value="Abierta" <?php if($filtro_estatus == 'Abierta') echo 'selected'; ?>>Abierta</option>
                <option value="En proceso" <?php if($filtro_estatus == 'En proceso') echo 'selected'; ?>>En proceso</option>
                <option value="Cerrada" <?php if($filtro_estatus == 'Cerrada') echo 'selected'; ?>>Cerrada</option>
            </select>
            <button type="submit" style="background-color: #0056b3; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer;">
                Aplicar Filtro
            </button>
            <?php if ($filtro_estatus != ''): ?>
                <a href="index.php" style="color: #dc3545; text-decoration: none; margin-left: 10px; font-weight: bold;">
                    &#10006; Quitar filtro
                </a>
            <?php endif; ?>
        </form>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Prioridad</th>
                <th>Estatus</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($incidencias) > 0): ?>
                <?php foreach ($incidencias as $fila): ?>
                    <tr>
                        <td>#<?php echo $fila['id']; ?></td>
                        <td><?php echo htmlspecialchars($fila['titulo']); ?></td>
                        <td>
                            <span class="prioridad <?php echo $fila['prioridad']; ?>">
                                <?php echo $fila['prioridad']; ?>
                            </span>
                        </td>
                        <td>
                            <span class="estatus <?php echo $fila['estatus']; ?>">
                                <?php echo $fila['estatus']; ?>
                            </span>
                        </td>
                        <td><?php echo date("d/m/Y H:i", strtotime($fila['fecha_registro'])); ?></td>
                        <td>
                            <a href="detalle.php?id=<?php echo $fila['id']; ?>">Ver detalles</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center;">No hay incidencias registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

<?php include 'pie.php'; ?>
