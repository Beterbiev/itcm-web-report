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
      <th>Materia</th>
      <th>Grupo</th>
    </tr>
  </thead>
  <tbody id="table-body"></tbody>
</table>

<table>
  <thead>
    <tr>
      <th>Materia</th>
      <th>Grupo</th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody id="second-table-body">
    <tr>
      <td>
        <select id="materia-select">
          <?php foreach ($result_materias as $materia) : ?>
            <option value="<?php echo $materia['clave_materia']; ?>"><?php echo $materia['nombre']; ?></option>
          <?php endforeach; ?>
        </select>
      </td>
      <td>
        <select id="grupo-select">
          <option value="A">A</option>
          <option value="B">B</option>
          <option value="C">C</option>
          <option value="D">D</option>
          <option value="E">E</option>
        </select>
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
$sql_profesor_grupo = "SELECT pg.ficha, g.clave_grupo, m.nombre AS nombre_materia
        FROM profesor_grupo AS pg
        INNER JOIN grupos AS g ON pg.clave_grupo = g.clave_grupo AND pg.periodo_nombre = g.periodo_nombre
        INNER JOIN materias AS m ON g.clave_materia = m.clave_materia";
$result_profesor_grupo = $conn->query($sql_profesor_grupo);

// Verificar si hay resultados y crear un array para almacenar los datos
$data_profesor_grupo = array();
if ($result_profesor_grupo->num_rows > 0) {
    while ($row = $result_profesor_grupo->fetch_assoc()) {
        $data_profesor_grupo[] = $row;
    }
}

// Realizar la consulta para obtener los datos de la tabla materias
$sql_materias = "SELECT clave_materia, nombre FROM materias";
$result_materias = $conn->query($sql_materias);

// Verificar si hay resultados y crear un array para almacenar los datos de materias
$data_materias = array();
if ($result_materias->num_rows > 0) {
    while ($row = $result_materias->fetch_assoc()) {
        $data_materias[] = $row;
    }
}

// Cerrar la conexión
$conn->close();

// Convertir los arrays PHP a formato JSON
$jsonData_profesor_grupo = json_encode($data_profesor_grupo);
$jsonData_materias = json_encode($data_materias);
?>

<!-- Pasar los datos en formato JSON a las variables en el archivo JS -->
<script>
  var datos_profesor_grupo = <?php echo $jsonData_profesor_grupo; ?>;
  var datos_materias = <?php echo $jsonData_materias; ?>;
</script>
</body>
</html>
