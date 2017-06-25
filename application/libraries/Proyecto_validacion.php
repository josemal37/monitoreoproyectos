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
		),
		"instituciones-ejecutores" => array(
			"field" => "instituciones-ejecutores[]",
			"label" => "institución",
			"rules" => array(
				"required"
			)
		),
		"cantidades-ejecutores" => array(
			"field" => "cantidades-ejecutores[]",
			"label" => "cantidad",
			"rules" => array(
				"required",
				"numeric"
			)
		),
		"conceptos-ejecutores" => array(
			"field" => "conceptos-ejecutores[]",
			"label" => "conceptos",
			"rules" => array(
				"required"
			)
		),
		"instituciones-financiadores" => array(
			"field" => "instituciones-financiadores[]",
			"label" => "institución",
			"rules" => array(
				"required"
			)
		),
		"cantidades-financiadores" => array(
			"field" => "cantidades-financiadores[]",
			"label" => "cantidad",
			"rules" => array(
				"required",
				"numeric"
			)
		),
		"conceptos-financiadores" => array(
			"field" => "conceptos-financiadores[]",
			"label" => "conceptos",
			"rules" => array(
				"required"
			)
		),
		"instituciones-otros" => array(
			"field" => "instituciones-otros[]",
			"label" => "institución",
			"rules" => array(
				"required"
			)
		),
		"cantidades-otros" => array(
			"field" => "cantidades-otros[]",
			"label" => "cantidad",
			"rules" => array(
				"required",
				"numeric"
			)
		),
		"conceptos-otros" => array(
			"field" => "conceptos-otros[]",
			"label" => "conceptos",
			"rules" => array(
				"required"
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
		),
		"instituciones-ejecutores[]" => array(
			"required" => true
		),
		"cantidades-ejecutores[]" => array(
			"required" => true,
			"number" => true
		),
		"conceptos-ejecutores[]" => array(
			"required" => true
		),
		"instituciones-financiadores[]" => array(
			"required" => true
		),
		"cantidades-financiadores[]" => array(
			"required" => true,
			"number" => true
		),
		"conceptos-financiadores[]" => array(
			"required" => true
		),
		"instituciones-otros[]" => array(
			"required" => true
		),
		"cantidades-otros[]" => array(
			"required" => true,
			"number" => true
		),
		"conceptos-otros[]" => array(
			"required" => true
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
		),
		"instituciones-ejecutores[]" => array(
			"required" => "Por favor seleccione una institución."
		),
		"cantidades-ejecutores[]" => array(
			"required" => "Por favor introduzca una cantidad.",
			"number" => "La cantidad debe ser un número."
		),
		"conceptos-ejecutores[]" => array(
			"required" => "Por favor introduzca el concepto."
		),
		"instituciones-financiadores[]" => array(
			"required" => "Por favor seleccione una institución."
		),
		"cantidades-financiadores[]" => array(
			"required" => "Por favor introduzca una cantidad.",
			"number" => "La cantidad debe ser un número."
		),
		"conceptos-financiadores[]" => array(
			"required" => "Por favor introduzca el concepto."
		),
		"instituciones-otros[]" => array(
			"required" => "Por favor seleccione una institución."
		),
		"cantidades-otros[]" => array(
			"required" => "Por favor introduzca una cantidad.",
			"number" => "La cantidad debe ser un número."
		),
		"conceptos-otros[]" => array(
			"required" => "Por favor introduzca el concepto."
		)
	);

}
