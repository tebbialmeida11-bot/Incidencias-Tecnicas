<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Incidencias</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: 30px auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); min-height: 500px; }
        .navbar { background-color: #343a40; padding: 15px 20px; color: white; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
        .navbar-brand { font-size: 1.2em; font-weight: bold; color: white; text-decoration: none; }
        .navbar-links a { color: #d1d5db; text-decoration: none; margin-left: 20px; font-weight: bold; transition: color 0.3s; }
        .navbar-links a:hover { color: #ffffff; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], textarea, select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .estatus, .prioridad { padding: 5px 10px; border-radius: 15px; font-size: 0.85em; font-weight: bold; }
        .estatus.Abierta { background-color: #ffc107; color: #000; }
        .estatus.En\ proceso { background-color: #17a2b8; color: #fff; }
        .estatus.Cerrada { background-color: #28a745; color: #fff; }
        .prioridad.Baja { background-color: #e2e3e5; color: #383d41; }
        .prioridad.Media { background-color: #ffeeba; color: #856404; }
        .prioridad.Alta { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .grid-cards { display: flex; gap: 20px; margin-bottom: 30px; }
        .card { flex: 1; padding: 20px; border-radius: 8px; text-align: center; color: white; }
        .card h3 { margin: 0; font-size: 1.2em; }
        .card .numero { font-size: 2.5em; font-weight: bold; margin-top: 10px; }
        .card-abierta { background-color: #ffc107; color: black; }
        .card-proceso { background-color: #17a2b8; }
        .card-cerrada { background-color: #28a745; }
    </style>
</head>
<body>
<div class="navbar">
    <a href="index.php" class="navbar-brand">🛠️ TechSupport Desk</a>
    <div class="navbar-links">
        <a href="index.php">Panel Principal</a>
        <a href="nuevain.php">Nueva Incidencia</a>
        <a href="reportes.php">Reportes</a>
    </div>
</div>
<div class="container">