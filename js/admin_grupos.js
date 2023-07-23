document.addEventListener("DOMContentLoaded", function() {
  // Obtener la referencia al cuerpo de la tabla
  var tableBody = document.getElementById("table-body");

  // Función para crear una fila en la tabla con los datos proporcionados
  function crearFila(datos) {
    var row = document.createElement("tr");
    var nombreMateriaCell = document.createElement("td");
    var claveGrupoCell = document.createElement("td");
    var eliminarCell = document.createElement("td"); // Nueva celda para el botón "Eliminar"

    nombreMateriaCell.textContent = datos.nombre_materia;
    claveGrupoCell.textContent = datos.clave_grupo;

    row.appendChild(nombreMateriaCell);
    row.appendChild(claveGrupoCell);

    // Crear el botón "Eliminar" y añadir el evento para eliminar la fila
    var eliminarButton = document.createElement("button");
    eliminarButton.textContent = "Eliminar";
    eliminarButton.addEventListener("click", function() {
      // Realizar una solicitud AJAX para eliminar la fila de la tabla profesor_grupo
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "eliminar_profesor_grupo.php", true); // Archivo PHP para eliminar el registro de la base de datos
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          // Eliminar la fila de la tabla en la página después de eliminarla en la base de datos
          tableBody.removeChild(row);
        }
      };
      xhr.send("ficha=" + datos.ficha + "&clave_grupo=" + datos.clave_grupo);
    });

    eliminarCell.appendChild(eliminarButton);
    row.appendChild(eliminarCell);

    return row;
  }

  // Crear las filas de la tabla con los datos obtenidos
  for (var i = 0; i < datos.length; i++) {
    var fila = crearFila(datos[i]);
    tableBody.appendChild(fila);
  }
});
