<!DOCTYPE html>
<html>
<head>
  <title>Reportes Académicos</title>
  <meta charset="UTF-8">
  <script src="../js/reportes.js" charset="UTF-8"></script>
</head>
<body>
  <h1>Reportes Académicos</h1>

  <div class="table-wrapper">
    <table>
      <thead>
        <tr>
          <th>Materia</th>
          <th>Grupo</th>
          <th>U1</th>
          <th>U2</th>
          <th>U3</th>
          <th>U4</th>
          <th>U5</th>
        </tr>
      </thead>
      <tbody id="table-body"></tbody>
    </table>
  </div>

  <div class="report-options">
    <label for="report-type">Generación de Reportes:</label>
    <select id="report-type">
      <option value="parcial">Reporte Parcial</option>
      <option value="final">Reporte Final</option>
    </select>

    <button id="generate-report-button">Generar Reporte</button>
  </div>
</body>
</html>
