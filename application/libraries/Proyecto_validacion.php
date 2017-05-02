<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Proyecto_validacion
 *
 * @author Jose
 */
require_once 'Validacion.php';

class Proyecto_validacion extends Validacion {

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
		"objetivo" => array(
			"field" => "objetivo",
			"label" => "objetivo",
			"rules" => array(
				"min_length[1]"
			)
		),
		"fecha_inicio" => array(
			"field" => "fecha_inicio",
			"label" => "fecha de inicio",
			"rules" => array(
				"required",
				"date"
			)
		),
		"fecha_fin" => array(
			"field" => "fecha_fin",
			"label" => "fecha de fin",
			"rules" => array(
				"required",
				"date"
			)
		)
	);

}
