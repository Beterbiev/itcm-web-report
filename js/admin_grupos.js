fetch('php/db_connect.php')
  .then(response => response.json())
  .then(data => {
    var tableBody = document.getElementById('table-body');

    if (data.reportes && data.reportes.length > 0) {
      for (var i = 0; i < data.reportes.length; i++) {
        var reporte = data.reportes[i];
        var materia = reporte.materia;
        var grupo = reporte.grupo;

        var row = '<tr>' +
          '<td>' + materia + '</td>' +
          '<td>' + grupo + '</td>' +
          '<td><button class="eliminar-button">Eliminar</button></td>' +
          '</tr>';
        tableBody.innerHTML += row;
      }
    }

    // Código para generar opciones de materias
    var materiaSelect = document.getElementById('materia-select');
    var materias = data.materias;

    for (var j = 0; j < materias.length; j++) {
      var materiaOption = document.createElement('option');
      materiaOption.value = materias[j];
      materiaOption.textContent = materias[j];
      materiaSelect.appendChild(materiaOption);
    }

    // Código para generar opciones de grupos
    var grupoSelect = document.getElementById('grupo-select');
    var grupos = [];

    for (var k = 0; k < data.reportes.length; k++) {
      var reporte = data.reportes[k];
      var grupo = reporte.grupo;

      if (!grupos.includes(grupo)) {
        grupos.push(grupo);
        var grupoOption = document.createElement('option');
        grupoOption.value = grupo;
        grupoOption.textContent = grupo;
        grupoSelect.appendChild(grupoOption);
      }
    }
  })
  .catch(error => {
    console.error('Error al obtener los datos:', error);
  });
