document.addEventListener("DOMContentLoaded", function() {
  // Acceder a la tabla HTML donde mostraremos los datos
  var tabla = document.getElementById("tablaDatos");

  // Recorrer los datos obtenidos desde PHP y mostrarlos en la tabla
  datos.forEach(function(dato) {
      var row = tabla.insertRow();
      var materiaCell = row.insertCell(0); // Cambiamos el orden aquí
      var grupoCell = row.insertCell(1); // Cambiamos el orden aquí
      var unidadesCell = row.insertCell(2); // Cambiamos el orden aquí

      materiaCell.innerHTML = dato.nombre_materia; // Cambiamos el nombre de la propiedad aquí
      grupoCell.innerHTML = dato.clave_grupo;
      unidadesCell.innerHTML = dato.unidades;
  });
});
