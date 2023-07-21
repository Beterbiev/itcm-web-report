<!DOCTYPE html>
<html>
<head>
    <title>Materias y Tareas</title>
</head>
<body>

<h1>Materias</h1>

<!-- Mostrar los datos en una tabla HTML -->
<table id="tablaDatos">
    <tr>
        <th>Materia</th>
        <th>Grupo</th>
        <th>Unidad</th>
        <th>Cargar</th>
    </tr>
</table>

<h1>Tareas</h1>
  <table>
    <tr>
      <th>Tarea</th>
      <th>Acción</th>
    </tr>
    <tr>
      <td>Cargar datos en web</td>
      <td><a href="carga_manual.html" class="button">Cargar manual</a></td>
    </tr>
    <tr>
      <td>Reportes académicos</td>
      <td><a href="reportes.html" class="button">Generar</a></td>
    </tr>
    <tr>
      <td>Administrar grupos</td>
      <td><a href="admin_grupos.html" class="button">Administrar</a></td>
    </tr>
    <tr>
      <td>Alumnos</td>
      <td>
        <button id="alumnos-30-btn" class="button">30 alumnos</button>
        <button id="alumnos-40-btn" class="button">40 alumnos</button>
      </td>
    </tr>
  </table>

<!-- Incluir el archivo JavaScript -->
<script src="../js/index.js"></script>

<?php
// Realizar la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reportes_escolares";
$port = 3306;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar si hay errores en la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener los datos de profesor_grupo junto con los datos de materias
$sql = "SELECT pg.clave_grupo, m.nombre AS nombre_materia, m.unidades
        FROM profesor_grupo pg
        INNER JOIN grupos g ON pg.clave_grupo = g.clave_grupo
        INNER JOIN materias m ON g.clave_materia = m.clave_materia";

// Ejecutar la consulta
$result = $conn->query($sql);

// Crear un array para almacenar los datos
$data = array();

// Obtener los datos de la consulta
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Cerrar la conexión
$conn->close();

// Convertir el array PHP a formato JSON
$jsonData = json_encode($data);

// Imprimir los datos en un script para que el archivo JS pueda acceder a ellos
echo "<script> var datos = $jsonData;</script>";
?>

</body>
</html>