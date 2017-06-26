INSERT INTO `rol_usuario` 
VALUES ('1', 'administrador');
INSERT INTO `rol_usuario` 
VALUES ('2', 'técnico');
INSERT INTO `rol_usuario` 
VALUES ('3', 'dirección');

INSERT INTO `rol_proyecto`
VALUES ('1', 'coordinador');
INSERT INTO `rol_proyecto`
VALUES ('2', 'técnico');

INSERT INTO `usuario` 
VALUES (1, 1, 'administrador', 'del', 'sistema', 'admin', SHA1('admin'));

INSERT INTO `tipo_financiador`
VALUES (1, 'financiador');
INSERT INTO `tipo_financiador`
VALUES (2, 'ejecutor');
INSERT INTO `tipo_financiador`
VALUES (3, 'otro');

INSERT INTO `financiador`
VALUES (1, "Fundación ATICA");