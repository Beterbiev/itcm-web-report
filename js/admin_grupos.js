document.addEventListener("DOMContentLoaded", function() {
  // Obtener la referencia al cuerpo de la tabla
  var tableBody = document.getElementById("table-body");
  var materiaSelect = document.getElementById("materia-select");
  var grupoSelect = document.getElementById("grupo-select");
  var agregarButton = document.getElementById("agregar-button");

  // Función para crear una fila en la tabla con los datos proporcionados
  function crearFila(datos) {
    var row = document.createElement("tr");
    var nombreMateriaCell = document.createElement("td");
    var claveGrupoCell = document.createElement("td");
    var eliminarCell = document.createElement("td");

    nombreMateriaCell.textContent = datos.nombre_materia;
    claveGrupoCell.textContent = datos.clave_grupo;

    row.appendChild(nombreMateriaCell);
    row.appendChild(claveGrupoCell);

    var eliminarButton = document.createElement("button");
    eliminarButton.textContent = "Eliminar";
    eliminarButton.addEventListener("click", function() {
      eliminarFila(datos.ficha, datos.clave_grupo);
    });

    eliminarCell.appendChild(eliminarButton);
    row.appendChild(eliminarCell);

    return row;
  }

  // Función para agregar las opciones al selector de materias
  function agregarOpcionesMaterias(datos_materias) {
    for (var i = 0; i < datos_materias.length; i++) {
      var option = document.createElement("option");
      option.value = datos_materias[i].clave_materia;
      option.textContent = datos_materias[i].nombre;
      materiaSelect.appendChild(option);
    }
  }

  // Función para eliminar una fila de la tabla
  function eliminarFila(ficha, clave_grupo) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "eliminar_profesor_grupo.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        location.reload();
      }
    };
    xhr.send("ficha=" + ficha + "&clave_grupo=" + clave_grupo);
  }

  // Función para agregar un profesor a un grupo
  function agregarProfesorAGrupo() {
    var materiaSeleccionada = materiaSelect.value;
    var grupoSeleccionado = grupoSelect.value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "agregar_profesor_grupo.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          location.reload();
        } else {
          alert("Error al agregar los datos. Inténtalo de nuevo.");
        }
      }
    };
    xhr.send("materia=" + materiaSeleccionada + "&grupo=" + grupoSeleccionado);
  }

  // Evento de clic en el botón "Agregar"
  agregarButton.addEventListener("click", function() {
    agregarProfesorAGrupo();
  });

  // Crear las filas de la tabla con los datos obtenidos de profesor_grupo
  for (var i = 0; i < datos_profesor_grupo.length; i++) {
    var fila = crearFila(datos_profesor_grupo[i]);
    tableBody.appendChild(fila);
  }

  // Agregar las opciones al selector de materias
  agregarOpcionesMaterias(datos_materias);
});
