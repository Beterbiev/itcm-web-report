<?php
// Obtener los parámetros de la solicitud GET
$clave_grupo = $_GET['clave_grupo'];
$numero_unidad = $_GET['numero_unidad'];

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

// Consulta SQL para obtener los datos del reporte desde la tabla unidades
$sql = "SELECT * FROM unidades WHERE clave_grupo = '$clave_grupo' AND numero_unidad = $numero_unidad";

// Ejecutar la consulta
$result = $conn->query($sql);

// Crear un array para almacenar los datos
$data = array();

// Obtener los datos de la consulta
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data = $row;
    }
}

// Cerrar la conexión
$conn->close();

// Crear un array para la respuesta JSON
$response = array(
    'datosReporte' => $data, 
    'datosDisponibles' => !empty($data) // Verificar si hay datos disponibles
);

// Convertir el array PHP a formato JSON
$jsonData = json_encode($response);

// Enviar la respuesta JSON al cliente
header('Content-Type: application/json');
echo $jsonData;
?>
