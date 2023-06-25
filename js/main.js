var subjects = [
  { materia: 'Fundamentos de Programación', grupo: '1502-A' },
  { materia: 'Fundamentos de Programación', grupo: '1502-D' },
  { materia: 'Programación Web', grupo: '750D-B' },
  { materia: 'Programación Web para Móviles', grupo: '850F-A' }
];

// Función para crear la tabla en index.html
function crearTablaIndex() {
  var selectOptions = '';
  for (var i = 1; i <= 5; i++) {
    selectOptions += '<option value="' + i + '">' + i + '</option>';
  }

  var tableBody = document.getElementById('table-body');
  for (var j = 0; j < subjects.length; j++) {
    var row = '<tr>' +
                '<td>' + subjects[j].materia + '</td>' +
                '<td>' + subjects[j].grupo + '</td>' +
                '<td>' +
                  '<select class="unit-select">' + selectOptions + '</select>' +
                '</td>' +
                '<td><button class="button">Cargar</button></td>' +
              '</tr>';
    tableBody.innerHTML += row;
  }
}

function crearTablaAdminGrupos() {
  var tableBody = document.getElementById('table-body');
  for (var i = 0; i < subjects.length; i++) {
    var row = '<tr>' +
                '<td>' + subjects[i].materia + '</td>' +
                '<td>' + subjects[i].grupo + '</td>' +
                '<td><button class="button">Eliminar</button></td>' +
              '</tr>';
    tableBody.innerHTML += row;
  }

  var materiaSelect = document.getElementById('materia-select');
  for (var j = 0; j < subjects.length; j++) {
    var option = '<option value="' + subjects[j].materia + '">' + subjects[j].materia + '</option>';
    materiaSelect.innerHTML += option;
  }
}

function crearTablaCargaManual() {
  var tableBody = document.getElementById('table-body');
  var materiaSelect = '<select id="materia-select">';
  for (var j = 0; j < subjects.length; j++) {
    materiaSelect += '<option value="' + subjects[j].materia + '">' + subjects[j].materia + '</option>';
  }
  materiaSelect += '</select>';

  var rowMateria = '<tr>' +
                      '<th class="title-column">Materia</th>' +
                      '<td>' + materiaSelect + '</td>' +
                    '</tr>';
  tableBody.innerHTML += rowMateria;

  var rowUnidad = '<tr>' +
                    '<th class="title-column">Unidad</th>' +
                    '<td>' +
                      '<select id="unidad-select">' +
                        '<option value="1">1</option>' +
                        '<option value="2">2</option>' +
                        '<option value="3">3</option>' +
                        '<option value="4">4</option>' +
                        '<option value="5">5</option>' +
                      '</select>' +
                    '</td>' +
                  '</tr>';
  tableBody.innerHTML += rowUnidad;

  var rowPromedio = '<tr>' +
                      '<th class="title-column">Promedio Grupo</th>' +
                      '<td><input type="text" id="promedio-input" /></td>' +
                    '</tr>';
  tableBody.innerHTML += rowPromedio;
}

function crearTablaReportes() {
  var tableBody = document.getElementById('table-body');
  
  for (var i = 0; i < subjects.length; i++) {
    var row = '<tr>' +
                '<td>' + subjects[i].materia + '</td>' +
                '<td>' + subjects[i].grupo + '</td>';

    for (var j = 1; j <= 5; j++) {
      row += '<td><input type="checkbox" id="u' + j + '-' + i + '"></td>';
    }
    
    row += '</tr>';
    tableBody.innerHTML += row;
  }
}

document.addEventListener('DOMContentLoaded', function() {
  // Verificar si estamos en la página index.html
  if (window.location.pathname === '/index.html') {
    crearTablaIndex();
  }

  // Verificar si estamos en la página admin_grupos.html
  if (window.location.pathname === '/admin_grupos.html') {
    crearTablaAdminGrupos();
  }

  // Verificar si estamos en la página carga_manual.html
  if (window.location.pathname === '/carga_manual.html') {
    crearTablaCargaManual();
  }
  
  // Verificar si estamos en la página reportes.html
  if (window.location.pathname === '/reportes.html') {
    crearTablaReportes();
  }

});
