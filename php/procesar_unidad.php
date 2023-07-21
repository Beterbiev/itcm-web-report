<?php
require_once '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Establecer la conexión a la base de datos
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

// Verificar si se recibió un archivo y si no hay errores en la carga
if ($_FILES["archivo"]["error"] === UPLOAD_ERR_OK) {
    $nombreArchivo = $_FILES["archivo"]["name"];
    $rutaArchivoTemp = $_FILES["archivo"]["tmp_name"];
    $grupo = $_POST["grupo"]; // Obtener el valor de grupo del formulario
    $unidad = $_POST["unidad"]; // Obtener el valor de unidad del formulario

    // Aquí puedes realizar la lógica para procesar el archivo recibido

    // Por ejemplo, puedes utilizar la biblioteca PhpSpreadsheet para leer los datos del archivo Excel

    // Cargar el archivo
    $spreadsheet = IOFactory::load($rutaArchivoTemp);

    // Obtener la primera hoja del archivo (puedes cambiar el índice si el archivo tiene varias hojas)
    $hoja = $spreadsheet->getActiveSheet();

    // Realizar el insert en la tabla unidades utilizando los valores de grupo y unidad
    // que fueron enviados junto con el archivo
    $sql = "INSERT INTO unidades (clave_grupo, numero_unidad, total_alumnos, alumnos_aprobados, alumnos_reprobados, alumnos_desertores, porcentaje_aprobacion, porcentaje_reprobacion, porcentaje_desercion, promedio_grupo, periodo_nombre)
            VALUES ('$grupo', $unidad, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);

    // Verificar si la preparación de la sentencia fue exitosa
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    // Recorrer las filas del archivo para obtener los datos y realizar los inserts en la tabla unidades
    foreach ($hoja->getRowIterator() as $row) {
        // Obtener los datos de cada celda de la fila
        $rowData = $row->getCellIterator();
        $datos = array();
        foreach ($rowData as $cell) {
            $datos[] = $cell->getValue();
        }

        // Enlazar los valores a la sentencia preparada
        $stmt->bind_param(
            "iiiiidddds",
            $datos[0], // total_alumnos
            $datos[1], // alumnos_aprobados
            $datos[2], // alumnos_reprobados
            $datos[3], // alumnos_desertores
            $datos[4], // porcentaje_aprobacion
            $datos[5], // porcentaje_reprobacion
            $datos[6], // porcentaje_desercion
            $datos[7], // promedio_grupo
            $datos[8], // periodo_nombre
        );

        // Ejecutar la consulta preparada
        $resultado = $stmt->execute();

        // Verificar si la inserción fue exitosa
        if ($resultado === false) {
            echo "Error en el insert: " . $conn->error;
            // Si deseas, puedes deshacer la transacción aquí en caso de error
            // $conn->rollback();
            // break;
        }
    }

    // Cerrar la sentencia
    $stmt->close();

    // Cerrar la conexión
    $conn->close();

    // Si es necesario, puedes enviar una respuesta al cliente para notificar que el archivo se procesó correctamente.
    echo "Archivo procesado exitosamente.";

} else {
    // Si hubo un error al cargar el archivo, puedes enviar un mensaje de error al cliente.
    echo "Error al cargar el archivo.";
}

?>
