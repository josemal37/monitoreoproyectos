<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Item_validacion
 *
 * @author Jose
 */
require_once 'Validacion.php';

class Item_validacion extends Validacion {

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
		"id_proyecto" => array(
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
		"descripcion" => array(
			"field" => "descripcion",
			"label" => "descripción",
			"rules" => array(
				"required",
				"min_length[1]"
			)
		),
		"cantidad" => array(
			"field" => "cantidad",
			"label" => "cantidad",
			"rules" => array(
				"required",
				"numeric",
				"is_natural"
			)
		),
		"unidad" => array(
			"field" => "unidad",
			"label" => "unidad",
			"rules" => array(
				"required",
				"min_length[1]"
			)
		),
		"porcentaje" => array(
			"field" => "porcentaje",
			"label" => "porcentaje",
			"rules" => array(
				"required",
				"greater_than[0]",
				"less_than_equal_to[100]"
			)
		),
		"indicador-impacto" => array(
			"field" => "indicador-impacto",
			"label" => "indicador de impacto",
			"rules" => array(
				"required",
				"numeric",
				"is_natural"
			)
		),
		"indicador-efecto" => array(
			"field" => "indicador-efecto",
			"label" => "indicador de efecto",
			"rules" => array(
				"required",
				"numeric",
				"is_natural"
			)
		)
	);
	protected $jquery_validate = array(
		"id" => array(
			"required" => true,
			"number" => true
		),
		"id_proyecto" => array(
			"required" => true,
			"number" => true
		),
		"nombre" => array(
			"required" => true,
			"minlength" => true
		),
		"descripcion" => array(
			"required" => true,
			"minlength" => 1
		),
		"cantidad" => array(
			"required" => true,
			"number" => true
		),
		"unidad" => array(
			"required" => true,
			"minlength" => 1
		),
		"porcentaje"=>array(
			"required"=>true,
			"number"=>true,
			"range"=>[1, 100]
		),
		"indicador-impacto" => array(
			"required" => true,
			"number" => true
		),
		"indicador-efecto" => array(
			"required" => true,
			"number" => true
		)
	);
	protected $mensajes_jquery_validate = array(
		"id" => array(
			"required" => "Ocurrió un error con la identificación.",
			"number" => "El id debe ser un número."
		),
		"id_proyecto" => array(
			"required" => "Ocurrió un error con la identificación del proyecto.",
			"number" => "El id debe ser un número."
		),
		"nombre" => array(
			"required" => "Por favor introduzca un nombre.",
			"minlength" => "La cantidad mínina de caracteres es de 1."
		),
		"descripcion" => array(
			"required" => "Por favor introduzca una descripción.",
			"minlength" => "La cantidad mínina de caracteres es de 1."
		),
		"cantidad" => array(
			"required" => "Por favor introduzca la cantidad.",
			"number" => "La cantidad debe ser un número.",
		),
		"unidad" => array(
			"required" => "Por favor introduzca la unidad.",
			"minlength" => "La cantidad mínina de caracteres es de 1."
		),
		"porcentaje"=>array(
			"required"=>"Por favor introduzca el porcentaje.",
			"number"=>"El porcentaje debe ser un número.",
			"range"=>"El porcentaje debe estar entre 1 y 100."
		),
		"indicador-impacto" => array(
			"required" => "Ocurrió un error con la identificación del indicador de impacto.",
			"number" => "El indicador de impacto debe ser un número."
		),
		"indicador-efecto" => array(
			"required" => "Ocurrió un error con la identificación del indicador de efecto.",
			"number" => "El indicador de efecto debe ser un número."
		)
	);

}
