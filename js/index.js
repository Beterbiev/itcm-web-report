// Función para crear el elemento select con las opciones de unidades
function crearSelectUnidades(numeroUnidades) {
  var selectUnidades = document.createElement("select");
  for (var i = 1; i <= numeroUnidades; i++) {
      var option = document.createElement("option");
      option.text = i;
      selectUnidades.add(option);
  }
  return selectUnidades;
}

// Función para agregar el input con atributo accept a una fila de la tabla
function agregarInputCargar(row) {
  var cargarCell = row.insertCell(); // Agregamos la celda para el input

  // Crear el elemento input para "Cargar" el archivo
  var inputCargar = document.createElement("input");
  inputCargar.type = "file";
  inputCargar.accept = ".xlsx, .xls"; // Establecer el atributo accept para archivos Excel

  // Obtener los valores de clave_grupo y numero_unidad al seleccionar el archivo
  var grupoCellValue = row.cells[1].innerHTML; // Valor de la celda de grupoCell (clave_grupo)
  var unidadesCellValue = row.cells[2].getElementsByTagName("select")[0].value; // Valor del select de unidadesCell (numero_unidad)

  // Agregar un evento al input para manejar el archivo seleccionado
  inputCargar.addEventListener("change", function () {
      var file = inputCargar.files[0];
      if (file) {
          // Crear un objeto FormData para enviar el archivo al servidor
          var formData = new FormData();
          formData.append("archivo", file);
          formData.append("grupo", grupoCellValue);
          formData.append("unidad", unidadesCellValue);

          // Realizar una solicitud AJAX para enviar el archivo al servidor
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "procesar_unidad.php", true);
          xhr.onreadystatechange = function () {
              if (xhr.readyState === 4 && xhr.status === 200) {
                  // Manejar la respuesta del servidor (si es necesario)
                  var respuesta = xhr.responseText;
                  alert(respuesta);
              }
          };
          xhr.send(formData);
      }
  });

  // Agregar el input "Cargar" a la celda correspondiente
  cargarCell.appendChild(inputCargar);
}

document.addEventListener("DOMContentLoaded", function() {
  // Acceder a la tabla HTML donde mostraremos los datos
  var tabla = document.getElementById("tablaDatos");

  // Recorrer los datos obtenidos desde PHP y mostrarlos en la tabla
  datos.forEach(function(dato) {
    var row = tabla.insertRow();
    var materiaCell = row.insertCell();
    var grupoCell = row.insertCell();
    var unidadesCell = row.insertCell();

    materiaCell.innerHTML = dato.nombre_materia;
    grupoCell.innerHTML = dato.clave_grupo;

    // Crear el elemento select con las opciones para las unidades
    var selectUnidades = crearSelectUnidades(dato.unidades);

    // Agregar el elemento select a la celda de "Unidades"
    unidadesCell.appendChild(selectUnidades);

    // Agregar el input "Cargar"
    agregarInputCargar(row);
  });
});
