<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Actividad_validacion
 *
 * @author Jose
 */
require_once 'Validacion.php';

class Actividad_validacion extends Validacion {
	
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
		"producto" => array(
			"field" => "producto",
			"label" => "producto",
			"rules" => array(
				"required",
				"numeric",
				"is_natural"
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
		"indicador-producto" => array(
			"field" => "indicador-producto",
			"label" => "indicador de producto",
			"rules" => array(
				"required",
				"numeric",
				"is_natural"
			)
		)
	);
	
	
	
}
