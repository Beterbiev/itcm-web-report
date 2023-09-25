<!DOCTYPE html>
<html>

<head>
    <title>Reporte Escolar</title>
    <script src="../js/visualizar_reporte.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <style>
        th {
            max-width: 200px; /* Ancho máximo para los encabezados */
            white-space: nowrap; /* Evitar el truncamiento del texto */
            overflow: hidden; /* Ocultar el texto que desborda el ancho máximo */
            text-overflow: ellipsis; /* Mostrar puntos suspensivos (...) cuando el texto desborda */
        }
    </style>
</head>

<body>
    <h1>Generar Reporte Escolar</h1>

    <table>
        <tr>
            <th>Reporte</th>
            <td>
                <select id="report-type">
                    <option value="parcial1">Parcial 1</option>
                    <option value="parcial2">Parcial 2</option>
                    <option value="parcial3">Parcial 3</option>
                </select>
            </td>
        </tr>
        <tr>
            <th>Semestre</th>
            <td>
                <select id="semester">
                    <option value="semestre1">Semestre 1</option>
                    <option value="semestre2">Semestre 2</option>
                    <!-- Agrega más opciones según tus necesidades -->
                </select>
            </td>
        </tr>
        <tr>
            <th>Grupos Atendidos</th>
            <td>
                <select id="groups">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </td>
        </tr>
        <tr>
            <th>Asignaturas diferentes</th>
            <td>
                <select id="subject-count">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </td>
        </tr>
    </table>

    <h1>Tabla de Reportes</h1>

    <table id="tabla-reportes">
        <thead>
            <tr>
                <th>Carrera</th>
                <th>Grupo</th>
                <th>Materia</th>
                <th>Unidad</th>
                <th>A</th>
                <th>R</th>
                <th>%A</th>
                <th>NA</th>
                <th>%NA</th>
                <th>D</th>
                <th>%D</th>
                <th>T</th>
                <th>Prom</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if (isset($_GET['data'])) {
                // Decodifica el JSON desde base64
                $base64Data = $_GET['data'];
                $jsonData = base64_decode($base64Data);
                
                // Convierte el JSON en un array asociativo
                $selectedData = json_decode($jsonData, true);

                // Puedes iterar sobre $selectedData y acceder a los datos de cada fila seleccionada
                foreach ($selectedData as $data) {
                    $nombreMateria = $data['nombre_materia'];
                    $claveGrupo = $data['clave_grupo'];
                    $unidad = $data['unidad'];
                    
                    // Haz lo que necesites con estos datos
                    echo 'Materia: ' . $nombreMateria . '<br>';
                    echo 'Grupo: ' . $claveGrupo . '<br>';
                    echo 'Unidad seleccionada: ' . $unidad . '<br>';
                    echo '<br>';
                }
            } else {
                echo 'No se recibieron datos válidos.';
            }
        ?>

        </tbody>
    </table>

</body>

</html>
