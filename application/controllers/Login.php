<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Login
 *
 * @author Jose
 */
class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$datos = array();
		
		$datos["titulo"] = "Sistema de Monitoreo - Fundación Atica";
		
		$this->load->view("login/formulario_login", $datos);
	}

}
