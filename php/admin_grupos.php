<!DOCTYPE html>
<html>
<head>
  <title>Administrar Grupos</title>
  <meta charset="UTF-8">
  <script src="../js/admin_grupos.js" charset="UTF-8"></script>
</head>
<body>
<h1>Administrar Grupos</h1>
<table>
  <thead>
    <tr>
      <th>Nombre Materia</th>
      <th>Clave Grupo</th>
    </tr>
  </thead>
  <tbody id="table-body"></tbody>
</table>

  <table>
    <thead>
      <tr>
        <th>Materia</th>
        <th>Grupo</th>
        <th>Eliminar</th>
        <th></th>
      </tr>
    </thead>
    <tbody id="second-table-body">
      <tr>
        <td>
          <select id="materia-select"></select>
        </td>
        <td>
          <select id="grupo-select"></select>
        </td>
        <td>
          <button id="agregar-button" class="button">Agregar</button>
        </td>
      </tr>
    </tbody>
  </table>

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

// Realizar la consulta para obtener los datos de la tabla profesor_grupo
$sql = "SELECT pg.ficha, g.clave_grupo, m.nombre AS nombre_materia
        FROM profesor_grupo AS pg
        INNER JOIN grupos AS g ON pg.clave_grupo = g.clave_grupo AND pg.periodo_nombre = g.periodo_nombre
        INNER JOIN materias AS m ON g.clave_materia = m.clave_materia";
$result = $conn->query($sql);

// Verificar si hay resultados y crear un array para almacenar los datos
$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Cerrar la conexión
$conn->close();

// Convertir el array PHP a formato JSON
$jsonData = json_encode($data);
?>

<!-- Pasar los datos en formato JSON a la variable "datos" en el archivo JS -->
  <script>
    var datos = <?php echo $jsonData; ?>;
  </script>
</body>
</html>
