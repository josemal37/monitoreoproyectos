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
		)
	);

}
