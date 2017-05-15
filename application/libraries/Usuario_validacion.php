<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Usuario_validacion
 *
 * @author Jose
 */
require_once 'Validacion.php';

class Usuario_validacion extends Validacion {

	protected $reglas_validacion_ci = array(
		"id" => array(
			"field" => "id",
			"label" => "id",
			"rules" => array(
				"required",
				"numeric",
				"is_natural"
			)
		),
		"nombre" => array(
			"field" => "nombre",
			"label" => "nombre",
			"rules" => array(
				"required",
				"min_length[1]"
			)
		),
		"apellido_paterno" => array(
			"field" => "apellido_paterno",
			"label" => "apellido paterno",
			"rules" => array(
				"min_length[1]"
			)
		),
		"apellido_materno" => array(
			"field" => "apellido_materno",
			"label" => "apellido materno",
			"rules" => array(
				"min_length[1]"
			)
		),
		"login" => array(
			"field" => "login",
			"label" => "login",
			"rules" => array(
				"required",
				"min_length[5]"
			)
		),
		"password" => array(
			"field" => "password",
			"label" => "password",
			"rules" => array(
				"required",
				"min_length[5]"
			)
		),
		"confirmacion_password" => array(
			"field" => "confirmacion_password",
			"label" => "confirmación password",
			"rules" => array(
				"required",
				"min_length[5]",
				"matches[password]"
			)
		)
	);
	protected $jquery_validate = array(
		"id" => array(
			"required" => true,
			"number" => true
		),
		"rol" => array(
			"required" => true,
			"number" => true
		),
		"nombre" => array(
			"required" => true,
			"minlength" => 1
		),
		"apellido_paterno" => array(
			"minlength" => 1
		),
		"apellido_materno" => array(
			"minlength" => 1
		),
		"login" => array(
			"required" => true,
			"minlength" => 5
		),
		"password" => array(
			"required" => true,
			"minlength" => 5
		),
		"confirmacion_password" => array(
			"required" => true,
			"minlength" => 5,
			"equalTo" => "#password"
		),
		"password_anterior" => array(
			"required" => true
		)
	);
	protected $mensajes_jquery_validate = array(
		"id" => array(
			"required" => "Ocurrió un problema con la identificación del usuario.",
			"number" => "La identificación debe ser un número."
		),
		"rol" => array(
			"required" => "Por favor seleccione un rol.",
			"number" => "Ocurrió un error con el rol seleccionado."
		),
		"nombre" => array(
			"required" => "Por favor introduzca el nombre.",
			"minlength" => "El nombre debe tener al menos 1 caracter."
		),
		"apellido_paterno" => array(
			"minlength" => "El apellido paterno debe tener al menos 1 caracter."
		),
		"apellido_materno" => array(
			"minlength" => "El apellido materno debe tener al menos 1 caracter."
		),
		"login" => array(
			"required" => "Por favor introduzca el nombre de usuario.",
			"minlength" => "El nombre de usuario debe tener al menos 5 caracteres."
		),
		"password" => array(
			"required" => "Por favor introduzca la contraseña.",
			"minlength" => "La contraseña debe tener al menos 5 caracteres."
		),
		"confirmacion_password" => array(
			"required" => "Por favor confirme la contraseña introducida.",
			"minlength" => "La confirmación de la contraseña debe tener al menos 5 caracteres.",
			"equalTo" => "La confirmación no coincide."
		),
		"password_anterior" => array(
			"required" => "Por favor introduzca su contraseña anterior."
		)
	);

}
