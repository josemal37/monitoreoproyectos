<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Empleado
 *
 * @author Jose
 */
class Empleado extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$this->bienvenida();
	}
	
	public function bienvenida() {
		$rol = $this->session->userdata("rol");
		
		if ($rol == "técnico") {
			$datos = array();
			
			$datos["titulo"] = "Bienvenido al sistema";
			
			$this->load->view("empleado/bienvenida", $datos);
		} else {
			redirect(base_url());
		}
	}
	
}
