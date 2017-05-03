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



CREATE TABLE `rol_usuario` (
  `id` INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `nombre` VARCHAR(1024)  NULL    ,
PRIMARY KEY(`id`))
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



CREATE TABLE `proyecto_usuario` (
  `id_usuario` INTEGER UNSIGNED  NOT NULL  ,
  `id_proyecto` INTEGER  NOT NULL  ,
  `id_rol_proyecto` INTEGER UNSIGNED  NOT NULL    ,
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



CREATE TABLE `resultado_clave` (
  `id` INTEGER UNSIGNED  NOT NULL  ,
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



CREATE TABLE `meta_impacto` (
  `id` INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `id_indicador_impacto` INTEGER UNSIGNED  NOT NULL  ,
  `cantidad` INTEGER UNSIGNED  NULL   ,
  `unidad` VARCHAR(1024)  NULL    ,
PRIMARY KEY(`id`)  ,
INDEX `meta_impacto_FKIndex1`(`id_indicador_impacto`),
  FOREIGN KEY(`id_indicador_impacto`)
    REFERENCES `indicador_impacto`(`id`)
      ON DELETE CASCADE
      ON UPDATE CASCADE)
engine = innodb default character set = utf8 collate = utf8_general_ci;



CREATE TABLE `avance` (
  `id` INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  `id_actividad` INTEGER UNSIGNED  NOT NULL  ,
  `cantidad` INTEGER UNSIGNED  NULL    ,
PRIMARY KEY(`id`)  ,
INDEX `avance_FKIndex1`(`id_actividad`),
  FOREIGN KEY(`id_actividad`)
    REFERENCES `actividad`(`id`)
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



CREATE TABLE `actividad_indicador_producto` (
  `id_indicador_producto` INTEGER UNSIGNED  NOT NULL  ,
  `id_actividad` INTEGER UNSIGNED  NOT NULL    ,
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



CREATE TABLE `indicador_efecto_impacto` (
  `id_indicador_efecto` INTEGER UNSIGNED  NOT NULL  ,
  `id_indicador_impacto` INTEGER UNSIGNED  NOT NULL  ,
  `porcentaje` DOUBLE  NOT NULL   ,
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




