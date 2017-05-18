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
			"minlength" => 1
		),
		"fecha_inicio" => array(
			"required" => true,
			"date" => true
		),
		"fecha_fin" => array(
			"required" => true,
			"date" => true
		),
		"cantidad" => array(
			"required" => true,
			"number" => true
		),
		"unidad" => array(
			"required" => true,
			"minlength" => 1
		),
		"producto" => array(
			"required" => true,
			"number" => true
		),
		"porcentaje" => array(
			"required" => true,
			"number" => true,
			"range" => [1, 100]
		),
		"indicador-producto" => array(
			"required" => true,
			"number" => true
		)
	);
	protected $mensajes_jquery_validate = array(
		"id" => array(
			"required" => "Ocurrió un error con la identificación.",
			"number" => "La identificación debe ser un número."
		),
		"id_proyecto" => array(
			"required" => "Ocurrió un error con la identificación.",
			"number" => "La identificación debe ser un número."
		),
		"nombre" => array(
			"required" => "Por favor introduzca el nombre.",
			"minlength" => "El nombre debe tener al menos 1 caracter."
		),
		"fecha_inicio" => array(
			"required" => "Por favor introduzca la fecha de inicio.",
			"date" => "Por favor introduzca una fecha valida."
		),
		"fecha_fin" => array(
			"required" => "Por favor introduzca la fecha de fin.",
			"date" => "Por favor introduzca una fecha valida."
		),
		"cantidad" => array(
			"required" => "Por favor introduzca la cantidad.",
			"number" => "La cantidad debe ser un número."
		),
		"unidad" => array(
			"required" => "Por favor introduzca la unidad.",
			"minlength" => "La unidad debe tener al menos 1 caracter."
		),
		"producto" => array(
			"required" => "Por favor seleccione un producto..",
			"number" => "La identificación debe ser un número."
		),
		"porcentaje" => array(
			"required" => "Por favor introduzca el porcentaje.",
			"number" => "El porcentaje debe ser un número.",
			"range" => "El porcentaje debe estar entre 1 y 100."
		),
		"indicador-producto" => array(
			"required" => "Por favor seleccione un indicador de producto.",
			"number" => "La indentificación debe ser un número."
		)
	);

}
