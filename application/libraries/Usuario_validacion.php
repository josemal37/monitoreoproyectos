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
			"label" => "confirmacion_password",
			"rules" => array(
				"required",
				"min_length[5]",
				"matches[password]"
			)
		)
	);

}
