<?php
// Verificar si se recibieron los parámetros necesarios (ficha y clave_grupo)
if (isset($_POST['ficha']) && isset($_POST['clave_grupo'])) {
    // Obtener los valores de los parámetros
    $ficha = $_POST['ficha'];
    $clave_grupo = $_POST['clave_grupo'];

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

    // Preparar la consulta para eliminar el registro de la tabla profesor_grupo
    $sql = "DELETE FROM profesor_grupo WHERE ficha = ? AND clave_grupo = ?";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);

    // Vincular los parámetros a la sentencia preparada
    $stmt->bind_param("is", $ficha, $clave_grupo);

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
    // Si no se recibieron los parámetros necesarios
    echo "Falta información para eliminar el registro.";
}
?>
