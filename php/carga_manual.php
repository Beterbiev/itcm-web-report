<!DOCTYPE html>
<html>
<head>
  <title>Carga Manual</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="../css/styles.css">
  <script src="../js/carga_manual.js" charset="UTF-8"></script>
</head>
<body>
  <h1>Carga Manual</h1>
  <h2>Datos Materia</h2>

  <table>
    <tr>
      <th>Carrera</th>
      <td>Ing. en Sistemas Computacionales</td>
    </tr>
    <tr>
      <th>Materia</th>
      <td id="materia-label"></td>
    </tr>
    <tr>
      <th>Grupo</th>
      <td>
        <select id="grupo-select"></select>
      </td>
    </tr>
    <tr>
      <th>Unidad</th>
      <td>
        <select id="unidad-select"></select>
      </td>
    </tr>
  </table>

  <table>
    <tr>
      <th>Alumnos Aprobados</th>
      <td><input type="text" id="alumnos-aprobados-input"></td>
      <th>% Aprobación</th>
      <td><input type="text" id="porcentaje-aprobacion-input"></td>
    </tr>
    <tr>
      <th>Alumnos No Aprobados</th>
      <td><input type="text" id="alumnos-reprobados-input"></td>
      <th>% Reprobación</th>
      <td><input type="text" id="porcentaje-reprobacion-input"></td>
    </tr>
    <tr>
      <th>Alumnos que Desertaron</th>
      <td><input type="text" id="alumnos-desertores-input"></td>
      <th>% Deserción</th>
      <td><input type="text" id="porcentaje-desercion-input"></td>
    </tr>
    <tr>
      <th>Total</th>
      <td><input type="text" id="total-alumnos-input"></td>
      <th>Promedio Grupo</th>
      <td><input type="text" id="promedio-grupo-input"></td>
    </tr>
  </table>

  <div style="text-align: center;">
    <button id="guardar-btn" class="button">Registrar</button>
  </div>

  <?php
// Realizar la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reportes";
$port = 3306;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar si hay errores en la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener los datos de materias y grupos, incluyendo el número de unidades
$sql = "SELECT m.nombre AS nombre_materia, g.clave_grupo, m.unidades
        FROM grupos g
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