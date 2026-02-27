
<?php include 'encabezado.php'; ?>
<a href="tecnicos.php" style="display: inline-block; margin-bottom: 20px; color: #0056b3; text-decoration: none;">&larr; Volver a técnicos</a>
<div style="max-width: 500px; margin: 0 auto; background: #f8f9fa; padding: 20px; border-radius: 8px; border: 1px solid #ddd;">
    <h2>Registrar Nuevo Técnico</h2>
    <form action="../controladores/guardar_tecnicos.php" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre Completo:</label>
            <input type="text" id="nombre" name="nombre" required placeholder="Ej. Carlos Martínez" autocomplete="off">
        </div>
        <button type="submit" style="background-color: #0056b3; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-size: 1em;">
            Guardar Técnico
        </button>
    </form>
</div>
<?php include 'pie.php'; ?>