<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "residencias_basedatos";
$port = 3306;
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Obtener los datos del reporte enviado en la solicitud
$data = json_decode(file_get_contents('php://input'), true);

// Actualizar los valores en la base de datos
$sql = "UPDATE reportes
        SET alumnos_aprobados = '".$data['alumnos_aprobados']."',
            porcentaje_aprobacion = '".$data['porcentaje_aprobacion']."',
            alumnos_reprobados = '".$data['alumnos_reprobados']."',
            porcentaje_reprobacion = '".$data['porcentaje_reprobacion']."',
            alumnos_desertores = '".$data['alumnos_desertores']."',
            porcentaje_desercion = '".$data['porcentaje_desercion']."',
            total_alumnos = '".$data['total_alumnos']."',
            promedio_grupo = '".$data['promedio_grupo']."'
        WHERE id = '".$data['id']."'";

if ($conn->query($sql) === TRUE) {
    // Éxito en la actualización
    $response = array('success' => true);
} else {
    // Error en la actualización
    $response = array('success' => false, 'error' => $conn->error);
}

// Cerrar la conexión
$conn->close();

// Enviar la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
