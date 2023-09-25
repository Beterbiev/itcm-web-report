document.addEventListener("DOMContentLoaded", function() {
  // Obtener la referencia al elemento de la tabla donde se agregarán los datos
  var tableBody = document.getElementById('table-body');

  // Verificar si la variable 'datos' está definida y tiene datos
  if (typeof datos !== 'undefined' && datos.length > 0) {
    // Iterar a través de los datos y construir filas de la tabla
    for (var i = 0; i < datos.length; i++) {
      var row = '<tr>' +
        '<td>' + datos[i].nombre_materia + '</td>' +
        '<td>' + datos[i].clave_grupo + '</td>';

      // Agregar checkboxes para cada unidad
      for (var j = 1; j <= datos[i].unidades; j++) {
        row += '<td><input type="checkbox" class="unit-checkbox" value="' + j + '"></td>';
      }

      row += '</tr>';

      // Agregar la fila a la tabla
      tableBody.innerHTML += row;
    }
  } else {
    console.error('No se encontraron datos en la variable "datos".');
  }
  
});
