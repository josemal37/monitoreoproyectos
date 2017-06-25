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
	const E_MAIL = "e_mail";
	const LOGIN = "login";
	const PASSWORD = "passwd";
	const COLUMNAS_SELECT = "usuario.id, usuario.id_rol_usuario as id_rol, usuario.nombre, usuario.apellido_paterno, usuario.apellido_materno, usuario.e_mail, usuario.login, usuario.passwd as password";
	const COLUMNAS_SELECT_OTRA_TABLA = "usuario.id as id_usuario, usuario.id_rol_usuario as id_rol_usuario, usuario.nombre as nombre_usuario, usuario.apellido_paterno as apellido_paterno_usuario, usuario.apellido_materno as apellido_materno_usuario, usuario.e_mail as e_mail_usuario";
	const NOMBRE_TABLA = "usuario";

	public function __construct() {
		parent::__construct();
	}

	public function select_usuarios() {
		$this->set_select_usuario_y_rol();

		$query = $this->db->get();

		$usuarios = $this->return_result($query);

		if ($usuarios) {
			foreach ($usuarios as $usuario) {
				$usuario->nombre_completo = $this->get_nombre_completo($usuario);
			}
		}

		return $usuarios;
	}

	public function select_usuarios_empleados($no_id_proyecto = FALSE) {
		$this->set_select_usuario_y_rol();

		$this->db->where(Modelo_rol::NOMBRE_TABLA . "." . Modelo_rol::NOMBRE, Modelo_rol::EMPLEADO);

		if ($no_id_proyecto) {
			$this->db->where(
					"`usuario`.`id` NOT IN (
						SELECT
							`proyecto_usuario`.`id_usuario`
						FROM
							`proyecto_usuario`
						WHERE
							`proyecto_usuario`.`id_proyecto` = " . $no_id_proyecto . "
					)"
			);
		}

		$this->set_order_by_nombre_completo();

		$query = $this->db->get();

		$usuarios = $this->return_result($query);

		if ($usuarios) {
			foreach ($usuarios as $usuario) {
				$usuario->nombre_completo = $this->get_nombre_completo($usuario);
			}
		}

		return $usuarios;
	}

	public function select_usuarios_de_proyecto($id_proyecto = FALSE, $no_id_actividad = FALSE) {
		$usuarios = FALSE;

		if ($id_proyecto) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);

			$this->db->join(Modelo_proyecto_usuario::NOMBRE_TABLA, Modelo_proyecto_usuario::NOMBRE_TABLA . "." . Modelo_proyecto_usuario::ID_USUARIO . " = " . self::NOMBRE_TABLA . "." . self::ID);
			$this->db->where(Modelo_proyecto_usuario::ID_PROYECTO, $id_proyecto);

			$this->db->select(Modelo_rol_proyecto::COLUMNAS_SELECT_OTRA_TABLA);
			$this->db->join(Modelo_rol_proyecto::NOMBRE_TABLA, Modelo_rol_proyecto::NOMBRE_TABLA . "." . Modelo_rol_proyecto::ID . " = " . Modelo_proyecto_usuario::NOMBRE_TABLA . "." . Modelo_proyecto_usuario::ID_ROL_PROYECTO);

			if ($no_id_actividad) {
				$this->db->where(
						"`usuario`.`id` NOT IN (
						SELECT
							`actividad_usuario`.`id_usuario`
						FROM
							`actividad_usuario`
						WHERE
							`actividad_usuario`.`id_actividad` = " . $no_id_actividad . "
					)"
				);
			}

			$this->db->order_by(Modelo_rol_proyecto::NOMBRE_TABLA . "." . Modelo_rol_proyecto::ID);
			$this->set_order_by_nombre_completo();

			$query = $this->db->get();

			$usuarios = $this->return_result($query);

			if ($usuarios) {
				foreach ($usuarios as $usuario) {
					$usuario->nombre_completo = $this->get_nombre_completo($usuario);
				}
			}
		}

		return $usuarios;
	}

	public function select_usuarios_actividad($id_actividad = FALSE) {
		$usuarios = FALSE;

		if ($id_actividad) {
			$this->db->select(self::COLUMNAS_SELECT);
			$this->db->from(self::NOMBRE_TABLA);

			$this->db->join(Modelo_actividad_usuario::NOMBRE_TABLA, Modelo_actividad_usuario::NOMBRE_TABLA . "." . Modelo_actividad_usuario::ID_USUARIO . " = " . self::NOMBRE_TABLA . "." . self::ID);

			$this->db->where(Modelo_actividad_usuario::ID_ACTIVIDAD, $id_actividad);

			$this->set_order_by_nombre_completo();

			$query = $this->db->get();

			$usuarios = $this->return_result($query);

			if ($usuarios) {
				foreach ($usuarios as $usuario) {
					$usuario->nombre_completo = $this->get_nombre_completo($usuario);
				}
			}
		}

		return $usuarios;
	}

	public function select_usuario_por_id($id = FALSE) {
		$usuario = FALSE;

		if ($id) {
			$this->set_select_usuario_y_rol();
			$this->db->where(self::NOMBRE_TABLA . "." . self::ID, $id);

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
			$password = sha1($password);

			$this->set_select_usuario_y_rol();
			$this->db->where("BINARY `" . self::NOMBRE_TABLA . "`.`" . self::LOGIN . "` = '" . $login . "'", NULL, FALSE);
			$this->db->where("BINARY `" . self::NOMBRE_TABLA . "`.`" . self::PASSWORD . "` = '" . $password . "'", NULL, FALSE);

			$query = $this->db->get();

			$usuario = $this->return_row($query);

			if ($usuario) {
				$usuario->nombre_completo = $this->get_nombre_completo($usuario);
			}
		}

		return $usuario;
	}

	private function select_usuario_por_login($login = "", $no_id = FALSE) {
		$usuario = FALSE;

		if ($login != "") {
			$this->set_select_usuario_y_rol();
			$this->db->where("BINARY `" . self::NOMBRE_TABLA . "`.`" . self::LOGIN . "` = '" . $login . "'", NULL, FALSE);

			if ($no_id) {
				$this->db->where(self::NOMBRE_TABLA . "." . self::ID . " != " . $no_id, NULL, FALSE);
			}

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

	private function set_order_by_nombre_completo() {
		$this->db->order_by(Modelo_usuario::NOMBRE_TABLA . "." . Modelo_usuario::NOMBRE);
		$this->db->order_by(Modelo_usuario::NOMBRE_TABLA . "." . Modelo_usuario::APELLIDO_PATERNO);
		$this->db->order_by(Modelo_usuario::NOMBRE_TABLA . "." . Modelo_usuario::APELLIDO_MATERNO);
	}

	private function select_usuario_por_e_mail($e_mail, $no_id = FALSE) {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
		$this->db->where("BINARY `" . self::NOMBRE_TABLA . "`.`" . self::E_MAIL . "` = '" . $e_mail . "'", NULL, FALSE);

		if ($no_id) {
			$this->db->where(self::ID . " != ", $no_id);
		}

		$query = $this->db->get();

		$usuario = $this->return_row($query);

		return $usuario;
	}

	public function insert_usuario($nombre = "", $apellido_paterno = "", $apellido_materno = "", $e_mail = "", $login = "", $password = "", $id_rol = FALSE) {
		$insertado = FALSE;

		if ($nombre != "" && $login != "" && $password != "" && $id_rol && $e_mail != "") {
			$password = sha1($password);

			$this->db->trans_start();

			$usuario_de_e_mail = $this->select_usuario_por_e_mail($e_mail);

			if (!$this->existe_login($login)) {
				if (!$usuario_de_e_mail) {
					$datos = array(
						self::NOMBRE => $nombre,
						self::APELLIDO_PATERNO => $apellido_paterno,
						self::APELLIDO_MATERNO => $apellido_materno,
						self::E_MAIL => $e_mail,
						self::LOGIN => $login,
						self::PASSWORD => $password,
						self::ID_ROL => $id_rol
					);

					$this->db->set($datos);

					$insertado = $this->db->insert(self::NOMBRE_TABLA);
				} else {
					$this->session->set_flashdata("existe_e_mail", "El correo electrónico introducido ya se encuentra registrado.");
				}
			} else {
				$this->session->set_flashdata("existe", "El nombre de usuario introducido ya se encuentra registrado.");
			}

			$this->db->trans_complete();
		}

		return $insertado;
	}

	public function update_usuario($id = FALSE, $nombre = "", $apellido_paterno = "", $apellido_materno = "", $e_mail = "", $login = "", $id_rol = FALSE) {
		$actualizado = FALSE;

		if ($id && $nombre != "" && $login != "" && $id_rol && $e_mail != "") {
			$this->db->trans_start();

			if (!$this->select_usuario_por_login($login, $id)) {
				if (!$this->select_usuario_por_e_mail($e_mail, $id)) {
					$datos = array(
						self::NOMBRE => $nombre,
						self::APELLIDO_PATERNO => $apellido_paterno,
						self::APELLIDO_MATERNO => $apellido_materno,
						self::LOGIN => $login,
						self::ID_ROL => $id_rol
					);

					$this->db->set($datos);

					$this->db->where(self::NOMBRE_TABLA . "." . self::ID, $id);

					$actualizado = $this->db->update(self::NOMBRE_TABLA);
				} else {
					$this->session->set_flashdata("existe_e_mail", "El correo electrónico introducido ya se encuentra registrado.");
				}
			} else {
				$this->session->set_flashdata("existe", "El nombre de usuario introducido ya se encuentra registrado.");
			}

			$this->db->trans_complete();
		}

		return $actualizado;
	}

	public function update_password_usuario($id = FALSE, $password = "") {
		$actualizado = FALSE;

		if ($id && $password != "") {
			$password = sha1($password);

			$this->db->trans_start();

			$datos = array(
				self::PASSWORD => $password
			);

			$this->db->set($datos);

			$this->db->where(self::ID, $id);

			$actualizado = $this->db->update(self::NOMBRE_TABLA);

			$this->db->trans_complete();
		}

		return $actualizado;
	}

	public function delete_usuario($id = FALSE) {
		$eliminado = FALSE;

		if ($id) {
			$this->db->trans_start();

			$this->db->where(self::ID, $id);

			$eliminado = $this->db->delete(self::NOMBRE_TABLA);

			$this->db->trans_complete();
		}

		return $eliminado;
	}

	private function get_nombre_completo($usuario = FALSE) {
		$nombre_completo = FALSE;

		if ($usuario) {

			if (isset($usuario->nombre)) {
				$nombre_completo = $usuario->nombre;
			}

			if ($usuario->apellido_paterno) {
				$nombre_completo .= " " . $usuario->apellido_paterno;
			}

			if ($usuario->apellido_paterno) {
				$nombre_completo .= " " . $usuario->apellido_materno;
			}
		}

		return $nombre_completo;
	}

	public function existe_login($login = "", $no_id = FALSE) {
		$existe = FALSE;

		if ($this->select_usuario_por_login($login, $no_id)) {
			$existe = TRUE;
		}

		return $existe;
	}

}
