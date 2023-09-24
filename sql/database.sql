CREATE DATABASE reportes;

USE reportes;

CREATE TABLE periodos_escolares (
  nombre VARCHAR(255) PRIMARY KEY,
  fecha_inicio DATE,
  fecha_fin DATE
);

CREATE TABLE departamento (
  id INT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL
);

CREATE TABLE carrera (
  id INT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL
);

CREATE TABLE profesor (
  ficha INT(4) UNSIGNED ZEROFILL PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  departamento_id INT,
  FOREIGN KEY (departamento_id) REFERENCES departamento(id)
);

CREATE TABLE materias (
  clave_materia VARCHAR(255) PRIMARY KEY,
  clave_asignatura VARCHAR(255),
  nombre VARCHAR(255) NOT NULL,
  unidades INT(1) NOT NULL,
  carrera_id INT,
  FOREIGN KEY (carrera_id) REFERENCES carrera(id),
  UNIQUE (nombre)
);

CREATE TABLE grupos (
  clave_grupo VARCHAR(255) PRIMARY KEY,
  ficha INT(4) UNSIGNED ZEROFILL,  -- Agregamos la columna ficha para el merge
  clave_materia VARCHAR(255),
  grupo VARCHAR(255),
  periodo_nombre VARCHAR(255),
  FOREIGN KEY (clave_materia) REFERENCES materias(clave_materia),
  FOREIGN KEY (periodo_nombre) REFERENCES periodos_escolares(nombre) ON DELETE CASCADE,
  FOREIGN KEY (ficha) REFERENCES profesor(ficha)  -- Relación con la tabla profesor
);

CREATE TABLE rol (
  id INT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL
);

CREATE TABLE usuario (
  profesor_ficha INT(4) UNSIGNED ZEROFILL PRIMARY KEY,
  contraseña VARCHAR(255) NOT NULL,
  FOREIGN KEY (profesor_ficha) REFERENCES profesor(ficha)
);

CREATE TABLE unidades (
  clave_grupo VARCHAR(255),
  numero_unidad INT,
  total_alumnos INT,
  alumnos_aprobados INT,
  alumnos_reprobados INT,
  alumnos_desertores INT,
  porcentaje_aprobacion FLOAT,
  porcentaje_reprobacion FLOAT,
  porcentaje_desercion FLOAT,
  promedio_grupo FLOAT,
  periodo_nombre VARCHAR(255),
  PRIMARY KEY (clave_grupo, numero_unidad),
  FOREIGN KEY (clave_grupo) REFERENCES grupos(clave_grupo),
  FOREIGN KEY (periodo_nombre) REFERENCES periodos_escolares(nombre) ON DELETE CASCADE
);

CREATE TABLE reportes (
  reporte VARCHAR(255),
  clave_grupo VARCHAR(255),
  numero_unidad INT,
  FOREIGN KEY (clave_grupo, numero_unidad) REFERENCES unidades(clave_grupo, numero_unidad),
  PRIMARY KEY (reporte, clave_grupo, numero_unidad)
);

CREATE TABLE reporte_final (
  clave_grupo VARCHAR(255),
  total_alumnos INT,
  alumnos_aprobados INT,
  alumnos_reprobados INT,
  alumnos_desertores INT,
  porcentaje_aprobacion FLOAT,
  porcentaje_reprobacion FLOAT,
  porcentaje_desercion FLOAT,
  promedio_unidad FLOAT,
  PRIMARY KEY (clave_grupo),
  FOREIGN KEY (clave_grupo) REFERENCES grupos(clave_grupo)
);

INSERT INTO periodos_escolares (nombre, fecha_inicio, fecha_fin) 
VALUES ('Primer Semestre 2023', '2023-01-01', '2023-06-30');

INSERT INTO departamento (id, nombre) VALUES (1, 'Ciencias Básicas');
INSERT INTO departamento (id, nombre) VALUES (2, 'Sistemas');

INSERT INTO carrera (id, nombre) VALUES (1, 'Ingeniería en Sistemas Computacionales');
INSERT INTO carrera (id, nombre) VALUES (2, 'Ingeniería Industrial');

INSERT INTO profesor (ficha, nombre, departamento_id) VALUES (1234, 'Juan Pérez', 2);
INSERT INTO profesor (ficha, nombre, departamento_id) VALUES (5678, 'María Rodríguez', 2);

INSERT INTO materias (clave_materia, clave_asignatura, nombre, unidades, carrera_id) 
VALUES ('1502', 'CB104', 'Fundamentos de Programación', 4, 1);
INSERT INTO materias (clave_materia, clave_asignatura, nombre, unidades, carrera_id) 
VALUES ('750D', 'CB225', 'Programación Web', 3, 1);
INSERT INTO materias (clave_materia, clave_asignatura, nombre, unidades, carrera_id) 
VALUES ('850F', 'CB231', 'Programación Web para Móviles', 3, 1);

INSERT INTO grupos (clave_grupo, ficha, clave_materia, grupo, periodo_nombre) 
VALUES ('1502-A', 1234, '1502', 'A', 'Primer Semestre 2023');
INSERT INTO grupos (clave_grupo, ficha, clave_materia, grupo, periodo_nombre) 
VALUES ('1502-D', 1234, '1502', 'D', 'Primer Semestre 2023');
INSERT INTO grupos (clave_grupo, ficha, clave_materia, grupo, periodo_nombre) 
VALUES ('750D-B', 5678, '750D', 'B', 'Primer Semestre 2023');
INSERT INTO grupos (clave_grupo, ficha, clave_materia, grupo, periodo_nombre) 
VALUES ('850F-A', 5678, '850F', 'A', 'Primer Semestre 2023');

INSERT INTO unidades (clave_grupo, numero_unidad, total_alumnos, alumnos_aprobados, alumnos_reprobados, alumnos_desertores, porcentaje_aprobacion, porcentaje_reprobacion, porcentaje_desercion, promedio_grupo, periodo_nombre)
VALUES ('1502-A', 1, 30, 20, 5, 5, 66.67, 16.67, 16.67, 85.4, 'Primer Semestre 2023');
INSERT INTO unidades (clave_grupo, numero_unidad, total_alumnos, alumnos_aprobados, alumnos_reprobados, alumnos_desertores, porcentaje_aprobacion, porcentaje_reprobacion, porcentaje_desercion, promedio_grupo, periodo_nombre)
VALUES ('1502-A', 2, 30, 28, 1, 1, 93.33, 3.33, 3.33, 9.2, 'Primer Semestre 2023');
INSERT INTO unidades (clave_grupo, numero_unidad, total_alumnos, alumnos_aprobados, alumnos_reprobados, alumnos_desertores, porcentaje_aprobacion, porcentaje_reprobacion, porcentaje_desercion, promedio_grupo, periodo_nombre) 
VALUES ('750D-B', 1, 25, 20, 4, 1, 80, 16, 4, 7.8, 'Primer Semestre 2023');
INSERT INTO unidades (clave_grupo, numero_unidad, total_alumnos, alumnos_aprobados, alumnos_reprobados, alumnos_desertores, porcentaje_aprobacion, porcentaje_reprobacion, porcentaje_desercion, promedio_grupo, periodo_nombre) 
VALUES ('850F-A', 1, 35, 30, 3, 2, 85.71, 8.57, 5.71, 8.9, 'Primer Semestre 2023');

INSERT INTO reportes (reporte, clave_grupo, numero_unidad)
VALUES ('Reporte Parcial 1', '1502-A', 1);
INSERT INTO reportes (reporte, clave_grupo, numero_unidad)
VALUES ('Reporte Parcial 1', '1502-A', 2);
INSERT INTO reportes (reporte, clave_grupo, numero_unidad)
VALUES ('Reporte Parcial 1', '750D-B', 1);
INSERT INTO reportes (reporte, clave_grupo, numero_unidad)
VALUES ('Reporte Parcial 1', '850F-A', 1);

INSERT INTO usuario (profesor_ficha, contraseña)
VALUES (1234, 'contraseña_profesor1');
INSERT INTO usuario (profesor_ficha, contraseña)
VALUES (5678, 'contraseña_profesor2');