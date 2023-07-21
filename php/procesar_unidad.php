<?php
require_once '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Verificar si se recibió un archivo y si no hay errores en la carga
if ($_FILES["archivo"]["error"] === UPLOAD_ERR_OK) {
    $nombreArchivo = $_FILES["archivo"]["name"];
    $rutaArchivoTemp = $_FILES["archivo"]["tmp_name"];

    // Aquí puedes realizar la lógica para procesar el archivo recibido

    // Por ejemplo, puedes utilizar la biblioteca PhpSpreadsheet para leer los datos del archivo Excel

    // Cargar el archivo
    $spreadsheet = IOFactory::load($rutaArchivoTemp);

    // Obtener la primera hoja del archivo (puedes cambiar el índice si el archivo tiene varias hojas)
    $hoja = $spreadsheet->getActiveSheet();

    // Obtener los datos que necesitas de la hoja del archivo y realizar las manipulaciones necesarias

    // ...

    // Por ejemplo, obtener el valor de una celda específica
    $valorCelda = $hoja->getCell('A1')->getValue();

    // ...

    // En este punto, puedes realizar las manipulaciones que necesites con los datos del archivo.

    // ...

    // Si es necesario, puedes enviar una respuesta al cliente para notificar que el archivo se procesó correctamente.
    echo "Archivo procesado exitosamente.";

} else {
    // Si hubo un error al cargar el archivo, puedes enviar un mensaje de error al cliente.
    echo "Error al cargar el archivo.";
}
?>
