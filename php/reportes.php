<!DOCTYPE html>
<html>
<head>
  <title>Reportes Académicos</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="../css/styles.css">
  <script src="../js/reportes.js" charset="UTF-8"></script>
</head>
<body>
  <h1>Reportes Académicos</h1>

  <div >
    <table id="tablaDatos">
      <thead>
        <tr>
          <th>Materia</th>
          <th>Grupo</th>
          <th>U1</th>
          <th>U2</th>
          <th>U3</th>
          <th>U4</th>
          <th>U5</th>
        </tr>
      </thead>
      <tbody id="table-body"></tbody>
    </table>
  </div>

  <table>
  <thead>
    <tr>
      <th>Generación de Reportes</th>
      <th>Acción</th>
    </tr>
  </thead>
  <tbody id="second-table-body">
    <tr>
      <td>
      <div class="report-options">
        <label for="report-type">Generación de Reportes:</label>
        <select id="report-type">
          <option value="parcial">Reporte Parcial</option>
          <option value="final">Reporte Final</option>
        </select>
      </div>
      </td>
      <td>
      <a href="visualizar_reporte.php" class="button">Generar Reporte</a>
      </td>
    </tr>
  </tbody>
</table>

  <?php
// Realiza la conexión a la base de datos (ajusta los valores de acuerdo a tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reportes";
$port = 3306;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verifica si hay errores en la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Query para obtener la información de materias, grupos y unidades
// Consulta SQL para obtener los datos de materias, grupos y el número de unidades
$sql = "SELECT m.nombre AS nombre_materia, g.clave_grupo, m.unidades
        FROM grupos g
        INNER JOIN materias m ON g.clave_materia = m.clave_materia";

$result = $conn->query($sql);

// Crear un array para almacenar los datos
$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Cerrar la conexión a la base de datos
$conn->close();

// Convertir el array PHP a formato JSON
$jsonData = json_encode($data);

// Imprimir los datos en un script para que el archivo JS pueda acceder a ellos
echo "<script> var datos = $jsonData;</script>";
?>

</body>
</html>
