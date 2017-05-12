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
	protected $jquery_validate = array(
		"id" => array(
			"required" => true,
			"number" => true
		),
		"nombre" => array(
			"required" => true,
			"minlength" => 1
		),
		"objetivo" => array(
			"minlength" => 1
		),
		"fecha_inicio" => array(
			"required" => true,
			"date" => true
		),
		"fecha_fin" => array(
			"required" => true,
			"date" => true
		)
	);
	protected $mensajes_jquery_validate = array(
		"id" => array(
			"required" => "Ocurrió un error con la identificación del proyecto.",
			"number" => "El id debe ser un número."
		),
		"nombre" => array(
			"required" => "Por favor introduzca un nombre.",
			"minlength" => "La cantidad mínina de caracteres es de 1."
		),
		"objetivo" => array(
			"minlength" => "La cantidad mínina de caracteres es de 1."
		),
		"fecha_inicio" => array(
			"required" => "Por favor introduzca una fecha de inicio.",
			"date" => "Por favor introduzca una fecha valida."
		),
		"fecha_fin" => array(
			"required" => "Por favor introduzca una fecha de fin.",
			"date" => "Por favor introduzca una fecha valida."
		)
	);

}