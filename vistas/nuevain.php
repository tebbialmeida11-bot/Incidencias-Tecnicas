<?php include 'encabezado.php'; ?>
<div class="container">
    <h2>Registrar Nueva Incidencia</h2>
    <form action="../controladores/guardar_incidencias.php" method="POST">
        <div class="form-group">
            <label for="titulo">Título de la incidencia:</label>
            <input type="text" id="titulo" name="titulo" required placeholder="Ej. El servidor no responde">
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción detallada:</label>
            <textarea id="descripcion" name="descripcion" rows="5" required placeholder="Describe el problema técnico..."></textarea>
        </div>
        <div class="form-group">
            <label for="prioridad">Nivel de Prioridad:</label>
            <select name="prioridad" id="prioridad">
                <option value="Baja">Baja</option>
                <option value="Media" selected>Media</option>
                <option value="Alta">Alta</option>
            </select>
        </div>
        <button type="submit">Guardar Incidencia</button>
    </form>
<?php include 'pie.php'; ?>