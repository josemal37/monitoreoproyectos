<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Usuario
 *
 * @author Jose
 */
class Usuario extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model(array("Modelo_usuario", "Modelo_rol"));
		$this->load->library(array("Usuario_validacion"));
		$this->load->database("default");
	}

	public function index() {
		$this->usuarios();
	}

	public function usuarios() {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador") {
			$this->cargar_vista_usuarios();
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_usuarios() {
		$titulo = "Usuarios del sistema";
		$usuarios = $this->Modelo_usuario->select_usuarios();

		$datos = array();
		$datos["titulo"] = $titulo;
		$datos["usuarios"] = $usuarios;

		$this->load->view("usuario/usuarios", $datos);
	}

	public function registrar_usuario() {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador") {
			if (isset($_POST["submit"])) {
				$this->registrar_usuario_bd();
			} else {
				$this->cargar_vista_registrar_usuario();
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_registrar_usuario() {
		$titulo = "Registrar usuario";
		$roles = $this->Modelo_rol->select_roles();
		$reglas_cliente = $this->usuario_validacion->get_reglas_cliente(array("nombre", "apellido_paterno", "apellido_materno", "login", "password", "confirmacion_password", "rol", "e-mail"));

		$datos = array();
		$datos["titulo"] = $titulo;
		$datos["roles"] = $roles;
		$datos["reglas_cliente"] = $reglas_cliente;

		$this->load->view("usuario/formulario_usuario", $datos);
	}

	private function registrar_usuario_bd() {
		$nombre = $this->input->post("nombre");
		$apellido_paterno = $this->input->post("apellido_paterno");
		$apellido_materno = $this->input->post("apellido_materno");
		$login = $this->input->post("login");
		$password = $this->input->post("password");
		$rol = $this->input->post("rol");
		$e_mail = $this->input->post("e-mail");

		if ($this->usuario_validacion->validar(array("nombre", "apellido_paterno", "apellido_materno", "login", "password", "confirmacion_password", "rol", "e_mail"))) {
			if ($this->Modelo_usuario->insert_usuario($nombre, $apellido_paterno, $apellido_materno, $e_mail, $login, $password, $rol)) {
				redirect(base_url("usuario/usuarios"));
			} else {
				redirect(base_url("usuario/registrar_usuario"), "refresh");
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_usuario();
		}
	}

	public function modificar_usuario($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador") {
			if ($id) {
				if (isset($_POST["submit"])) {
					$this->modificar_usuario_bd();
				} else {
					$this->cargar_vista_modificar_usuario($id);
				}
			} else {
				redirect(base_url("usuario/usuarios"), "refresh");
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_modificar_usuario($id) {
		$titulo = "Modificar usuario";
		$roles = $this->Modelo_rol->select_roles();
		$usuario = $this->Modelo_usuario->select_usuario_por_id($id);
		$reglas_cliente = $this->usuario_validacion->get_reglas_cliente(array("nombre", "apellido_paterno", "apellido_materno", "login", "rol", "e-mail"));

		if ($usuario) {
			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["roles"] = $roles;
			$datos["usuario"] = $usuario;
			$datos["reglas_cliente"] = $reglas_cliente;

			$this->load->view("usuario/formulario_usuario", $datos);
		} else {
			redirect(base_url("usuario/usuarios"));
		}
	}

	private function modificar_usuario_bd() {
		$id = $this->input->post("id");
		$nombre = $this->input->post("nombre");
		$apellido_paterno = $this->input->post("apellido_paterno");
		$apellido_materno = $this->input->post("apellido_materno");
		$login = $this->input->post("login");
		$rol = $this->input->post("rol");
		$e_mail = $this->input->post("e-mail");

		if ($this->usuario_validacion->validar(array("id", "nombre", "apellido_paterno", "apellido_materno", "login", "rol"))) {
			if ($this->Modelo_usuario->update_usuario($id, $nombre, $apellido_paterno, $apellido_materno, $e_mail, $login, $rol)) {
				redirect(base_url("usuario/usuarios"));
			} else {
				redirect(base_url("usuario/modificar_usuario/" . $id), "refresh");
			}
		} else {
			unset($_POST["submit"]);
			$this->modificar_usuario($id);
		}
	}

	public function modificar_password_usuario($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador") {
			if ($id) {
				if (isset($_POST["submit"])) {
					$this->modificar_password_usuario_bd();
				} else {
					$this->cargar_vista_modificar_password($id);
				}
			} else {
				redirect(base_url("usuario/usuarios"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function modificar_password_usuario_bd() {
		$id = $this->input->post("id");
		$password = $this->input->post("password");

		if ($this->usuario_validacion->validar(array("id", "password", "confirmacion_password"))) {
			if ($this->Modelo_usuario->update_password_usuario($id, $password)) {
				redirect(base_url("usuario/usuarios"));
			} else {
				redirect(base_url("usuario/modificar_password_usuario/" . $id), "refresh");
			}
		} else {
			unset($_POST["submit"]);
			$this->modificar_password_usuario($id);
		}
	}

	public function modificar_password() {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador" || $rol == "empleado") {
			if (isset($_POST["submit"])) {
				$this->modificar_password_bd();
			} else {
				$id = $this->session->userdata("id");
				$this->cargar_vista_modificar_password($id);
			}
		} else {
			redirect(base_url());
		}
	}

	private function modificar_password_bd() {
		$id = $this->session->userdata("id");
		$password = $this->input->post("password");
		$password_anterior = $this->input->post("password_anterior");

		$password_anterior_valido = FALSE;

		$usuario_de_id = $this->Modelo_usuario->select_usuario_por_id($id);

		if ($usuario_de_id) {
			$password_anterior_valido = $usuario_de_id->password == sha1($password_anterior);
		}

		if ($password_anterior_valido) {
			if ($this->usuario_validacion->validar(array("password", "confirmacion_password"))) {
				if ($this->Modelo_usuario->update_password_usuario($id, $password)) {
					redirect(base_url());
				} else {
					redirect(base_url("usuario/modificar_password"), "refresh");
				}
			} else {
				unset($_POST["submit"]);
				$this->modificar_password_usuario($id);
			}
		} else {
			$this->session->set_flashdata("password_anterior", "La contraseña introducida no coincide.");
			redirect(base_url("usuario/modificar_password"), "refresh");
		}
	}

	private function cargar_vista_modificar_password($id) {
		$titulo = "Modificar password";
		$usuario = $this->Modelo_usuario->select_usuario_por_id($id);
		$reglas_cliente = $this->usuario_validacion->get_reglas_cliente(array("login", "password", "confirmacion_password", "password_anterior"));

		if ($usuario) {
			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["usuario"] = $usuario;
			$datos["reglas_cliente"] = $reglas_cliente;

			$this->load->view("usuario/formulario_usuario", $datos);
		} else {
			redirect(base_url("usuario/usuarios"));
		}
	}

	public function eliminar_usuario($id = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "administrador") {
			if ($id) {
				$this->eliminar_usuario_bd($id);
			} else {
				redirect(base_url("usuario/usuarios"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function eliminar_usuario_bd($id) {
		$usuario = $this->Modelo_usuario->select_usuario_por_id($id);

		if ($usuario) {
			if ($this->Modelo_usuario->delete_usuario($id)) {
				redirect(base_url("usuario/usuarios"));
			} else {
				$this->session->set_userdata("error", "Ocurrió un error al eliminar el usuario.");
				redirect(base_url("usuario/usuarios"), "refresh");
			}
		} else {
			redirect(base_url("usuario/usuarios"));
		}
	}

}
