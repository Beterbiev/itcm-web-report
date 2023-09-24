document.addEventListener("DOMContentLoaded", function () {
  // Obtener elementos del DOM
  const materiaLabel = document.getElementById("materia-label");
  const grupoSelect = document.getElementById("grupo-select");
  const unidadSelect = document.getElementById("unidad-select");
  const guardarBtn = document.getElementById("guardar-btn");
  const alumnosAprobadosInput = document.getElementById("alumnos-aprobados-input");
  const alumnosReprobadosInput = document.getElementById("alumnos-reprobados-input");
  const porcentajeAprobacionInput = document.getElementById("porcentaje-aprobacion-input");
  const porcentajeReprobacionInput = document.getElementById("porcentaje-reprobacion-input");
  const alumnosDesertoresInput = document.getElementById("alumnos-desertores-input");
  const porcentajeDesercionInput = document.getElementById("porcentaje-desercion-input");
  const totalAlumnosInput = document.getElementById("total-alumnos-input");
  const promedioGrupoInput = document.getElementById("promedio-grupo-input");


// Función para cargar las opciones iniciales
function cargarOpcionesIniciales() {
  // Llenar el select de grupo con las claves de grupo obtenidas de PHP
  const grupos = datos.map(function (dato) {
      return dato.clave_grupo;
  });

  grupos.forEach(function (grupo) {
      var option = document.createElement("option");
      option.value = grupo;
      option.textContent = grupo;
      grupoSelect.appendChild(option);
  });

  // Obtener el valor predeterminado del select de grupo (primer grupo)
  const grupoSeleccionadoInicial = grupoSelect.value;

  // Buscar el nombre de la materia correspondiente al grupo seleccionado inicialmente
  const materiaSeleccionadaInicial = datos.find(function (dato) {
      return dato.clave_grupo === grupoSeleccionadoInicial;
  });

  // Establecer el valor predeterminado de materia-label
  if (materiaSeleccionadaInicial) {
      materiaLabel.textContent = materiaSeleccionadaInicial.nombre_materia;
  } else {
      materiaLabel.textContent = "";
  }

  // Obtener el número de unidades de la materia seleccionada inicialmente
  const unidadesMateriaInicial = materiaSeleccionadaInicial ? materiaSeleccionadaInicial.unidades : 0;

  // Llenar el select de unidad con números desde 1 hasta el número de unidades
  for (let i = 1; i <= unidadesMateriaInicial; i++) {
      var unidadOption = document.createElement("option");
      unidadOption.value = i;
      unidadOption.textContent = i;
      unidadSelect.appendChild(unidadOption);
  }

  // Agregar un evento al select de grupo para actualizar el valor de materia-label y el select de unidad
  grupoSelect.addEventListener("change", function () {
      // Obtener el nombre de la materia correspondiente al grupo seleccionado
      const grupoSeleccionado = grupoSelect.value;
      const materiaSeleccionada = datos.find(function (dato) {
          return dato.clave_grupo === grupoSeleccionado;
      });

      // Actualizar el valor de materia-label con el nombre de la materia
      if (materiaSeleccionada) {
          materiaLabel.textContent = materiaSeleccionada.nombre_materia;
      } else {
          materiaLabel.textContent = "";
      }

      // Obtener el número de unidades de la materia seleccionada
      const unidadesMateria = materiaSeleccionada ? materiaSeleccionada.unidades : 0;

      // Limpiar el select de unidad
      unidadSelect.innerHTML = "";

      // Llenar el select de unidad con números desde 1 hasta el número de unidades
      for (let i = 1; i <= unidadesMateria; i++) {
          var unidadOption = document.createElement("option");
          unidadOption.value = i;
          unidadOption.textContent = i;
          unidadSelect.appendChild(unidadOption);
      }
  });

  // Cargar datos de reportes al inicio
  cargarDatosReportes();
}

// Función para cargar los datos de los reportes según la selección
function cargarDatosReportes() {
  // Obtener los valores seleccionados en los selectores
  const materiaSeleccionada = materiaLabel.textContent; // El nombre de la materia se obtiene de materia-label
  const grupoSeleccionado = grupoSelect.value;
  const unidadSeleccionada = unidadSelect.value;

  // Realizar una solicitud AJAX para obtener los datos del reporte
  const xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    `obtener_reportes.php?materia=${materiaSeleccionada}&clave_grupo=${grupoSeleccionado}&numero_unidad=${unidadSeleccionada}`,
    true
  );

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        // La solicitud fue exitosa, procesar la respuesta como JSON
        const respuesta = JSON.parse(xhr.responseText);

        // Verificar si hay datos disponibles
        if (respuesta.datosDisponibles) {
          // Hay datos disponibles, actualizar los campos con los datos obtenidos
          const datosReporte = respuesta.datosReporte;
          // Actualizar los campos de entrada en el DOM con los datos obtenidos
          alumnosAprobadosInput.value = datosReporte.alumnos_aprobados;
          porcentajeAprobacionInput.value = datosReporte.porcentaje_aprobacion;
          alumnosReprobadosInput.value = datosReporte.alumnos_reprobados;
          porcentajeReprobacionInput.value = datosReporte.porcentaje_reprobacion;
          alumnosDesertoresInput.value = datosReporte.alumnos_desertores;
          porcentajeDesercionInput.value = datosReporte.porcentaje_desercion;
          totalAlumnosInput.value = datosReporte.total_alumnos;
          promedioGrupoInput.value = datosReporte.promedio_grupo;
          // Actualizar otros campos de la misma manera
        } else {
          // No hay datos disponibles, vaciar los campos
          alumnosAprobadosInput.value = "";
          porcentajeAprobacionInput.value = "";
          alumnosReprobadosInput.value = "";
          porcentajeReprobacionInput.value = "";
          alumnosDesertoresInput.value = "";
          porcentajeDesercionInput.value = "";
          totalAlumnosInput.value = "";
          promedioGrupoInput.value = "";
          // Vaciar otros campos de la misma manera
        }
      } else {
        // La solicitud falló, manejar el error si es necesario
        console.error("Error en la solicitud AJAX");
      }
    }
  };

  xhr.send();
}

// Función para guardar los datos ingresados
function guardarDatos() {
  // Obtener los valores ingresados por el usuario desde los campos de entrada
  const clave_grupo = grupoSelect.value;
  const numero_unidad = parseInt(unidadSelect.value, 10); // Convertir a número entero
  const total_alumnos = parseInt(totalAlumnosInput.value, 10); // Convertir a número entero
  const alumnos_aprobados = parseInt(alumnosAprobadosInput.value, 10); // Convertir a número entero
  const porcentaje_aprobacion = parseFloat(porcentajeAprobacionInput.value); // Convertir a número de punto flotante
  const alumnos_reprobados = parseInt(alumnosReprobadosInput.value, 10); // Convertir a número entero
  const porcentaje_reprobacion = parseFloat(porcentajeReprobacionInput.value); // Convertir a número de punto flotante
  const alumnos_desertores = parseInt(alumnosDesertoresInput.value, 10); // Convertir a número entero
  const porcentaje_desercion = parseFloat(porcentajeDesercionInput.value); // Convertir a número de punto flotante
  const promedio_grupo = parseFloat(promedioGrupoInput.value); // Convertir a número de punto flotante

  // Crear un objeto con los datos que se van a enviar al servidor
  const datosParaEnviar = {
    clave_grupo,
    numero_unidad,
    total_alumnos,
    alumnos_aprobados,
    porcentaje_aprobacion,
    alumnos_reprobados,
    porcentaje_reprobacion,
    alumnos_desertores,
    porcentaje_desercion,
    promedio_grupo,
    periodo_nombre: "Primer Semestre 2023" // Reemplaza con el valor correcto
    // Puedes agregar más campos según tus necesidades
  };

  // Realizar una solicitud AJAX (por ejemplo, una solicitud POST) para enviar los datos al servidor
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "guardar_datos.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");

  // Convertir el objeto de datos a JSON
  var datosJSON = JSON.stringify(datosParaEnviar);

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        // Manejar la respuesta del servidor si es necesario
        const respuesta = JSON.parse(xhr.responseText);
        // Puedes realizar acciones adicionales en función de la respuesta del servidor
        console.log("Datos guardados con éxito:", respuesta);
      } else {
        // Manejar errores de la solicitud si es necesario
        console.error("Error al guardar los datos:", xhr.status, xhr.statusText);
      }
    }
  };

  // Enviar los datos JSON al servidor
  xhr.send(datosJSON);
}



  // Agregar event listeners a los elementos
  grupoSelect.addEventListener("change", cargarDatosReportes);
  unidadSelect.addEventListener("change", cargarDatosReportes);
  guardarBtn.addEventListener("click", guardarDatos);

  // Cargar las opciones iniciales al cargar la página
  cargarOpcionesIniciales();
});
