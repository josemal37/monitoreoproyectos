<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Login_validacion
 *
 * @author Jose
 */
require_once 'Validacion.php';

class Login_validacion extends Validacion {

	protected $reglas_validacion_ci = array(
		"login" => array(
			"field" => "login",
			"label" => "login",
			"rules" => array(
				"required"
			)
		),
		"password" => array(
			"field" => "password",
			"label" => "password",
			"rules" => array(
				"required"
			)
		)
	);
	protected $jquery_validate = array(
		"login" => array(
			"required" => true
		),
		"password" => array(
			"required" => true
		)
	);
	protected $mensajes_jquery_validate = array(
		"login" => array(
			"required" => "Por favor introduzca su nombre de usuario."
		),
		"password" => array(
			"required" => "Por favor introduzca su contraseña."
		)
	);

}
