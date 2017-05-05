<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Modelo_proyecto
 *
 * @author Jose
 */
require_once 'MY_Model.php';

class Modelo_proyecto extends MY_Model {

	const ID = "id";
	const NOMBRE = "nombre";
	const OBJETIVO = "objetivo";
	const FECHA_INICIO = "fecha_inicio";
	const FECHA_FIN = "fecha_fin";
	const COLUMNAS_SELECT = "proyecto.id, proyecto.nombre, proyecto.objetivo, proyecto.fecha_inicio, proyecto.fecha_fin";
	const NOMBRE_TABLA = "proyecto";
	//para el join con proyecto_usuario
	const ID_USUARIO_PU = "id_usuario";
	const ID_PROYECTO_PU = "id_proyecto";
	const ID_ROL_PROYECTO_PU = "id_rol_proyecto";
	const COLUMNAS_SELECT_PROYECTO_USUARIO = "proyecto_usuario.id_usuario, proyecto_usuario.id_rol_proyecto";
	const NOMBRE_TABLA_PROYECTO_USUARIO = "proyecto_usuario";
	//para el join con rol_proyecto
	const ID_ROL_PROYECTO = "id";
	const NOMBRE_ROL_PROYECTO = "nombre";
	const COLUMNAS_SELECT_ROL_PROYECTO = "rol_proyecto.nombre as nombre_rol_proyecto";
	const NOMBRE_TABLA_ROL_PROYECTO = "rol_proyecto";

	public function __construct() {
		parent::__construct();
	}

	public function select_proyectos_de_usuario($id = FALSE) {
		$proyectos = FALSE;

		if ($id) {
			$this->set_select_proyecto_con_usuario_y_rol();
			$this->db->where(self::ID_USUARIO_PU, $id);

			$query = $this->db->get();

			$proyectos = $this->return_result($query);
		}

		return $proyectos;
	}

	public function select_proyecto_por_id($id_proyecto = FALSE, $id_usuario = FALSE, $id_rol_proyecto = FALSE) {
		$proyecto = FALSE;

		if ($id_proyecto) {
			$this->set_select_proyecto_con_usuario_y_rol();
			$this->db->where(self::NOMBRE_TABLA . "." . self::ID, $id_proyecto);

			if ($id_usuario) {
				$this->db->where(self::ID_USUARIO_PU, $id_usuario);
			}

			if ($id_rol_proyecto) {
				$this->db->where(self::ID_ROL_PROYECTO_PU, $id_rol_proyecto);
			}

			$query = $this->db->get();

			$proyecto = $this->return_row($query);
		}

		return $proyecto;
	}

	public function select_marco_logico_proyecto($id_proyecto = FALSE, $id_usuario = FALSE, $id_rol_proyecto = FALSE) {
		$proyecto = FALSE;

		if ($id_proyecto) {
			$this->set_select_proyecto_con_usuario_y_rol();
			$this->db->where(self::NOMBRE_TABLA . "." . self::ID, $id_proyecto);

			if ($id_usuario) {
				$this->db->where(self::ID_USUARIO_PU, $id_usuario);
			}

			if ($id_rol_proyecto) {
				$this->db->where(self::ID_ROL_PROYECTO_PU, $id_rol_proyecto);
			}
			
			$this->set_select_resultados();
			
			$query = $this->db->get();

			$columnas_proyecto = $this->return_result($query);
			
			$proyecto = $this->obtener_objeto_proyecto_de_columnas($columnas_proyecto);
		}

		return $proyecto;
	}

	private function set_select_proyecto_con_usuario_y_rol() {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->select(self::COLUMNAS_SELECT_PROYECTO_USUARIO);
		$this->db->select(self::COLUMNAS_SELECT_ROL_PROYECTO);
		$this->db->from(self::NOMBRE_TABLA);
		$this->db->join(self::NOMBRE_TABLA_PROYECTO_USUARIO, self::NOMBRE_TABLA_PROYECTO_USUARIO . "." . self::ID_PROYECTO_PU . " = " . self::NOMBRE_TABLA . "." . self::ID, "left");
		$this->db->join(self::NOMBRE_TABLA_ROL_PROYECTO, self::NOMBRE_TABLA_ROL_PROYECTO . "." . self::ID_ROL_PROYECTO . " = " . self::NOMBRE_TABLA_PROYECTO_USUARIO . "." . self::ID_ROL_PROYECTO_PU, "left");
	}
	
	private function set_select_resultados() {
		$this->db->select(Modelo_resultado::COLUMNAS_SELECT_PARA_PROYECTO);
		$this->db->join(Modelo_resultado::NOMBRE_TABLA, Modelo_resultado::NOMBRE_TABLA . "." . Modelo_resultado::ID_PROYECTO . " = " . self::NOMBRE_TABLA . "." . self::ID, "left");
		
		$this->set_select_efectos();
	}
	
	private function set_select_efectos() {
		$this->db->select(Modelo_efecto::COLUMNAS_SELECT_PARA_PROYECTO);
		$this->db->join(Modelo_efecto::NOMBRE_TABLA, Modelo_efecto::NOMBRE_TABLA . "." . Modelo_efecto::ID_RESULTADO . " = " . Modelo_resultado::NOMBRE_TABLA . "." . Modelo_resultado::ID, "left");
	}
	
	private function obtener_objeto_proyecto_de_columnas($columnas_proyecto) {
		$proyecto = FALSE;
		
		if (is_array($columnas_proyecto) && sizeof($columnas_proyecto) > 0) {
			$proyecto = new stdClass();
			
			//datos generales
			$columna = $columnas_proyecto[0];
			
			$proyecto->id = $columna->id;
			$proyecto->nombre = $columna->nombre;
			$proyecto->objetivo = $columna->objetivo;
			$proyecto->fecha_inicio = $columna->fecha_inicio;
			$proyecto->fecha_fin = $columna->fecha_fin;
			
			$proyecto->usuario = new stdClass();
			$proyecto->usuario->nombre_rol_proyecto = $columna->nombre_rol_proyecto;
			
			//resultados
			$proyecto->resultados = $this->obtener_resultados_de_proyecto($columnas_proyecto);
		}
		
		return $proyecto;
	}
	
	private function obtener_resultados_de_proyecto($columnas_proyecto) {
		$resultados = array();
		
		foreach($columnas_proyecto as $columna) {
			if (isset($columna->id_resultado)) {
				$resultado = new stdClass();
				$resultado->id = $columna->id_resultado;
				$resultado->nombre = $columna->nombre_resultado;
				$resultado->resultados_clave = $this->obtener_resultados_clave_de_resultado($resultado->id);
				$resultado->efectos = $this->obtener_efectos_de_resultado($resultado->id, $columnas_proyecto);
				$resultados[] = $resultado;
			}
		}
		
		return $resultados;
	}
	
	private function obtener_efectos_de_resultado($id_resultado, $columnas_proyecto) {
		$efectos = array();
		
		foreach($columnas_proyecto as $columna) {
			if (isset($columna->id_resultado) && isset($columna->id_efecto)) {
				if ($id_resultado == $columna->id_resultado) {
					$efecto = new stdClass();
					
					$efecto->id = $columna->id_efecto;
					$efecto->descripcion = $columna->descripcion_efecto;
					
					$efectos[] = $efecto;
				}
			}
		}
		
		return $efectos;
	}


	private function obtener_resultados_clave_de_resultado($id_resultado) {
		$resultados_clave = $this->Modelo_resultado_clave->select_resultados_clave_de_resultado($id_resultado);
		
		return $resultados_clave;
	}

	public function insert_proyecto($nombre = "", $objetivo = "", $fecha_inicio = "", $fecha_fin = "", $coordinador = FALSE) {
		$insertado = FALSE;

		if ($nombre != "" && $fecha_inicio != "" && $fecha_fin != "") {
			$this->db->trans_start();

			$datos = array(
				self::NOMBRE => $nombre,
				self::OBJETIVO => $objetivo,
				self::FECHA_INICIO => $fecha_inicio,
				self::FECHA_FIN => $fecha_fin
			);

			$this->db->set($datos);

			$insertado = $this->db->insert(self::NOMBRE_TABLA);

			if ($insertado) {
				if ($coordinador) {
					$id_proyecto = $this->db->insert_id();
					$id_rol_coordinador = $this->Modelo_rol_proyecto->select_id_rol_coordinador();
					$this->asignar_usuario_a_proyecto_con_rol($coordinador, $id_proyecto, $id_rol_coordinador);
				}
			}

			$this->db->trans_complete();
		}

		return $insertado;
	}

	private function asignar_usuario_a_proyecto_con_rol($id_usuario = FALSE, $id_proyecto = FALSE, $id_rol = FALSE) {
		$asignado = FALSE;

		if ($id_usuario && $id_proyecto && $id_rol) {
			$datos = array(
				self::ID_USUARIO_PU => $id_usuario,
				self::ID_PROYECTO_PU => $id_proyecto,
				self::ID_ROL_PROYECTO_PU => $id_rol
			);

			$this->db->set($datos);

			$asignado = $this->db->insert(self::NOMBRE_TABLA_PROYECTO_USUARIO);
		}

		return $asignado;
	}

	public function update_proyecto($id = FALSE, $nombre = "", $objetivo = "", $fecha_inicio = "", $fecha_fin = "") {
		$actualizado = FALSE;

		if ($id && $nombre != "" && $fecha_inicio != "" && $fecha_fin != "") {
			$this->db->trans_start();

			$datos = array(
				self::NOMBRE => $nombre,
				self::OBJETIVO => $objetivo,
				self::FECHA_INICIO => $fecha_inicio,
				self::FECHA_FIN => $fecha_fin
			);

			$this->db->set($datos);

			$this->db->where(self::ID, $id);

			$actualizado = $this->db->update(self::NOMBRE_TABLA);

			$this->db->trans_complete();
		}

		return $actualizado;
	}

	public function delete_proyecto($id = FALSE) {
		$eliminado = FALSE;

		if ($id) {
			$this->db->trans_start();

			$this->db->where(self::ID, $id);

			$eliminado = $this->db->delete(self::NOMBRE_TABLA);

			$this->db->trans_complete();
		}

		return $eliminado;
	}

}
