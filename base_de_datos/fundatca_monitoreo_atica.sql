CREATE TABLE `rol_usuario` (
  `id` INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `nombre` VARCHAR(1024)  NULL    ,
PRIMARY KEY(`id`))
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `rol_proyecto` (
  `id` INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `nombre` VARCHAR(1024)  NULL    ,
PRIMARY KEY(`id`))
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `proyecto` (
  `id` INTEGER  NOT NULL   AUTO_INCREMENT,
  `nombre` VARCHAR(1024)  NULL  ,
  `objetivo` TEXT  NULL  ,
  `fecha_inicio` DATE  NULL  ,
  `fecha_fin` DATE  NULL  ,
  `finalizado` BOOL  NULL    ,
PRIMARY KEY(`id`))
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `resultado` (
  `id` INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `id_proyecto` INTEGER  NOT NULL  ,
  `nombre` VARCHAR(1024)  NULL    ,
PRIMARY KEY(`id`)  ,
INDEX `resultado_FKIndex1`(`id_proyecto`),
  FOREIGN KEY(`id_proyecto`)
    REFERENCES `proyecto`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `actividad` (
  `id` INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `id_proyecto` INTEGER  NOT NULL  ,
  `nombre` VARCHAR(1024)  NULL  ,
  `fecha_inicio` DATE  NULL  ,
  `fecha_fin` DATE  NULL  ,
  `finalizada` BOOL  NULL    ,
PRIMARY KEY(`id`)  ,
INDEX `actividad_FKIndex1`(`id_proyecto`),
  FOREIGN KEY(`id_proyecto`)
    REFERENCES `proyecto`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `usuario` (
  `id` INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `id_rol_usuario` INTEGER UNSIGNED  NOT NULL  ,
  `nombre` VARCHAR(1024)  NULL  ,
  `apellido_paterno` VARCHAR(1024)  NULL  ,
  `apellido_materno` VARCHAR(1024)  NULL  ,
  `login` VARCHAR(1024)  NULL  ,
  `passwd` VARCHAR(1024)  NULL    ,
PRIMARY KEY(`id`)  ,
INDEX `usuario_FKIndex1`(`id_rol_usuario`),
  FOREIGN KEY(`id_rol_usuario`)
    REFERENCES `rol_usuario`(`id`)
      ON DELETE RESTRICT
      ON UPDATE RESTRICT)
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `resultado_clave` (
  `id` INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `id_resultado` INTEGER UNSIGNED  NOT NULL  ,
  `descripcion` TEXT  NULL  ,
  `conseguido` BOOL  NULL    ,
PRIMARY KEY(`id`)  ,
INDEX `resultado_clave_FKIndex1`(`id_resultado`),
  FOREIGN KEY(`id_resultado`)
    REFERENCES `resultado`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `indicador_impacto` (
  `id` INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `id_proyecto` INTEGER  NOT NULL  ,
  `descripcion` TEXT  NULL    ,
PRIMARY KEY(`id`)  ,
INDEX `indicador_impacto_FKIndex1`(`id_proyecto`),
  FOREIGN KEY(`id_proyecto`)
    REFERENCES `proyecto`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `efecto` (
  `id` INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `id_resultado` INTEGER UNSIGNED  NOT NULL  ,
  `descripcion` TEXT  NULL    ,
PRIMARY KEY(`id`)  ,
INDEX `efecto_FKIndex1`(`id_resultado`),
  FOREIGN KEY(`id_resultado`)
    REFERENCES `resultado`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `indicador_efecto` (
  `id` INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `id_efecto` INTEGER UNSIGNED  NOT NULL  ,
  `descripcion` TEXT  NULL    ,
PRIMARY KEY(`id`)  ,
INDEX `indicador_efecto_FKIndex1`(`id_efecto`),
  FOREIGN KEY(`id_efecto`)
    REFERENCES `efecto`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `indicador_efecto_impacto` (
  `id_indicador_efecto` INTEGER UNSIGNED  NOT NULL  ,
  `id_indicador_impacto` INTEGER UNSIGNED  NOT NULL  ,
  `porcentaje` DOUBLE  NOT NULL    ,
INDEX `indicador_efecto_impacto_FKIndex1`(`id_indicador_impacto`)  ,
INDEX `indicador_efecto_impacto_FKIndex2`(`id_indicador_efecto`),
  FOREIGN KEY(`id_indicador_impacto`)
    REFERENCES `indicador_impacto`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(`id_indicador_efecto`)
    REFERENCES `indicador_efecto`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `proyecto_usuario` (
  `id_usuario` INTEGER UNSIGNED  NOT NULL  ,
  `id_proyecto` INTEGER  NOT NULL  ,
  `id_rol_proyecto` INTEGER UNSIGNED  NOT NULL    ,
PRIMARY KEY(`id_usuario`, `id_proyecto`)  ,
INDEX `proyecto_usuario_FKIndex1`(`id_usuario`)  ,
INDEX `proyecto_usuario_FKIndex2`(`id_proyecto`)  ,
INDEX `proyecto_usuario_FKIndex3`(`id_rol_proyecto`),
  FOREIGN KEY(`id_usuario`)
    REFERENCES `usuario`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(`id_proyecto`)
    REFERENCES `proyecto`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(`id_rol_proyecto`)
    REFERENCES `rol_proyecto`(`id`)
      ON DELETE RESTRICT
      ON UPDATE RESTRICT)
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `meta_actividad` (
  `id` INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `id_actividad` INTEGER UNSIGNED  NOT NULL  ,
  `unidad` VARCHAR(1024)  NOT NULL  ,
  `cantidad` INTEGER UNSIGNED  NULL    ,
PRIMARY KEY(`id`)  ,
INDEX `meta_actividad_FKIndex1`(`id_actividad`),
  FOREIGN KEY(`id_actividad`)
    REFERENCES `actividad`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `meta_impacto` (
  `id` INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `id_indicador_impacto` INTEGER UNSIGNED  NOT NULL  ,
  `cantidad` INTEGER UNSIGNED  NULL  ,
  `unidad` VARCHAR(1024)  NULL    ,
PRIMARY KEY(`id`)  ,
INDEX `meta_impacto_FKIndex1`(`id_indicador_impacto`),
  FOREIGN KEY(`id_indicador_impacto`)
    REFERENCES `indicador_impacto`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `producto` (
  `id` INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `id_efecto` INTEGER UNSIGNED  NOT NULL  ,
  `descripcion` VARCHAR(1024)  NULL    ,
PRIMARY KEY(`id`)  ,
INDEX `producto_FKIndex1`(`id_efecto`),
  FOREIGN KEY(`id_efecto`)
    REFERENCES `efecto`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `punto_clave` (
  `id` INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `id_actividad` INTEGER UNSIGNED  NOT NULL  ,
  `descripcion` TEXT  NULL  ,
  `tipo` BOOL  NULL    ,
PRIMARY KEY(`id`)  ,
INDEX `punto_clave_FKIndex1`(`id_actividad`),
  FOREIGN KEY(`id_actividad`)
    REFERENCES `actividad`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `meta_indicador_efecto` (
  `id` INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `id_indicador_efecto` INTEGER UNSIGNED  NOT NULL  ,
  `cantidad` INTEGER UNSIGNED  NULL  ,
  `unidad` VARCHAR(1024)  NULL    ,
PRIMARY KEY(`id`)  ,
INDEX `meta_indicador_efecto_FKIndex1`(`id_indicador_efecto`),
  FOREIGN KEY(`id_indicador_efecto`)
    REFERENCES `indicador_efecto`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `avance` (
  `id` INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `id_actividad` INTEGER UNSIGNED  NOT NULL  ,
  `cantidad` INTEGER UNSIGNED  NULL    ,
  `descripcion` TEXT NULL,
  `fecha` DATE NULL,
PRIMARY KEY(`id`)  ,
INDEX `avance_FKIndex1`(`id_actividad`),
  FOREIGN KEY(`id_actividad`)
    REFERENCES `actividad`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `documento_actividad` (
  `id` INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `id_actividad` INTEGER UNSIGNED  NOT NULL  ,
  `nombre` VARCHAR(1024)  NULL  ,
  `documento` VARCHAR(1024)  NULL    ,
PRIMARY KEY(`id`)  ,
INDEX `documento_actividad_FKIndex1`(`id_actividad`),
  FOREIGN KEY(`id_actividad`)
    REFERENCES `actividad`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `documento_avance` (
  `id` INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `id_avance` INTEGER UNSIGNED  NOT NULL  ,
  `nombre` VARCHAR(1024)  NULL  ,
  `documento` VARCHAR(1024)  NULL    ,
PRIMARY KEY(`id`)  ,
INDEX `documento_avance_FKIndex1`(`id_avance`),
  FOREIGN KEY(`id_avance`)
    REFERENCES `avance`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `actividad_usuario` (
  `id_actividad` INTEGER UNSIGNED  NOT NULL  ,
  `id_proyecto` INTEGER  NOT NULL  ,
  `id_usuario` INTEGER UNSIGNED  NOT NULL    ,
PRIMARY KEY(`id_actividad`, `id_proyecto`, `id_usuario`)  ,
INDEX `usuario_actividad_FKIndex2`(`id_actividad`)  ,
INDEX `actividad_usuario_FKIndex2`(`id_usuario`, `id_proyecto`),
  FOREIGN KEY(`id_actividad`)
    REFERENCES `actividad`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(`id_usuario`, `id_proyecto`)
    REFERENCES `proyecto_usuario`(`id_usuario`, `id_proyecto`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `actividad_producto` (
  `id_actividad` INTEGER UNSIGNED  NOT NULL  ,
  `id_producto` INTEGER UNSIGNED  NOT NULL    ,
INDEX `actividad_producto_FKIndex1`(`id_actividad`)  ,
INDEX `actividad_producto_FKIndex2`(`id_producto`),
  FOREIGN KEY(`id_actividad`)
    REFERENCES `actividad`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(`id_producto`)
    REFERENCES `producto`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `indicador_producto` (
  `id` INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `id_producto` INTEGER UNSIGNED  NOT NULL  ,
  `descripcion` TEXT  NULL    ,
PRIMARY KEY(`id`)  ,
INDEX `indicador_producto_FKIndex1`(`id_producto`),
  FOREIGN KEY(`id_producto`)
    REFERENCES `producto`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `meta_indicador_producto` (
  `id` INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `id_indicador_producto` INTEGER UNSIGNED  NOT NULL  ,
  `cantidad` INTEGER UNSIGNED  NULL  ,
  `unidad` VARCHAR(1024)  NULL    ,
PRIMARY KEY(`id`)  ,
INDEX `meta_indicador_producto_FKIndex1`(`id_indicador_producto`),
  FOREIGN KEY(`id_indicador_producto`)
    REFERENCES `indicador_producto`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `actividad_indicador_producto` (
  `id_indicador_producto` INTEGER UNSIGNED  NOT NULL  ,
  `id_actividad` INTEGER UNSIGNED  NOT NULL  ,
  `porcentaje` DOUBLE  NULL    ,
INDEX `actividad_indicador_producto_FKIndex1`(`id_actividad`)  ,
INDEX `actividad_indicador_producto_FKIndex2`(`id_indicador_producto`),
  FOREIGN KEY(`id_actividad`)
    REFERENCES `actividad`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(`id_indicador_producto`)
    REFERENCES `indicador_producto`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `indicador_producto_efecto` (
  `id_indicador_producto` INTEGER UNSIGNED  NOT NULL  ,
  `id_indicador_efecto` INTEGER UNSIGNED  NOT NULL  ,
  `porcentaje` DOUBLE  NULL    ,
INDEX `indicador_producto_efecto_FKIndex1`(`id_indicador_efecto`)  ,
INDEX `indicador_producto_efecto_FKIndex2`(`id_indicador_producto`),
  FOREIGN KEY(`id_indicador_efecto`)
    REFERENCES `indicador_efecto`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(`id_indicador_producto`)
    REFERENCES `indicador_producto`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE 
VIEW `avance_actividad`AS 
SELECT
	`actividad`.`id` AS `id_actividad`,
	ROUND(
		COALESCE (SUM(`avance`.`cantidad`), 0),
		3
	) AS `avance_acumulado`
FROM
	`actividad`
LEFT JOIN `avance` ON `avance`.`id_actividad` = `actividad`.`id`
GROUP BY
	`actividad`.`id`   ;



CREATE 
VIEW `avance_indicador_producto`AS 
SELECT
	`indicador_producto`.`id` AS `id_indicador_producto`,
	ROUND(
		COALESCE (
			(
				SUM(
					(
						`avance_actividad`.`avance_acumulado` / `meta_actividad`.`cantidad`
					) * (
						`actividad_indicador_producto`.`porcentaje`
					)
				) / 100
			) * `meta_indicador_producto`.`cantidad`,
			0
		),
		3
	) AS `avance_acumulado`
FROM
	`indicador_producto`
LEFT JOIN `meta_indicador_producto` ON `meta_indicador_producto`.`id_indicador_producto` = `indicador_producto`.`id`
LEFT JOIN `actividad_indicador_producto` ON `actividad_indicador_producto`.`id_indicador_producto` = `indicador_producto`.`id`
LEFT JOIN `avance_actividad` ON `avance_actividad`.`id_actividad` = `actividad_indicador_producto`.`id_actividad`
LEFT JOIN `meta_actividad` ON `meta_actividad`.`id_actividad` = `actividad_indicador_producto`.`id_actividad`
GROUP BY
	`indicador_producto`.`id` ;



CREATE 
VIEW `avance_indicador_efecto`AS 
SELECT
	`indicador_efecto`.`id` AS `id_indicador_efecto`,
	ROUND(
		COALESCE (
			(
				SUM(
					(
						`avance_indicador_producto`.`avance_acumulado` / `meta_indicador_producto`.`cantidad`
					) * (
						`indicador_producto_efecto`.`porcentaje`
					)
				) / 100
			) * `meta_indicador_efecto`.`cantidad`,
			0
		),
		3
	) AS `avance_acumulado`
FROM
	`indicador_efecto`
LEFT JOIN `meta_indicador_efecto` ON `meta_indicador_efecto`.`id_indicador_efecto` = `indicador_efecto`.`id`
LEFT JOIN `indicador_producto_efecto` ON `indicador_producto_efecto`.`id_indicador_efecto` = `indicador_efecto`.`id`
LEFT JOIN `avance_indicador_producto` ON `avance_indicador_producto`.`id_indicador_producto` = `indicador_producto_efecto`.`id_indicador_producto`
LEFT JOIN `meta_indicador_producto` ON `meta_indicador_producto`.`id_indicador_producto` = `indicador_producto_efecto`.`id_indicador_producto`
GROUP BY
	`indicador_efecto`.`id` ;



CREATE 
VIEW `avance_indicador_impacto`AS 
SELECT
	`indicador_impacto`.`id` AS `id_indicador_impacto`,
	ROUND(
		COALESCE (
			(
				SUM(
					(
						`avance_indicador_efecto`.`avance_acumulado` / `meta_indicador_efecto`.`cantidad`
					) * (
						`indicador_efecto_impacto`.`porcentaje`
					)
				) / 100
			) * `meta_impacto`.`cantidad`,
			0
		),
		3
	) AS `avance_acumulado`
FROM
	`indicador_impacto`
LEFT JOIN `meta_impacto` ON `meta_impacto`.`id_indicador_impacto` = `indicador_impacto`.`id`
LEFT JOIN `indicador_efecto_impacto` ON `indicador_efecto_impacto`.`id_indicador_impacto` = `indicador_impacto`.`id`
LEFT JOIN `indicador_efecto` ON `indicador_efecto`.`id` = `indicador_efecto_impacto`.`id_indicador_efecto`
LEFT JOIN `meta_indicador_efecto` ON `meta_indicador_efecto`.`id_indicador_efecto` = `indicador_efecto`.`id`
LEFT JOIN `avance_indicador_efecto` ON `avance_indicador_efecto`.`id_indicador_efecto` = `indicador_efecto`.`id`
GROUP BY
	`indicador_impacto`.`id` ;



CREATE 
VIEW `porcentaje_acumulado_indicador_impacto`AS 
SELECT
	`indicador_impacto`.`id` AS `id_indicador_impacto`,
	COALESCE (
		SUM(
			`indicador_efecto_impacto`.`porcentaje`
		),
		0
	) AS `porcentaje_acumulado`
FROM
	`indicador_impacto`
LEFT JOIN `indicador_efecto_impacto` ON `indicador_efecto_impacto`.`id_indicador_impacto` = `indicador_impacto`.`id`
GROUP BY
	`indicador_impacto`.`id` ;



CREATE 
VIEW `porcentaje_acumulado_indicador_efecto`AS 
SELECT
	`indicador_efecto`.`id` AS `id_indicador_efecto`,
	COALESCE (
		SUM(
			`indicador_producto_efecto`.`porcentaje`
		),
		0
	) AS `porcentaje_acumulado`
FROM
	`indicador_efecto`
LEFT JOIN `indicador_producto_efecto` ON `indicador_producto_efecto`.`id_indicador_efecto` = `indicador_efecto`.`id`
GROUP BY
	`indicador_efecto`.`id` ;



CREATE 
VIEW `porcentaje_acumulado_indicador_producto`AS 
SELECT
	`indicador_producto`.`id` AS `id_indicador_producto`,
	COALESCE (
		SUM(
			`actividad_indicador_producto`.`porcentaje`
		),
		0
	) AS `porcentaje_acumulado`
FROM
	`indicador_producto`
LEFT JOIN `actividad_indicador_producto` ON `actividad_indicador_producto`.`id_indicador_producto` = `indicador_producto`.`id`
GROUP BY
	`indicador_producto`.`id` ;
