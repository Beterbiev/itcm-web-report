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

// Consulta para obtener los datos necesarios de la tabla reportes
$sqlReportes = "SELECT reportes.id, materias.nombre AS materia, grupos.nombre AS grupo, materias.unidades
                FROM reportes
                INNER JOIN materias ON reportes.materia_id = materias.id
                INNER JOIN grupos ON reportes.grupo_id = grupos.id";
$resultReportes = $conn->query($sqlReportes);

// Consulta adicional para obtener todos los campos de la tabla reportes
$sqlAllReportes = "SELECT reportes.id, materias.nombre AS materia, grupos.nombre AS grupo, reportes.materia_id, reportes.grupo_id, reportes.unidad, reportes.alumnos_aprobados, reportes.porcentaje_aprobacion, reportes.alumnos_reprobados, reportes.porcentaje_reprobacion, reportes.alumnos_desertores, reportes.porcentaje_desercion, reportes.total_alumnos, reportes.promedio_grupo
                  FROM reportes
                  INNER JOIN materias ON reportes.materia_id = materias.id
                  INNER JOIN grupos ON reportes.grupo_id = grupos.id";
$resultAllReportes = $conn->query($sqlAllReportes);


// Crear un array para almacenar los datos
$data = array();

// Obtener los datos de reportes y guardarlos en el array
if ($resultReportes->num_rows > 0) {
    while ($row = $resultReportes->fetch_assoc()) {
        $data['reportes'][] = $row;
    }
}

// Obtener todos los campos de la tabla reportes y guardarlos en el array
if ($resultAllReportes->num_rows > 0) {
    while ($row = $resultAllReportes->fetch_assoc()) {
        $data['all_reportes'][] = $row;
    }
}

// Consulta para obtener las materias de la tabla materias
$sqlMaterias = "SELECT nombre FROM materias";
$resultMaterias = $conn->query($sqlMaterias);

// Obtener las materias y guardarlas en el array
if ($resultMaterias->num_rows > 0) {
    while ($row = $resultMaterias->fetch_assoc()) {
        $data['materias'][] = $row['nombre'];
    }
}

// Cerrar la conexión
$conn->close();

// Enviar los datos como respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
