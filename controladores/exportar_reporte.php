<?php
require_once '../config/bd.php';
require_once '../librerias/TCPDF-main/tcpdf.php'; // Asegúrate de que esta ruta coincida con tu estructura
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de incidencia no proporcionado.");
}
$incidencia_id = $_GET['id'];
try {
    $sql = "SELECT i.*, u.nombre AS tecnico_nombre 
            FROM incidencias i 
            LEFT JOIN usuarios u ON i.tecnico_id = u.id 
            WHERE i.id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$incidencia_id]);
    $incidencia = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$incidencia) {
        die("La incidencia no existe.");
    }
    $pdf = new TCPDF('P', 'mm', 'LETTER', true, 'UTF-8', false);
    $pdf->SetCreator('Sistema de Incidencias');
    $pdf->SetAuthor('Departamento de TI');
    $pdf->SetTitle('Reporte de Incidencia #' . $incidencia['id']);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(15, 15, 15);
    $pdf->SetAutoPageBreak(TRUE, 15);
    $pdf->AddPage();
    $fecha_registro = date("d/m/Y h:i A", strtotime($incidencia['fecha_registro']));
    $tecnico = htmlspecialchars($incidencia['tecnico_nombre'] ?? 'No asignado');
    $titulo = htmlspecialchars($incidencia['titulo']);
    $descripcion = nl2br(htmlspecialchars($incidencia['descripcion']));
    $prioridad = $incidencia['prioridad'];
    $html = <<<EOD
    <h1 style="color: #0056b3; text-align: center;">Reporte de Incidencia Técnica</h1>
    <hr>
    <br><br>
    
    <table cellpadding="5" style="width: 100%; border: 1px solid #ddd;">
        <tr style="background-color: #f4f4f9;">
            <td width="30%"><strong>ID de Incidencia:</strong></td>
            <td width="70%">#{$incidencia['id']}</td>
        </tr>
        <tr>
            <td><strong>Fecha de Registro:</strong></td>
            <td>{$fecha_registro}</td>
        </tr>
        <tr style="background-color: #f4f4f9;">
            <td><strong>Prioridad:</strong></td>
            <td>{$prioridad}</td>
        </tr>
        <tr>
            <td><strong>Estatus:</strong></td>
            <td><strong style="color: #155724;">CERRADA</strong></td>
        </tr>
        <tr style="background-color: #f4f4f9;">
            <td><strong>Técnico Responsable:</strong></td>
            <td>{$tecnico}</td>
        </tr>
    </table>

    <br><br>
    <h3 style="border-bottom: 1px solid #ccc;">Detalles del Problema:</h3>
    <h4>{$titulo}</h4>
    <p>{$descripcion}</p>

    <br><br><br><br>
    <table style="width: 100%; text-align: center;">
        <tr>
            <td>
                ___________________________________<br>
                <strong>Firma del Técnico</strong><br>
                {$tecnico}
            </td>
            <td>
                ___________________________________<br>
                <strong>Sello de Conformidad</strong>
            </td>
        </tr>
    </table>
EOD;

    // 6. Imprimir el HTML dentro del PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // 7. Generar el archivo y mostrarlo en el navegador
    // La 'I' significa Inline (Mostrar en el navegador). 
    // Si la cambias por 'D', forzará la descarga del archivo.
    $pdf->Output('Reporte_Incidencia_' . $incidencia['id'] . '.pdf', 'I');

} catch (PDOException $e) {
    die("Error en la base de datos: " . $e->getMessage());
}
?>