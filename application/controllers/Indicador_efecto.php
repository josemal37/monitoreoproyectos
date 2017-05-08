<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Indicador_efecto
 *
 * @author Jose
 */
class Indicador_efecto extends Coordinador {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function registrar_indicador_efecto($id_proyecto = FALSE, $id_efecto = FALSE) {
		$rol = $this->session->userdata("rol");
		
		if ($rol == "empleado") {
			
		}
	}
	
}
