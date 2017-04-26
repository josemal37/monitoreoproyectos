<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Administrador
 *
 * @author Jose
 */
class Administrador extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->bienvenida();
	}

	public function bienvenida() {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador") {
			$datos = array();
			
			$datos["titulo"] = "Bienvenido administrador";
			
			$this->load->view("administrador/bienvenida", $datos);
		} else {
			redirect(base_url());
		}
	}

}
