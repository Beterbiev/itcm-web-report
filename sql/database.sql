CREATE DATABASE residencias_basedatos;

USE residencias_basedatos;

CREATE TABLE materias (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(255) NOT NULL,
  unidades INT NOT NULL,
  UNIQUE (nombre)
);

CREATE TABLE grupos (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(255) NOT NULL,
  UNIQUE (nombre)
);

CREATE TABLE reportes (
  id INT PRIMARY KEY AUTO_INCREMENT,
  materia_id INT,
  grupo_id INT,
  unidad INT,
  total_alumnos INT,
  alumnos_aprobados INT,
  alumnos_reprobados INT,
  alumnos_desertores INT,
  porcentaje_aprobacion FLOAT,
  porcentaje_reprobacion FLOAT,
  porcentaje_desercion FLOAT,
  promedio_grupo FLOAT,
  FOREIGN KEY (materia_id) REFERENCES materias(id),
  FOREIGN KEY (grupo_id) REFERENCES grupos(id)
);

INSERT INTO materias (nombre, unidades) VALUES ('Fundamentos de Programación', 5);
INSERT INTO materias (nombre, unidades) VALUES ('Programación Web', 4);
INSERT INTO materias (nombre, unidades) VALUES ('Programación Web para Móviles', 3);

INSERT INTO grupos (nombre) VALUES ('1502-A');
INSERT INTO grupos (nombre) VALUES ('1502-D');
INSERT INTO grupos (nombre) VALUES ('750D-B');
INSERT INTO grupos (nombre) VALUES ('850F-A');

INSERT INTO reportes (materia_id, grupo_id, unidad, total_alumnos, alumnos_aprobados, alumnos_reprobados, alumnos_desertores, porcentaje_aprobacion, porcentaje_reprobacion, porcentaje_desercion, promedio_grupo)
VALUES (1, 1, 1, 30, 25, 5, 0, 83.33, 16.67, 0, 8.75);

INSERT INTO reportes (materia_id, grupo_id, unidad, total_alumnos, alumnos_aprobados, alumnos_reprobados, alumnos_desertores, porcentaje_aprobacion, porcentaje_reprobacion, porcentaje_desercion, promedio_grupo)
VALUES (1, 2, 1, 35, 28, 7, 0, 80, 20, 0, 8.9);

INSERT INTO reportes (materia_id, grupo_id, unidad, total_alumnos, alumnos_aprobados, alumnos_reprobados, alumnos_desertores, porcentaje_aprobacion, porcentaje_reprobacion, porcentaje_desercion, promedio_grupo)
VALUES (2, 3, 1, 25, 20, 5, 0, 80, 20, 0, 9.2);

INSERT INTO reportes (materia_id, grupo_id, unidad, total_alumnos, alumnos_aprobados, alumnos_reprobados, alumnos_desertores, porcentaje_aprobacion, porcentaje_reprobacion, porcentaje_desercion, promedio_grupo)
VALUES (3, 4, 1, 20, 15, 5, 0, 75, 25, 0, 8.5);

SELECT * FROM materias;
SELECT * FROM grupos;
SELECT * FROM reportes;
