<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Financiador
 *
 * @author Jose
 */
class Financiador extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model(array(
			"Modelo_financiador"
		));

		$this->load->library(array("Item_validacion"));

		$this->load->database("default");
	}

	public function financiadores() {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador") {
			$this->cargar_vista_financiadores();
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_financiadores() {
		$titulo = "Financiadores";
		$financiadores = $this->Modelo_financiador->select_financiadores();

		$datos = array();
		$datos["titulo"] = $titulo;
		$datos["financiadores"] = $financiadores;

		$this->load->view("financiador/financiadores", $datos);
	}

	public function registrar_financiador() {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador") {
			if (isset($_POST["submit"])) {
				$this->registrar_financiador_db();
			} else {
				$this->cargar_vista_registrar_financiador();
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_registrar_financiador() {
		$titulo = "Registrar financiador";
		$reglas_cliente = $this->item_validacion->get_reglas_cliente(array("nombre"));

		$datos = array();

		$datos["titulo"] = $titulo;
		$datos["reglas_cliente"] = $reglas_cliente;

		$this->load->view("financiador/formulario_financiador", $datos);
	}

	private function registrar_financiador_db() {
		$nombre = $this->input->post("nombre");

		if ($this->item_validacion->validar(array("nombre"))) {
			if ($this->Modelo_financiador->insert_financiador($nombre)) {
				redirect(base_url("financiador/financiadores"));
			} else {
				redirect(base_url("financiador/registrar_financiador"), "refresh");
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_financiador();
		}
	}

}
