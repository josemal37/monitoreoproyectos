<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Validacion
 *
 * @author Jose
 */
abstract class Validacion {

	protected $ci;
	protected $reglas_validacion_ci;
	protected $jquery_validate;
	protected $mensajes_jquery_validate;

	public function __construct() {
		$this->ci = & get_instance();
	}

	public function validar($campos = NULL) {
		if ($campos != NULL) {
			$this->set_delimitadores_ci();

			$this->set_reglas($campos);

			if ($this->ci->form_validation->run() === FALSE) {
				return FALSE;
			} else {
				return TRUE;
			}
		} else {
			return FALSE;
		}
	}

	private function set_reglas($campos) {

		$para_validar = $this->get_reglas($campos);

		$this->ci->form_validation->set_rules($para_validar);
	}

	public function get_reglas($campos) {
		$reglas = array();

		if (is_array($campos)) {
			foreach ($campos as $campo) {
				if (isset($this->reglas_validacion_ci[$campo])) {
					$reglas[] = $this->reglas_validacion_ci[$campo];
				}
			}
		} else if (is_string($campos)) {
			if (isset($this->reglas_validacion_ci[$campos])) {
				$reglas[] = $this->reglas_validacion_ci[$campos];
			}
		}

		return $reglas;
	}
	
	public function get_reglas_cliente($campos) {
		return $this->get_reglas_jquery_validate($campos);
	}
	
	private function get_reglas_jquery_validate($campos) {
		$reglas = "";
		
		if (is_array($campos)) {
			$seleccion = array();
			$seleccion_mensajes = array();
			
			foreach ($campos as $campo) {
				if (isset($this->jquery_validate[$campo])) {
					$seleccion[$campo] = $this->jquery_validate[$campo];
					$seleccion_mensajes[$campo] = $this->mensajes_jquery_validate[$campo];
				}
			}
			
			$reglas = json_encode(array("rules" => $seleccion, "messages" => $seleccion_mensajes));
		} else if (is_string($campos)) {
			if (isset($this->jquery_validate[$campos])) {
				$reglas = json_encode(array("rules" => array($campos => $this->jquery_validate[$campos]), "messages" => array($campos => $this->mensajes_jquery_validate[$campos])));
			}
		}
		
		return $reglas;
	}

	private function set_delimitadores_ci() {
		$this->ci->form_validation->set_error_delimiters('<label class="text-danger">', '</label>');
	}

}
