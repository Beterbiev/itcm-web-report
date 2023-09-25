<?php
// Verificar si se recibieron los parámetros necesarios (clave_grupo)
if (isset($_POST['clave_grupo'])) {
    // Obtener el valor del parámetro
    $clave_grupo = $_POST['clave_grupo'];

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

    // Preparar la consulta para eliminar el registro de la tabla grupos
    $sql = "DELETE FROM grupos WHERE clave_grupo = ?";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);

    // Vincular el parámetro a la sentencia preparada
    $stmt->bind_param("s", $clave_grupo);

    // Ejecutar la sentencia preparada
    if ($stmt->execute()) {
        // El registro se eliminó correctamente
        echo "Registro eliminado correctamente.";
    } else {
        // Hubo un error al eliminar el registro
        echo "Error al eliminar el registro: " . $conn->error;
    }

    // Cerrar la conexión y liberar los recursos
    $stmt->close();
    $conn->close();
} else {
    // Si no se recibió la clave_grupo
    echo "Falta información para eliminar el registro.";
}
?>
