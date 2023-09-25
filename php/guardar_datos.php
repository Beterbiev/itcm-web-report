<?php
// Verificar si se recibió una solicitud POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los datos JSON enviados desde el cliente
    $data = json_decode(file_get_contents("php://input"));

    // Verificar si se recibieron datos
    if ($data === null) {
        http_response_code(400); // Bad Request
        echo json_encode(array("mensaje" => "No se recibieron datos válidos."));
        exit;
    }

    // Realizar la conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "reportes";
    $port = 3306;

    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    // Verificar si hay errores en la conexión
    if ($conn->connect_error) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("mensaje" => "Error en la conexión: " . $conn->connect_error));
        exit;
    }

    // Verificar si se proporcionó clave_grupo y numero_unidad para identificar la actualización
    if (isset($data->clave_grupo) && isset($data->numero_unidad)) {
        // Es una actualización
        $clave_grupo = $data->clave_grupo;
        $numero_unidad = $data->numero_unidad;
        $total_alumnos = $data->total_alumnos;
        $alumnos_aprobados = $data->alumnos_aprobados;
        $alumnos_reprobados = $data->alumnos_reprobados;
        $alumnos_desertores = $data->alumnos_desertores;
        $porcentaje_aprobacion = $data->porcentaje_aprobacion;
        $porcentaje_reprobacion = $data->porcentaje_reprobacion;
        $porcentaje_desercion = $data->porcentaje_desercion;
        $promedio_grupo = $data->promedio_grupo;
        $periodo_nombre = $data->periodo_nombre;

        // Construir la consulta SQL de actualización
        $sql = "UPDATE unidades SET total_alumnos = $total_alumnos, alumnos_aprobados = $alumnos_aprobados, alumnos_reprobados = $alumnos_reprobados, alumnos_desertores = $alumnos_desertores, porcentaje_aprobacion = $porcentaje_aprobacion, porcentaje_reprobacion = $porcentaje_reprobacion, porcentaje_desercion = $porcentaje_desercion, promedio_grupo = $promedio_grupo, periodo_nombre = '$periodo_nombre' WHERE clave_grupo = '$clave_grupo' AND numero_unidad = $numero_unidad";
    } else {
        // Es una inserción
        $clave_grupo = $data->clave_grupo;
        $numero_unidad = $data->numero_unidad;
        $total_alumnos = $data->total_alumnos;
        $alumnos_aprobados = $data->alumnos_aprobados;
        $alumnos_reprobados = $data->alumnos_reprobados;
        $alumnos_desertores = $data->alumnos_desertores;
        $porcentaje_aprobacion = $data->porcentaje_aprobacion;
        $porcentaje_reprobacion = $data->porcentaje_reprobacion;
        $porcentaje_desercion = $data->porcentaje_desercion;
        $promedio_grupo = $data->promedio_grupo;
        $periodo_nombre = $data->periodo_nombre;

        // Construir la consulta SQL de inserción
        $sql = "INSERT INTO unidades (clave_grupo, numero_unidad, total_alumnos, alumnos_aprobados, alumnos_reprobados, alumnos_desertores, porcentaje_aprobacion, porcentaje_reprobacion, porcentaje_desercion, promedio_grupo, periodo_nombre) VALUES ('$clave_grupo', $numero_unidad, $total_alumnos, $alumnos_aprobados, $alumnos_reprobados, $alumnos_desertores, $porcentaje_aprobacion, $porcentaje_reprobacion, $porcentaje_desercion, $promedio_grupo, '$periodo_nombre')";
    }

    if ($conn->query($sql) === TRUE) {
        // Inserción o actualización exitosa
        // Cerrar la conexión
        $conn->close();

        // Responder con un mensaje de éxito
        $response = array("mensaje" => "Datos guardados con éxito.");
        echo json_encode($response);
        exit;
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("mensaje" => "Error al guardar los datos: " . $conn->error));
        exit;
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("mensaje" => "Método no permitido."));
    exit;
}
?>
