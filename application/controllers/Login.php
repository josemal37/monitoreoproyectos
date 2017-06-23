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

		$this->load->library(array("login_validacion"));
		$this->load->model(array("Modelo_usuario", "Modelo_rol"));
		$this->load->database("default");

		$this->clear_cache();
	}

	public function index() {
		$rol = $this->session->userdata("rol");

		switch ($rol) {
			case "":
				$this->cargar_vista_login();
				break;

			case "administrador":
				redirect(base_url("usuario/usuarios"));
				break;

			case "empleado":
				redirect(base_url("proyecto/proyectos"));
				break;

			case "dirección":
				redirect(base_url("proyecto/proyectos"));
				break;

			default:
				$this->cargar_vista_login();

				break;
		}
	}

	private function cargar_vista_login() {
		$datos = array();

		$datos["titulo"] = "Sistema de Monitoreo: Fundación Atica";
		$datos["token"] = $this->token();
		$datos["reglas_cliente"] = $this->login_validacion->get_reglas_cliente(array("login", "password"));

		$this->load->view("login/formulario_login", $datos);
	}

	public function iniciar_sesion() {
		if ($this->formulario_enviado()) {
			if ($this->login_validacion->validar(array("login", "password"))) {
				$login = $this->input->post("login");
				$password = $this->input->post("password");

				$usuario = $this->Modelo_usuario->select_usuario_por_login_password($login, $password);

				if ($usuario) {
					$datos = array(
						"id" => $usuario->id,
						"nombre_completo" => $usuario->nombre_completo,
						"rol" => $usuario->nombre_rol
					);
					$this->session->set_userdata($datos);

					$this->index();
				} else {
					$this->session->set_flashdata("error", "Los datos introducidos son incorrectos.");
					redirect(base_url("login"), "refresh");
				}
			} else {
				$this->index();
			}
		} else {
			redirect(base_url("login"));
		}
	}

	public function cerrar_sesion() {
		$this->session->sess_destroy();
		redirect(base_url());
	}

	private function formulario_enviado() {
		return isset($_POST["submit"]) && isset($_POST["token"]) && $this->input->post("token") == $this->session->userdata("token");
	}

	private function token() {
		$token = md5(uniqid(rand(), true));
		$this->session->set_userdata('token', $token);
		return $token;
	}

	private function clear_cache() {
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
	}

}
