<?php
// Obtener los datos enviados por la solicitud AJAX
if (isset($_POST['materia']) && isset($_POST['grupo'])) {
    // Aquí puedes obtener la ficha del profesor si está disponible
    $ficha = 1234;
    $materia = $_POST['materia'];
    $letraGrupo = $_POST['grupo'];
    $clave_grupo = $materia . '-' . $letraGrupo;
    $periodo_nombre = 'Primer Semestre 2023';

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

    // Preparar la consulta SQL con marcadores de posición
    $sql = "INSERT INTO grupos (clave_grupo, ficha, clave_materia, grupo, periodo_nombre) VALUES (?, ?, ?, ?, ?)";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);

    // Vincular los parámetros a la sentencia preparada
    $stmt->bind_param("sisss", $clave_grupo, $ficha, $materia, $letraGrupo, $periodo_nombre);

    // Ejecutar la sentencia preparada
    if ($stmt->execute()) {
        // Enviar una respuesta de éxito
        echo "success";
    } else {
        // Enviar una respuesta de error
        echo "Error: " . $stmt->error;
    }

    // Cerrar la sentencia preparada y la conexión
    $stmt->close();
    $conn->close();
}
?>
