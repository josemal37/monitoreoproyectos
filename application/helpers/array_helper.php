<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function search_object_in_array_by_key($object = FALSE, $array = FALSE, $key = FALSE) {
	$exist = FALSE;

	if ($object && $array && $key && is_array($array) && property_exists($object, $key)) {

		foreach ($array as $i => $current) {
			if (property_exists($current, $key)) {
				if ($object->$key == $current->$key) {
					$exist = TRUE;
					break;
				}
			}
		}
	}

	return $exist;
}

function is_value_in_array($value, $array = FALSE, $key = FALSE) {
	$exist = FALSE;

	if ($array && is_array($array)) {

		if ($key) {
			$object = new stdClass();
			$object->$key = $value;
			$exist = search_object_in_array_by_key($object, $array, $key);
		} else {
			foreach ($array as $a) {
				if ($a == $value) {
					$exist = TRUE;
					break;
				}
			}
		}
	}

	return $exist;
}

function eliminar_elementos_array(&$array, $elementos, $key) {
	if ($array && $elementos) {
		foreach ($elementos as $elemento) {
			$i = search_object_in_array_by_key($elemento, $array, "id");
			if ($i !== FALSE) {
				unset($array[$i]);
			}
		}
	}
}

function listar_array_de_stdclass($array = FALSE, $parametro = FALSE, $separador = FALSE) {
	$cadena = "";
	if ($array && is_array($array) && $parametro && $separador) {
		$array_basico = array();

		foreach ($array as $elem) {
			$array_basico[] = $elem->$parametro;
		}

		$cadena = implode($separador, $array_basico);
	}

	return $cadena;
}
