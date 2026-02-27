<?php
// Archivo: Maneja la vista de detalle de una incidencia específica, permitiendo actualizar su estatus y asignar un técnico
require_once '../config/BD.php';
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de incidencia no especificado.");
}
$incidencia_id = $_GET['id'];
try {
    $sql_incidencia = "SELECT * FROM incidencias WHERE id = ?";
    $stmt_inc = $pdo->prepare($sql_incidencia);
    $stmt_inc->execute([$incidencia_id]);
    $incidencia = $stmt_inc->fetch(PDO::FETCH_ASSOC);
    if (!$incidencia) {
        die("La incidencia no existe.");
    }
    $sql_tecnicos = "SELECT u.id, u.nombre, 
                     (SELECT COUNT(*) FROM incidencias i 
                      WHERE i.tecnico_id = u.id AND i.estatus != 'Cerrada' AND i.id != ?) AS ocupado 
                     FROM usuarios u WHERE u.rol = 'tecnico'";
    $stmt_tec = $pdo->prepare($sql_tecnicos);
    $stmt_tec->execute([$incidencia_id]);
    $tecnicos = $stmt_tec->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error de base de datos: " . $e->getMessage());
}
?>
<?php include 'encabezado.php'; ?>
<div class="container">
    <a href="index.php" class="btn-volver">&larr; Volver al listado</a>
    <h2>Detalle de Incidencia #<?php echo $incidencia['id']; ?></h2>
    <div class="info-box">
        <h3><?php echo htmlspecialchars($incidencia['titulo']); ?></h3>
        <p><strong>Descripción:</strong><br> <?php echo nl2br(htmlspecialchars($incidencia['descripcion'])); ?></p>
        <p><strong>Fecha de Registro:</strong> <?php echo date("d/m/Y H:i", strtotime($incidencia['fecha_registro'])); ?></p>
    </div>
    <?php if ($incidencia['estatus'] == 'Cerrada'): ?>
        <?php 
            $nombre_tecnico_cierre = "Desconocido/Sin asignar";
            foreach ($tecnicos as $t) {
                if ($t['id'] == $incidencia['tecnico_id']) {
                    $nombre_tecnico_cierre = $t['nombre'];
                    break;
                }
            }
        ?>
        <div style="background-color: #d4edda; border: 1px solid #c3e6cb; padding: 20px; border-radius: 8px; text-align: center; margin-bottom: 20px;">
            <h3 style="color: #155724; margin-top: 0;">Incidencia Resuelta y Cerrada</h3>
            <p style="color: #155724; font-size: 1.1em;">
                <strong>Resuelto por:</strong> <?php echo htmlspecialchars($nombre_tecnico_cierre); ?>
            </p>
            <p style="color: #155724; margin-bottom: 15px;">El técnico ha sido liberado y el ticket está bloqueado para modificaciones.</p>
            <a href="../controladores/exportar_reporte.php?id=<?php echo $incidencia['id']; ?>" target="_blank" style="display: inline-block; background-color: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 1em;">
                Exportar reporte
            </a>
        </div>
    <?php else: ?>
        <form action="../controladores/actualizar_incidencias.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $incidencia['id']; ?>">
            <div class="form-group">
                <label for="estatus">Actualizar Estatus:</label>
                <select name="estatus" id="estatus">
                    <option value="Abierta" <?php if($incidencia['estatus'] == 'Abierta') echo 'selected'; ?>>Abierta</option>
                    <option value="En proceso" <?php if($incidencia['estatus'] == 'En proceso') echo 'selected'; ?>>En proceso</option>
                    <option value="Cerrada" <?php if($incidencia['estatus'] == 'Cerrada') echo 'selected'; ?>>Cerrada</option>
                </select>
            </div>
            <div class="form-group">
                <label for="tecnico_id">Asignar Técnico:</label>
                <select name="tecnico_id" id="tecnico_id">
                    <option value="">-- Sin asignar --</option>
                    <?php foreach ($tecnicos as $tecnico): ?>
                        <?php 
                            $es_el_asignado = ($incidencia['tecnico_id'] == $tecnico['id']);
                            $bloqueado = ($tecnico['ocupado'] > 0 && !$es_el_asignado) ? 'disabled' : '';
                            $texto_extra = ($tecnico['ocupado'] > 0 && !$es_el_asignado) ? ' (Ocupado)' : '';
                        ?>
                        <option value="<?php echo $tecnico['id']; ?>" <?php if($es_el_asignado) echo 'selected'; ?> <?php echo $bloqueado; ?>>
                            <?php echo htmlspecialchars($tecnico['nombre']) . $texto_extra; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit">Guardar Cambios</button>
        </form>
    <?php endif; ?>
            </select> </div>
    </form>
<?php include 'pie.php'; ?>