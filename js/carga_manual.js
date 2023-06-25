fetch('php/db_connect.php')
  .then(response => response.json())
  .then(data => {
    var materiaSelect = document.getElementById('materia-select');
    var grupoSelect = document.getElementById('grupo-select');
    var unidadSelect = document.getElementById('unidad-select');

    var alumnosAprobadosInput = document.getElementById('alumnos-aprobados-input');
    var porcentajeAprobacionInput = document.getElementById('porcentaje-aprobacion-input');
    var alumnosReprobadosInput = document.getElementById('alumnos-reprobados-input');
    var porcentajeReprobacionInput = document.getElementById('porcentaje-reprobacion-input');
    var alumnosDesertoresInput = document.getElementById('alumnos-desertores-input');
    var porcentajeDesercionInput = document.getElementById('porcentaje-desercion-input');
    var totalAlumnosInput = document.getElementById('total-alumnos-input');
    var promedioGrupoInput = document.getElementById('promedio-grupo-input');

    var guardarBtn = document.getElementById('guardar-btn');

    function actualizarGruposYUnidades() {
      var materiaSeleccionada = materiaSelect.value;

      var reportesSeleccionados = data.reportes.filter(reporte => reporte.materia === materiaSeleccionada);

      grupoSelect.innerHTML = '';
      unidadSelect.innerHTML = '';

      var grupos = [];
      var unidades = 0;
      reportesSeleccionados.forEach(reporte => {
        var reporteGrupos = reporte.grupo.split(",");
        grupos = grupos.concat(reporteGrupos.map(grupo => grupo.trim()));
        unidades = Math.max(unidades, parseInt(reporte.unidades));
      });

      grupos.forEach(grupo => {
        var grupoOption = document.createElement('option');
        grupoOption.value = grupo;
        grupoOption.textContent = grupo;
        grupoSelect.appendChild(grupoOption);
      });

      for (var j = 1; j <= unidades; j++) {
        var unidadOption = document.createElement('option');
        unidadOption.value = j;
        unidadOption.textContent = j;
        unidadSelect.appendChild(unidadOption);
      }
    }

    function actualizarCampos() {
      var materiaSeleccionada = materiaSelect.value;
      var grupoSeleccionado = grupoSelect.value;
      var unidadSeleccionada = unidadSelect.value;

      var reporteSeleccionado = data.all_reportes.find(reporte => {
        return (
          reporte.materia === materiaSeleccionada &&
          reporte.grupo === grupoSeleccionado &&
          reporte.unidad === unidadSeleccionada
        );
      });

      if (reporteSeleccionado) {
        alumnosAprobadosInput.value = reporteSeleccionado.alumnos_aprobados;
        porcentajeAprobacionInput.value = reporteSeleccionado.porcentaje_aprobacion;
        alumnosReprobadosInput.value = reporteSeleccionado.alumnos_reprobados;
        porcentajeReprobacionInput.value = reporteSeleccionado.porcentaje_reprobacion;
        alumnosDesertoresInput.value = reporteSeleccionado.alumnos_desertores;
        porcentajeDesercionInput.value = reporteSeleccionado.porcentaje_desercion;
        totalAlumnosInput.value = reporteSeleccionado.total_alumnos;
        promedioGrupoInput.value = reporteSeleccionado.promedio_grupo;
      } else {
        alumnosAprobadosInput.value = '';
        porcentajeAprobacionInput.value = '';
        alumnosReprobadosInput.value = '';
        porcentajeReprobacionInput.value = '';
        alumnosDesertoresInput.value = '';
        porcentajeDesercionInput.value = '';
        totalAlumnosInput.value = '';
        promedioGrupoInput.value = '';
      }
      console.log(materiaSeleccionada);
      console.log(grupoSeleccionado);
      console.log(unidadSeleccionada);

      console.log(unidadSeleccionada);
    }

    function guardarDatos() {
        var materiaSeleccionada = materiaSelect.value;
        var grupoSeleccionado = grupoSelect.value;
        var unidadSeleccionada = unidadSelect.value;
  
        var reporteSeleccionado = data.all_reportes.find(reporte => {
          return (
            reporte.materia === materiaSeleccionada &&
            reporte.grupo === grupoSeleccionado &&
            reporte.unidad === unidadSeleccionada
          );
        });
  
        if (reporteSeleccionado) {
          reporteSeleccionado.alumnos_aprobados = alumnosAprobadosInput.value;
          reporteSeleccionado.porcentaje_aprobacion = porcentajeAprobacionInput.value;
          reporteSeleccionado.alumnos_reprobados = alumnosReprobadosInput.value;
          reporteSeleccionado.porcentaje_reprobacion = porcentajeReprobacionInput.value;
          reporteSeleccionado.alumnos_desertores = alumnosDesertoresInput.value;
          reporteSeleccionado.porcentaje_desercion = porcentajeDesercionInput.value;
          reporteSeleccionado.total_alumnos = totalAlumnosInput.value;
          reporteSeleccionado.promedio_grupo = promedioGrupoInput.value;
  
          // Enviar la solicitud de actualización al servidor
          fetch('php/actualizar_reporte.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(reporteSeleccionado)
          })
            .then(response => response.json())
            .then(data => {
              console.log('Reporte actualizado:', data);
            })
            .catch(error => {
              console.error('Error al actualizar el reporte:', error);
            });
        }
      }
  
      materiaSelect.addEventListener('change', actualizarGruposYUnidades);
      grupoSelect.addEventListener('change', actualizarCampos);
      unidadSelect.addEventListener('change', actualizarCampos);
      guardarBtn.addEventListener('click', guardarDatos);


    data.materias.forEach(materia => {
      var materiaOption = document.createElement('option');
      materiaOption.value = materia;
      materiaOption.textContent = materia;
      materiaSelect.appendChild(materiaOption);
    });

    actualizarGruposYUnidades();
    actualizarCampos();
  })
  .catch(error => {
    console.error('Error al obtener los datos:', error);
  });
