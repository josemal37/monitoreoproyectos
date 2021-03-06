<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Modelo_actividad
 *
 * @author Jose
 */
class Modelo_actividad extends MY_Model {

	const ID = "id";
	const ID_PROYECTO = "id_proyecto";
	const NOMBRE = "nombre";
	const FECHA_INICIO = "fecha_inicio";
	const FECHA_FIN = "fecha_fin";
	const FINALIZADA = "finalizada";
	const COLUMNAS_SELECT = "actividad.id, actividad.id_proyecto, actividad.nombre, actividad.fecha_inicio, actividad.fecha_fin, actividad.finalizada";
	const NOMBRE_TABLA = "actividad";
	//tabla asoc producto
	const ID_ACTIVIDAD = "id_actividad";
	const ID_PRODUCTO = "id_producto";
	const COLUMNAS_SELECT_ASOC_PRODUCTO = "actividad_producto.id_producto";
	const NOMBRE_TABLA_ASOC_PRODUCTO = "actividad_producto";
	//tabla asoc indicador producto
	const ID_INDICADOR_PRODUCTO = "id_indicador_producto";
	const PORCENTAJE = "porcentaje";
	const COLUMNAS_SELECT_ASOC_INDICADOR_PRODUCTO = "actividad_indicador_producto.id_indicador_producto, actividad_indicador_producto.porcentaje";
	const NOMBRE_TABLA_ASOC_INDICADOR_PRODUCTO = "actividad_indicador_producto";
	//tabla avance actividad
	const COLUMNAS_SELECT_AVANCE_ACTIVIDAD = "avance_actividad.avance_acumulado";
	const NOMBRE_TABLA_AVANCE_ACTIVIDAD = "avance_actividad";

	public function __construct() {
		parent::__construct();
	}

	public function select_actividades_de_proyecto($id_proyecto = FALSE) {
		$actividades = FALSE;

		if ($id_proyecto) {
			$this->set_select_actividad();
			$this->set_select_meta_actividad();
			$this->set_select_producto_asociado();
			$this->set_select_indicador_producto_asociado();
			$this->set_select_avance_acumulado();

			$this->db->where(self::ID_PROYECTO, $id_proyecto);

			$this->db->order_by(self::NOMBRE_TABLA . "." . self::FECHA_INICIO);

			$query = $this->db->get();

			$actividades = $this->return_result($query);
		}

		return $actividades;
	}

	public function select_actividades_de_proyecto_con_personal($id_proyecto = FALSE) {
		$actividades = FALSE;

		if ($id_proyecto) {
			$this->set_select_actividad();

			$this->db->where(self::ID_PROYECTO, $id_proyecto);

			$this->db->order_by(self::NOMBRE_TABLA . "." . self::FECHA_INICIO);

			$query = $this->db->get();

			$actividades = $this->return_result($query);

			if ($actividades) {
				foreach ($actividades as $actividad) {
					$actividad->usuarios = $this->Modelo_usuario->select_usuarios_actividad($actividad->id);
				}
			}
		}

		return $actividades;
	}

	public function select_actividades_de_proyecto_con_avance($id_proyecto = FALSE) {
		$actividades = FALSE;

		if ($id_proyecto) {
			$this->set_select_actividad();
			$this->set_select_meta_actividad();
			$this->set_select_avance_acumulado();

			$this->db->where(self::NOMBRE_TABLA . "." . self::ID_PROYECTO, $id_proyecto);

			$this->db->order_by(self::NOMBRE_TABLA . "." . self::FECHA_INICIO);

			$query = $this->db->get();

			$actividades = $this->return_result($query);

			if ($actividades) {
				foreach ($actividades as $actividad) {
					$actividad->avances = $this->Modelo_avance->select_avances_de_actividad($actividad->id);
					$actividad->usuarios = $this->Modelo_usuario->select_usuarios_actividad($actividad->id);
				}
			}
		}

		return $actividades;
	}

	public function select_actividades_de_proyecto_con_avances($id_proyecto = FALSE, $fecha_actividades = FALSE, $fecha_inicio_actividades = FALSE, $fecha_fin_actividades = FALSE, $fecha_avances = FALSE, $fecha_inicio_avances = FALSE, $fecha_fin_avances = FALSE) {
		$actividades = FALSE;

		if ($id_proyecto) {
			$this->set_select_actividad();
			$this->set_select_meta_actividad();
			$this->set_select_avance_acumulado();
			$this->set_select_avances();

			$this->db->where(self::NOMBRE_TABLA . "." . self::ID_PROYECTO, $id_proyecto);

			$this->db->order_by(self::NOMBRE_TABLA . "." . self::FECHA_INICIO);

			if ($fecha_actividades && $fecha_inicio_actividades && $fecha_fin_actividades) {
				$this->db->where(
						"((`" .
						self::NOMBRE_TABLA . "`.`" . self::FECHA_INICIO . "` BETWEEN '" .
						$fecha_inicio_actividades . "' AND '" . $fecha_fin_actividades .
						"') OR (`" .
						self::NOMBRE_TABLA . "`.`" . self::FECHA_FIN . "` BETWEEN '" .
						$fecha_inicio_actividades . "' AND '" . $fecha_fin_actividades .
						"'))", NULL, FALSE
				);
			}

			if ($fecha_avances && $fecha_inicio_avances && $fecha_fin_avances) {
				$this->db->where(
						"(`" .
						Modelo_avance::NOMBRE_TABLA . "`.`" . Modelo_avance::FECHA . "` BETWEEN '" .
						$fecha_inicio_avances . "' AND '" . $fecha_fin_avances .
						"')", NULL, FALSE
				);
			}

			$query = $this->db->get();

			$filas = $this->return_result($query);

			$actividades = $this->get_actividades_con_avances($filas);
		}

		return $actividades;
	}

	public function select_actividad_con_personal($id_actividad = FALSE) {
		$actividad = FALSE;

		if ($id_actividad) {
			$this->set_select_actividad();

			$this->db->where(self::ID, $id_actividad);

			$query = $this->db->get();

			$actividad = $this->return_row($query);

			if ($actividad) {
				$actividad->usuarios = $this->Modelo_usuario->select_usuarios_actividad($actividad->id);
			}
		}

		return $actividad;
	}

	private function get_actividades_con_avances($filas) {
		$actividades = FALSE;

		if ($filas) {
			$actividades = array();

			foreach ($filas as $fila) {
				if (!isset($actividades[$fila->id])) {
					$actividades[$fila->id] = $this->get_actividad_con_avance($fila, $filas);
				}
			}
		}

		return $actividades;
	}

	private function get_actividad_con_avance($fila, $filas) {
		$actividad = new stdClass();

		$actividad->id = $fila->id;
		$actividad->id_proyecto = $fila->id_proyecto;
		$actividad->nombre = $fila->nombre;
		$actividad->fecha_inicio = $fila->fecha_inicio;
		$actividad->fecha_fin = $fila->fecha_fin;
		$actividad->cantidad = $fila->cantidad;
		$actividad->unidad = $fila->unidad;
		$actividad->avance_acumulado = $fila->avance_acumulado;
		$actividad->finalizada = $fila->finalizada;
		$actividad->avances = $this->get_avances_de_actividad($actividad->id, $filas);

		return $actividad;
	}

	private function get_avances_de_actividad($id_actividad, $filas) {
		$avances = array();

		foreach ($filas as $fila) {
			if ($fila->id == $id_actividad && $fila->id_avance) {
				$avance = new stdClass();

				$avance->id = $fila->id_avance;
				$avance->id_actividad = $id_actividad;
				$avance->cantidad = $fila->cantidad_avance;
				$avance->descripcion = $fila->descripcion_avance;
				$avance->fecha = $fila->fecha_avance;

				$avances[] = $avance;
			}
		}

		return $avances;
	}

	public function select_actividad_por_id($id_actividad = FALSE, $id_proyecto = FALSE, $id_usuario = FALSE) {
		$actividad = FALSE;

		if ($id_actividad) {
			$this->set_select_actividad();
			$this->set_select_meta_actividad();
			$this->set_select_producto_asociado();
			$this->set_select_indicador_producto_asociado();

			$this->db->where(self::NOMBRE_TABLA . "." . self::ID, $id_actividad);

			if ($id_proyecto) {
				$this->db->where(self::NOMBRE_TABLA . "." . self::ID_PROYECTO, $id_proyecto);
			}

			if ($id_usuario) {
				$this->set_select_usuarios_asociados();
				$this->db->where(Modelo_usuario::NOMBRE_TABLA . "." . Modelo_usuario::ID, $id_usuario);
			}

			$query = $this->db->get();

			$actividad = $this->return_row($query);
		}

		return $actividad;
	}

	private function set_select_actividad() {
		$this->db->select(self::COLUMNAS_SELECT);
		$this->db->from(self::NOMBRE_TABLA);
	}

	private function set_select_meta_actividad() {
		$this->db->select(Modelo_meta_actividad::COLUMNAS_SELECT_OTRA_TABLA);
		$this->db->join(Modelo_meta_actividad::NOMBRE_TABLA, Modelo_meta_actividad::NOMBRE_TABLA . "." . Modelo_meta_actividad::ID_ACTIVIDAD . " = " . self::NOMBRE_TABLA . "." . self::ID, "left");
	}

	private function set_select_producto_asociado() {
		$this->db->select(Modelo_producto::COLUMNAS_SELECT_PARA_PROYECTO);
		$this->db->join(self::NOMBRE_TABLA_ASOC_PRODUCTO, self::NOMBRE_TABLA_ASOC_PRODUCTO . "." . self::ID_ACTIVIDAD . " = " . self::NOMBRE_TABLA . "." . self::ID, "left");
		$this->db->join(Modelo_producto::NOMBRE_TABLA, Modelo_producto::NOMBRE_TABLA . "." . Modelo_producto::ID . " = " . self::NOMBRE_TABLA_ASOC_PRODUCTO . "." . self::ID_PRODUCTO, "left");
	}

	private function set_select_indicador_producto_asociado() {
		$this->db->select(Modelo_indicador_producto::COLUMNAS_SELECT_OTRA_TABLA);
		$this->db->select(self::COLUMNAS_SELECT_ASOC_INDICADOR_PRODUCTO);
		$this->db->join(self::NOMBRE_TABLA_ASOC_INDICADOR_PRODUCTO, self::NOMBRE_TABLA_ASOC_INDICADOR_PRODUCTO . "." . self::ID_ACTIVIDAD . " = " . self::NOMBRE_TABLA . "." . self::ID, "left");
		$this->db->join(Modelo_indicador_producto::NOMBRE_TABLA, Modelo_indicador_producto::NOMBRE_TABLA . "." . Modelo_indicador_producto::ID . " = " . self::NOMBRE_TABLA_ASOC_INDICADOR_PRODUCTO . "." . self::ID_INDICADOR_PRODUCTO, "left");
	}

	private function set_select_usuarios_asociados() {
		$this->db->select(Modelo_usuario::COLUMNAS_SELECT_OTRA_TABLA);
		$this->db->join(Modelo_actividad_usuario::NOMBRE_TABLA, Modelo_actividad_usuario::NOMBRE_TABLA . "." . Modelo_actividad_usuario::ID_ACTIVIDAD . " = " . self::NOMBRE_TABLA . "." . self::ID, "left");
		$this->db->join(Modelo_usuario::NOMBRE_TABLA, Modelo_usuario::NOMBRE_TABLA . "." . Modelo_usuario::ID . " = " . Modelo_actividad_usuario::NOMBRE_TABLA . "." . Modelo_actividad_usuario::ID_USUARIO, "left");
	}

	private function set_select_avance_acumulado() {
		$this->db->select(self::COLUMNAS_SELECT_AVANCE_ACTIVIDAD);
		$this->db->join(self::NOMBRE_TABLA_AVANCE_ACTIVIDAD, self::NOMBRE_TABLA_AVANCE_ACTIVIDAD . "." . self::ID_ACTIVIDAD . " = " . self::NOMBRE_TABLA . "." . self::ID, "left");
	}

	private function set_select_avances() {
		$this->db->select(Modelo_avance::COLUMNAS_SELECT_OTRA_TABLA);
		$this->db->join(Modelo_avance::NOMBRE_TABLA, Modelo_avance::NOMBRE_TABLA . "." . Modelo_avance::ID_ACTIVIDAD . " = " . self::NOMBRE_TABLA . "." . self::ID, "left");
	}

	public function insert_actividad($id_proyecto = FALSE, $nombre = "", $fecha_inicio = "", $fecha_fin = "", $con_meta = FALSE, $cantidad = FALSE, $unidad = "", $con_producto = FALSE, $id_producto = FALSE, $con_indicador_producto = FALSE, $porcentaje = FALSE, $id_indicador_producto = FALSE) {
		$insertado = FALSE;

		if ($id_proyecto && $nombre != "" && $fecha_inicio != "" && $fecha_fin != "") {
			$this->db->trans_start();

			$datos = array(
				self::ID_PROYECTO => $id_proyecto,
				self::NOMBRE => $nombre,
				self::FECHA_INICIO => $fecha_inicio,
				self::FECHA_FIN => $fecha_fin
			);

			$this->db->set($datos);

			$insertado = $this->db->insert(self::NOMBRE_TABLA);

			if ($insertado) {
				$id_actividad = $this->db->insert_id();

				if ($con_meta) {
					$this->Modelo_meta_actividad->insert_meta_actividad_st($id_actividad, $cantidad, $unidad);
				}

				if ($con_producto) {
					$this->asociar_actividad_a_producto_st($id_actividad, $id_producto);

					if ($con_indicador_producto) {
						$this->asociar_actividad_a_indicador_producto_st($id_actividad, $id_indicador_producto, $porcentaje);
					}
				}
			}

			$this->db->trans_complete();
		}

		return $insertado;
	}

	public function update_actividad($id_actividad = FALSE, $nombre = "", $fecha_inicio = "", $fecha_fin = "", $con_meta = FALSE, $cantidad = FALSE, $unidad = "", $con_producto = FALSE, $id_producto = FALSE, $con_indicador_producto = FALSE, $porcentaje = FALSE, $id_indicador_producto = FALSE) {
		$actualizado = FALSE;

		if ($id_actividad && $nombre != "" && $fecha_inicio != "" && $fecha_fin != "") {
			$this->db->trans_start();

			$datos = array(
				self::NOMBRE => $nombre,
				self::FECHA_INICIO => $fecha_inicio,
				self::FECHA_FIN => $fecha_fin
			);

			$this->db->set($datos);

			$this->db->where(self::ID, $id_actividad);

			$actualizado = $this->db->update(self::NOMBRE_TABLA);

			if ($actualizado) {
				$this->Modelo_meta_actividad->delete_meta_actividad_st($id_actividad);
				$this->desasociar_actividad_de_producto_st($id_actividad);
				$this->desasociar_actividad_de_indicador_producto_st($id_actividad);

				if ($con_meta) {
					$this->Modelo_meta_actividad->insert_meta_actividad_st($id_actividad, $cantidad, $unidad);
				}

				if ($con_producto) {
					$this->asociar_actividad_a_producto_st($id_actividad, $id_producto);

					if ($con_indicador_producto) {
						$this->asociar_actividad_a_indicador_producto_st($id_actividad, $id_indicador_producto, $porcentaje);
					}
				}
			}

			$this->db->trans_complete();
		}

		return $actualizado;
	}

	private function asociar_actividad_a_producto_st($id_actividad = FALSE, $id_producto = FALSE) {
		$asociado = FALSE;

		if ($id_actividad && $id_producto) {
			$datos = array(
				self::ID_ACTIVIDAD => $id_actividad,
				self::ID_PRODUCTO => $id_producto
			);

			$this->db->set($datos);

			$asociado = $this->db->insert(self::NOMBRE_TABLA_ASOC_PRODUCTO);
		}

		return $asociado;
	}

	private function asociar_actividad_a_indicador_producto_st($id_actividad = FALSE, $id_indicador_producto = FALSE, $porcentaje = FALSE) {
		$asociado = FALSE;

		if ($id_actividad && $id_indicador_producto && $porcentaje) {
			$datos = array(
				self::ID_ACTIVIDAD => $id_actividad,
				self::ID_INDICADOR_PRODUCTO => $id_indicador_producto,
				self::PORCENTAJE => $porcentaje
			);

			$this->db->set($datos);

			$asociado = $this->db->insert(self::NOMBRE_TABLA_ASOC_INDICADOR_PRODUCTO);
		}

		return $asociado;
	}

	private function desasociar_actividad_de_producto_st($id_actividad = FALSE) {
		$desasociado = FALSE;

		if ($id_actividad) {
			$this->db->where(self::ID_ACTIVIDAD, $id_actividad);

			$desasociado = $this->db->delete(self::NOMBRE_TABLA_ASOC_PRODUCTO);
		}

		return $desasociado;
	}

	private function desasociar_actividad_de_indicador_producto_st($id_actividad = FALSE) {
		$desasociado = FALSE;

		if ($id_actividad) {
			$this->db->where(self::ID_ACTIVIDAD, $id_actividad);

			$desasociado = $this->db->delete(self::NOMBRE_TABLA_ASOC_INDICADOR_PRODUCTO);
		}

		return $desasociado;
	}

	public function delete_actividad($id = FALSE) {
		$eliminado = FALSE;

		if ($id) {
			$this->db->trans_start();

			$this->db->where(self::ID, $id);

			$eliminado = $this->db->delete(self::NOMBRE_TABLA);

			$this->db->trans_complete();
		}

		return $eliminado;
	}

	public function finalizar_actividad($id = FALSE) {
		$finalizada = FALSE;

		if ($id) {
			$datos = array(
				self::FINALIZADA => TRUE
			);

			$this->db->set($datos);
			$this->db->where(self::NOMBRE_TABLA . "." . self::ID, $id);

			$finalizada = $this->db->update(self::NOMBRE_TABLA);
		}

		return $finalizada;
	}

	public function finalizar_actividades_de_proyecto_st($id_proyecto = FALSE) {
		$finalizadas = FALSE;

		if ($id_proyecto) {
			$datos = array(
				self::FINALIZADA => TRUE
			);

			$this->db->set($datos);

			$this->db->where(self::ID_PROYECTO, $id_proyecto);

			$finalizadas = $this->db->update(self::NOMBRE_TABLA);
		}

		return $finalizadas;
	}

}
