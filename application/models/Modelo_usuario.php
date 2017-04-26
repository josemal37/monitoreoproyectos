<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Modelo_usuario
 *
 * @author Jose
 */
require_once 'MY_Model.php';

class Modelo_usuario extends MY_Model {

	const ID = "id";
	const ID_ROL = "id_rol_usuario";
	const NOMBRE = "nombre";
	const APELLIDO_PATERNO = "apellido_paterno";
	const APELLIDO_MATERNO = "apellido_materno";
	const LOGIN = "login";
	const PASSWORD = "passwd";
	const COLUMNAS_SELECT = "usuario.id, usuario.id_rol_usuario, usuario.nombre, usuario.apellido_paterno, usuario.apellido_materno, usuario.login, usuario.passwd as password";
	const NOMBRE_TABLA = "usuario";

	public function __construct() {
		parent::__construct();
	}

	public function select_usuario_por_id($id = FALSE) {
		$usuario = FALSE;

		if ($id) {
			$this->set_select_usuario_y_rol();
			$this->db->from(self::NOMBRE_TABLA);
			$this->db->where(self::ID, $id);

			$query = $this->db->get();

			$usuario = $this->return_row($query);
			
			if ($usuario) {
				$usuario->nombre_completo = $this->get_nombre_completo($usuario);
			}
		}

		return $usuario;
	}

	public function select_usuario_por_login_password($login = "", $password = "") {
		$usuario = FALSE;

		if ($login != "" && $password != "") {
			$this->set_select_usuario_y_rol();
			$this->db->where(self::LOGIN, $login);
			$this->db->where(self::PASSWORD, $password);

			$query = $this->db->get();

			$usuario = $this->return_row($query);
			
			if ($usuario) {
				$usuario->nombre_completo = $this->get_nombre_completo($usuario);
			}
		}

		return $usuario;
	}

	private function set_select_usuario_y_rol() {
		$this->db->select(self::COLUMNAS_SELECT . ", " . Modelo_rol::NOMBRE_TABLA . "." . Modelo_rol::NOMBRE . " as nombre_rol");
		$this->db->from(self::NOMBRE_TABLA);
		$this->db->join(Modelo_rol::NOMBRE_TABLA, Modelo_rol::NOMBRE_TABLA . "." . Modelo_rol::ID . " = " . self::NOMBRE_TABLA . "." . self::ID_ROL);
	}
	
	private function get_nombre_completo($usuario = FALSE) {
		if ($usuario) {
			$nombre_completo = FALSE;

			if (isset($usuario->nombre)) {
				$nombre_completo = $usuario->nombre;
			}

			if ($usuario->apellido_paterno) {
				$nombre_completo .= " " . $usuario->apellido_paterno;
			}

			if ($usuario->apellido_paterno) {
				$nombre_completo .= " " . $usuario->apellido_materno;
			}

			return $nombre_completo;
		} else {
			return FALSE;
		}
	}

}
