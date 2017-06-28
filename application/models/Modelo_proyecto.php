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
	const FINALIZADO = "finalizado";
	const COLUMNAS_SELECT = "proyecto.id, proyecto.nombre, proyecto.objetivo, proyecto.fecha_inicio, proyecto.fecha_fin, proyecto.finalizado";
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

	public function select_proyectos_de_usuario($id = FALSE, $finalizado = FALSE, $direccion = FALSE) {
		$proyectos = FALSE;

		if ($id) {

			if (!$direccion) {
				$this->set_select_proyecto_con_usuario_y_rol();
				$this->db->where(self::ID_USUARIO_PU, $id);
			} else {
				$this->db->from(self::NOMBRE_TABLA);
			}

			if ($finalizado) {
				$this->db->where(self:: NOMBRE_TABLA . "." . self::FINALIZADO, $finalizado);
			} else {
				$this->db->where("(" .
						self::NOMBRE_TABLA . "." . self::FINALIZADO . " IS NULL" .
						" OR " . self::NOMBRE_TABLA . "." . self::FINALIZADO . " = FALSE" . ")");
			}

			$query = $this->db->get();

			$proyectos = $this->return_result($query);
		}

		return $proyectos;
	}

	public function select_proyecto_por_id($id_proyecto = FALSE, $id_usuario = FALSE, $id_rol_proyecto = FALSE) {
		$proyecto = FALSE;

		if ($id_proyecto) {
			$this->set_select_proyecto_con_usuario_y_rol();
			$this->db->where(self:: NOMBRE_TABLA . "." . self::ID, $id_proyecto);

			if ($id_usuario) {
				$this->db->where(self::ID_USUARIO_PU, $id_usuario);
			}

			if ($id_rol_proyecto) {
				$this->db->where(self::ID_ROL_PROYECTO_PU, $id_rol_proyecto);
			}

			$query = $this->db->get();

			$proyecto = $this->return_row($query);

			$proyecto->aportes = $this->Modelo_aporte->select_aportes_de_proyecto($proyecto->id);
		}

		return $proyecto;
	}

	public function select_marco_logico_proyecto($id_proyecto = FALSE, $id_usuario = FALSE, $id_rol_proyecto = FALSE) {
		$proyecto = FALSE;

		if ($id_proyecto) {
			$this->set_select_proyecto_con_usuario_y_rol();
			$this->db->where(self:: NOMBRE_TABLA . "." . self::ID, $id_proyecto);

			if ($id_usuario) {
				$this->db->where(self::ID_USUARIO_PU, $id_usuario);
			}

			if ($id_rol_proyecto) {
				$this->db->where(self::ID_ROL_PROYECTO_PU, $id_rol_proyecto);
			}

			$this->set_select_resultados();

			$query = $this->db->get();

			$filas_proyecto = $this->return_result($query);

			$proyecto = $this->obtener_objeto_proyecto_de_filas($filas_proyecto);
		}

		return $proyecto;
	}

	private function set_select_proyecto_con_usuario_y_rol() {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->select(self::COLUMNAS_SELECT_PROYECTO_USUARIO);
		$this->db->select(self::COLUMNAS_SELECT_ROL_PROYECTO);
		$this->db->from(self::NOMBRE_TABLA);
		$this->db->join(self:: NOMBRE_TABLA_PROYECTO_USUARIO, self::NOMBRE_TABLA_PROYECTO_USUARIO . "." . self::ID_PROYECTO_PU . " = " . self:: NOMBRE_TABLA . "." . self::ID, "left");
		$this->db->join(self ::NOMBRE_TABLA_ROL_PROYECTO, self::NOMBRE_TABLA_ROL_PROYECTO . "." . self::ID_ROL_PROYECTO . " = " . self::NOMBRE_TABLA_PROYECTO_USUARIO . "." . self::

				ID_ROL_PROYECTO_PU, "left");
	}

	private function set_select_resultados() {
		$this->db->select(Modelo_resultado::COLUMNAS_SELECT_PARA_PROYECTO);
		$this->db->join(Modelo_resultado::NOMBRE_TABLA, Modelo_resultado::NOMBRE_TABLA . "." . Modelo_resultado::ID_PROYECTO . " = " . self:: NOMBRE_TABLA . "." . self::ID, "left");

		$this->
				set_select_efectos();
	}

	private function set_select_efectos() {
		$this->db->select(Modelo_efecto::COLUMNAS_SELECT_PARA_PROYECTO);
		$this->db->join(Modelo_efecto::NOMBRE_TABLA, Modelo_efecto::NOMBRE_TABLA . "." . Modelo_efecto::ID_RESULTADO . " = " . Modelo_resultado::NOMBRE_TABLA . "." . Modelo_resultado::ID, "left");

		$this->
				set_select_productos();
	}

	private function set_select_productos() {
		$this->db->select(Modelo_producto::COLUMNAS_SELECT_PARA_PROYECTO);
		$this->db->join(Modelo_producto::NOMBRE_TABLA, Modelo_producto::NOMBRE_TABLA . "." . Modelo_producto::ID_EFECTO . " = " . Modelo_efecto:: NOMBRE_TABLA . "." .
				Modelo_efecto::ID, "left");
	}

	private function obtener_objeto_proyecto_de_filas($filas_proyecto) {
		$proyecto = FALSE;

		if (is_array($filas_proyecto) && sizeof($filas_proyecto) > 0) {
			$proyecto = new stdClass();

			//datos generales
			$fila = $filas_proyecto[0];

			$proyecto->id = $fila->id;
			$proyecto->nombre = $fila->nombre;
			$proyecto->objetivo = $fila->objetivo;
			$proyecto->fecha_inicio = $fila->fecha_inicio;
			$proyecto->fecha_fin = $fila->fecha_fin;
			$proyecto->finalizado = $fila->finalizado;

			$proyecto->nombre_rol_proyecto = $fila->nombre_rol_proyecto;

			//resultados
			$proyecto->resultados = $this->obtener_resultados_de_proyecto($filas_proyecto);

			//indicadores de impacto
			$proyecto->indicadores_impacto = $this->obtener_indicadores_impacto_de_proyecto($proyecto->id);

			$proyecto->aportes = $this->Modelo_aporte->select_aportes_de_proyecto($proyecto->id);
		}

		return $proyecto;
	}

	private function obtener_resultados_de_proyecto($filas_proyecto) {
		$resultados = array();
		foreach ($filas_proyecto as $fila) {
			if (isset($fila->id_resultado) && !$this->existe_id_en_array($fila->id_resultado, $resultados)) {
				$resultado = new stdClass();
				$resultado->id = $fila->id_resultado;
				$resultado->nombre = $fila->nombre_resultado;
				$resultado->resultados_clave = $this->obtener_resultados_clave_de_resultado($resultado->id);
				$resultado->efectos = $this->obtener_efectos_de_resultado($resultado->id, $filas_proyecto);
				$resultados[] = $resultado;
			}
		}

		return $resultados;
	}

	private function obtener_efectos_de_resultado($id_resultado, $filas_proyecto) {
		$efectos = array();
		foreach ($filas_proyecto as $fila) {
			if (isset($fila->id_resultado) && isset($fila->id_efecto) && !$this->existe_id_en_array($fila->id_efecto, $efectos)) {
				if ($id_resultado == $fila->id_resultado) {
					$efecto = new stdClass();

					$efecto->id = $fila->id_efecto;
					$efecto->descripcion = $fila->descripcion_efecto;

					$efecto->productos = $this->obtener_productos_de_efecto($efecto->id, $filas_proyecto);

					$efecto->indicadores = $this->obtener_indicadores_efecto_de_efecto($efecto->id);

					$efectos[] = $efecto;
				}
			}
		}

		return $efectos;
	}

	private function obtener_productos_de_efecto($id_efecto, $filas_proyecto) {
		$productos = array();
		foreach ($filas_proyecto as $fila) {
			if (isset($fila->id_efecto) && isset($fila->id_producto) && !$this->existe_id_en_array($fila->id_producto, $productos)) {
				if ($id_efecto == $fila->id_efecto) {
					$producto = new stdClass();

					$producto->id = $fila->id_producto;
					$producto->descripcion = $fila->descripcion_producto;
					$producto->indicadores = $this->Modelo_indicador_producto->select_indicadores_producto_de_producto($producto->id);

					$productos[] = $producto;
				}
			}
		}

		return $productos;
	}

	private function obtener_resultados_clave_de_resultado($id_resultado) {
		$resultados_clave = $this->Modelo_resultado_clave->select_resultados_clave_de_resultado($id_resultado);



		return $resultados_clave;
	}

	private function obtener_indicadores_impacto_de_proyecto($id_proyecto) {
		$indicadores = $this->Modelo_indicador_impacto->select_indicadores_impacto_de_proyecto($id_proyecto);

		return $indicadores;
	}

	private function obtener_indicadores_efecto_de_efecto($id_efecto) {
		$indicadores = $this->Modelo_indicador_efecto->select_indicadores_efecto_de_efecto($id_efecto);

		return $indicadores;
	}

	private function obtener_aportes_de_proyecto($id_proyecto) {
		$aportes = $this->Modelo_aporte->select_aportes_de_proyecto($id_proyecto);

		return $aportes;
	}

	private function existe_id_en_array($id, $array) {
		$existe = FALSE;

		foreach ($array as $item) {
			if ($id == $item->id) {
				$existe = TRUE;
				break;
			}
		}

		return $existe;
	}

	public function insert_proyecto($nombre = "", $objetivo = "", $fecha_inicio = "", $fecha_fin = "", $coordinador = FALSE, $con_financiadores = FALSE, $instituciones_ejecutores = FALSE, $cantidades_ejecutores = FALSE, $conceptos_ejecutores = FALSE, $instituciones_financiadores = FALSE, $cantidades_financiadores = FALSE, $conceptos_financiadores = FALSE, $instituciones_otros = FALSE, $cantidades_otros = FALSE, $conceptos_otros = FALSE) {
		$insertado = FALSE;

		if ($nombre != "" && $fecha_inicio != "" && $fecha_fin != "") {
			$this->db->trans_start();

			$datos = array(
				self::NOMBRE => $nombre,
				self:: OBJETIVO => $objetivo,
				self:: FECHA_INICIO => $fecha_inicio,
				self::FECHA_FIN => $fecha_fin
			);

			$this->db->set($datos);

			$insertado = $this->db->insert(self::NOMBRE_TABLA);

			if ($insertado) {
				$id_proyecto = $this->db->insert_id();

				if ($coordinador) {
					$id_rol_coordinador = $this->Modelo_rol_proyecto->select_id_rol_coordinador();
					$this->asignar_usuario_a_proyecto_con_rol($coordinador, $id_proyecto, $id_rol_coordinador);
				}

				if ($con_financiadores) {
					$this->Modelo_aporte->insert_aportes_st($id_proyecto, $instituciones_ejecutores, $cantidades_ejecutores, $conceptos_ejecutores, $instituciones_financiadores, $cantidades_financiadores, $conceptos_financiadores, $instituciones_otros, $cantidades_otros, $conceptos_otros);
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
				self:: ID_USUARIO_PU => $id_usuario,
				self:: ID_PROYECTO_PU => $id_proyecto,
				self::ID_ROL_PROYECTO_PU => $id_rol
			);

			$this->db->set($datos);

			$asignado = $this->db->insert(self::NOMBRE_TABLA_PROYECTO_USUARIO);
		}

		return $asignado;
	}

	public function update_proyecto($id = FALSE, $nombre = "", $objetivo = "", $fecha_inicio = "", $fecha_fin = "", $con_financiadores = FALSE, $instituciones_ejecutores = FALSE, $cantidades_ejecutores = FALSE, $conceptos_ejecutores = FALSE, $instituciones_financiadores = FALSE, $cantidades_financiadores = FALSE, $conceptos_financiadores = FALSE, $instituciones_otros = FALSE, $cantidades_otros = FALSE, $conceptos_otros = FALSE) {
		$actualizado = FALSE;

		if ($id && $nombre != "" && $fecha_inicio != "" && $fecha_fin != "") {
			$this->db->trans_start();

			$datos = array(
				self::NOMBRE => $nombre,
				self:: OBJETIVO => $objetivo,
				self:: FECHA_INICIO => $fecha_inicio,
				self::FECHA_FIN => $fecha_fin
			);

			$this->db->set($datos);
			$this->db->where(self::ID, $id);

			$actualizado = $this->db->update(self::NOMBRE_TABLA);
			
			if ($actualizado) {
				$this->Modelo_aporte->update_aportes_st($id, $con_financiadores, $instituciones_ejecutores, $cantidades_ejecutores, $conceptos_ejecutores, $instituciones_financiadores, $cantidades_financiadores, $conceptos_financiadores, $instituciones_otros, $cantidades_otros, $conceptos_otros);
			}

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

	public function finalizar_proyecto($id = FALSE) {
		$finalizado = FALSE;

		if ($id) {
			$this->db->trans_start();

			$datos = array(
				self::FINALIZADO => TRUE
			);

			$this->db->set($datos);

			$this->db->where(self:: NOMBRE_TABLA . "." . self::ID, $id);

			$finalizado = $this->db->update(self::NOMBRE_TABLA);

			if ($finalizado) {
				$this->Modelo_actividad->finalizar_actividades_de_proyecto_st($id);
			}

			$this->db->trans_complete();
		}

		return $finalizado;
	}

}
