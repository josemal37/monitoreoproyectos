INSERT INTO `rol_usuario` 
VALUES ('1', 'administrador');
INSERT INTO `rol_usuario` 
VALUES ('2', 'empleado');
INSERT INTO `rol_usuario` 
VALUES ('3', 'dirección');

INSERT INTO `rol_proyecto`
VALUES ('1', 'coordinador');
INSERT INTO `rol_proyecto`
VALUES ('2', 'empleado');

INSERT INTO `usuario` 
VALUES (1, 1, 'administrador', 'del', 'sistema', 'admin', SHA1('admin'));