fetch('php/db_connect.php')
  .then(response => response.json())
  .then(data => {
    var tableBody = document.getElementById('table-body');

    if (data.reportes && data.reportes.length > 0) {
      for (var i = 0; i < data.reportes.length; i++) {
        var reporte = data.reportes[i];
        var materia = reporte.materia;
        var grupo = reporte.grupo;
        var unidades = reporte.unidades;

        var selectOptions = '';
        for (var j = 1; j <= unidades; j++) {
          selectOptions += '<option value="' + j + '">' + j + '</option>';
        }

        var row = '<tr>' +
          '<td>' + materia + '</td>' +
          '<td>' + grupo + '</td>' +
          '<td>' +
          '<select class="unit-select">' +
          selectOptions +
          '</select>' +
          '</td>' +
          '<td><button class="button">Cargar</button></td>' +
          '</tr>';
        tableBody.innerHTML += row;
      }
    }
  })
  .catch(error => {
    console.error('Error al obtener los datos:', error);
  });
