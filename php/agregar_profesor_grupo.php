<?php
// Obtener los datos enviados por la solicitud AJAX
if (isset($_POST['materia']) && isset($_POST['grupo'])) {
    $ficha = 1234; // Reemplaza esto con el valor de la ficha del profesor (si está disponible)
    $clave_grupo = $_POST['grupo'];
    $periodo_nombre = '2023'; // Reemplaza esto con el valor del periodo (si está disponible)

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

    // Insertar los datos en la tabla profesor_grupo
    $sql = "INSERT INTO profesor_grupo (ficha, clave_grupo, periodo_nombre) VALUES ('$ficha', '$clave_grupo', '$periodo_nombre')";

    if ($conn->query($sql) === TRUE) {
        // Enviar una respuesta de éxito
        echo "success";
    } else {
        // Enviar una respuesta de error
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
?>
