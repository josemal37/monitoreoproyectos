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

	private function set_delimitadores_ci() {
		$this->ci->form_validation->set_error_delimiters('<label class="text-danger">', '</label>');
	}

}
