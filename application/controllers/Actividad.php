<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of Actividad
 *
 * @author Jose
 */
require_once 'Coordinador.php';

class Actividad extends Coordinador {

	const CANTIDAD_META_POR_DEFECTO = 100;
	const UNIDAD_META_POR_DEFECTO = "%";

	public function __construct() {
		parent::__construct();

		$this->load->library(array("Actividad_validacion"));
	}

	public function index() {
		$this->editar_actividades();
	}

	public function ver_actividades($id_proyecto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado" || $rol == "dirección") {
			if ($id_proyecto) {
				$this->cargar_vista_ver_actividades($id_proyecto);
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_ver_actividades($id_proyecto) {
		$id_usuario = $this->session->userdata("id");

		if ($this->session->userdata("rol") == "dirección") {
			$id_usuario = FALSE;
		}

		$proyecto = $this->Modelo_proyecto->select_proyecto_por_id($id_proyecto, $id_usuario);

		if ($proyecto) {
			$titulo = "Actividades";
			$actividades = $this->Modelo_actividad->select_actividades_de_proyecto($id_proyecto);

			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;
			$datos["actividades"] = $actividades;
			$datos["cantidad_meta_por_defecto"] = self::CANTIDAD_META_POR_DEFECTO;
			$datos["unidad_meta_por_defecto"] = self::UNIDAD_META_POR_DEFECTO;

			$this->load->view("actividad/actividades", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	public function editar_actividades($id_proyecto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto) {
				$this->cargar_vista_actividades($id_proyecto);
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_actividades($id_proyecto) {
		$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);

		if ($proyecto && !$proyecto->finalizado) {
			$titulo = "Actividades";
			$actividades = $this->Modelo_actividad->select_actividades_de_proyecto($id_proyecto);

			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;
			$datos["actividades"] = $actividades;
			$datos["cantidad_meta_por_defecto"] = self::CANTIDAD_META_POR_DEFECTO;
			$datos["unidad_meta_por_defecto"] = self::UNIDAD_META_POR_DEFECTO;

			$this->load->view("actividad/actividades", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	public function registrar_actividad($id_proyecto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto) {
				if (isset($_POST["submit"])) {
					$this->registrar_actividad_bd($id_proyecto);
				} else {
					$this->cargar_vista_registrar_actividad($id_proyecto);
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_registrar_actividad($id_proyecto) {
		$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);

		if ($proyecto && !$proyecto->finalizado) {
			$titulo = "Registrar actividad";
			$productos = $this->Modelo_producto->select_productos_de_proyecto($id_proyecto);
			$reglas_cliente = $this->actividad_validacion->get_reglas_cliente(array("nombre", "fecha_inicio", "fecha_fin", "cantidad", "unidad", "producto", "porcentaje", "indicador-producto"));
			$indicadores_producto = FALSE;

			if ($productos) {
				$indicadores_producto = $this->Modelo_indicador_producto->select_indicadores_producto_de_producto($productos[0]->id);
			}

			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;
			$datos["productos"] = $productos;
			$datos["indicadores_producto"] = $indicadores_producto;
			$datos["reglas_cliente"] = $reglas_cliente;
			$datos["cantidad_meta_por_defecto"] = self::CANTIDAD_META_POR_DEFECTO;
			$datos["unidad_meta_por_defecto"] = self::UNIDAD_META_POR_DEFECTO;

			$this->load->view("actividad/formulario_actividad", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	private function registrar_actividad_bd($id_proyecto) {
		$nombre = $this->input->post("nombre");
		$fecha_inicio = $this->input->post("fecha_inicio");
		$fecha_fin = $this->input->post("fecha_fin");
		$con_meta = $this->input->post("con-meta") == "on";
		$cantidad = $this->input->post("cantidad");
		$unidad = $this->input->post("unidad");
		$con_producto = $this->input->post("con-producto") == "on";
		$id_producto = $this->input->post("producto");
		$con_indicador_producto = $this->input->post("con-indicador-producto") == "on";
		$porcentaje = $this->input->post("porcentaje");
		$id_indicador_producto = $this->input->post("indicador-producto");

		$array_validacion = array("nombre", "fecha_inicio", "fecha_fin");

		if ($con_meta) {
			$array_validacion[] = "cantidad";
			$array_validacion[] = "unidad";
		} else {
			$con_meta = TRUE;
			$cantidad = self::CANTIDAD_META_POR_DEFECTO;
			$unidad = self::UNIDAD_META_POR_DEFECTO;
		}

		if ($con_producto) {
			$array_validacion[] = "producto";

			if ($con_indicador_producto) {
				$array_validacion[] = "porcentaje";
				$array_validacion[] = "indicador-producto";
			}
		}

		if ($this->actividad_validacion->validar($array_validacion)) {
			$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);

			if ($proyecto && !$proyecto->finalizado) {
				if ($this->Modelo_actividad->insert_actividad($id_proyecto, $nombre, $fecha_inicio, $fecha_fin, $con_meta, $cantidad, $unidad, $con_producto, $id_producto, $con_indicador_producto, $porcentaje, $id_indicador_producto)) {
					redirect(base_url("actividad/editar_actividades/" . $id_proyecto));
				} else {
					redirect(base_url("actividad/registrar_actividad/" . $id_proyecto), "refresh");
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_actividad($id_proyecto);
		}
	}

	public function modificar_actividad($id_proyecto = FALSE, $id_actividad = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto && $id_actividad) {
				if (isset($_POST["submit"])) {
					$this->modificar_actividad_bd($id_proyecto, $id_actividad);
				} else {
					$this->cargar_vista_modificar_actividad($id_proyecto, $id_actividad);
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function cargar_vista_modificar_actividad($id_proyecto, $id_actividad) {
		$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
		$actividad = $this->get_actividad_de_proyecto($id_actividad, $id_proyecto);

		if ($proyecto && $actividad && !$actividad->finalizada) {
			$titulo = "Modificar actividad";
			$productos = $this->Modelo_producto->select_productos_de_proyecto($id_proyecto);
			$reglas_cliente = $this->actividad_validacion->get_reglas_cliente(array("nombre", "fecha_inicio", "fecha_fin", "cantidad", "unidad", "producto", "porcentaje", "indicador-producto"));
			$indicadores_producto = FALSE;

			if ($productos) {
				if (isset($actividad->id_producto)) {
					$indicadores_producto = $this->Modelo_indicador_producto->select_indicadores_producto_de_producto($actividad->id_producto);
				} else {
					$indicadores_producto = $this->Modelo_indicador_producto->select_indicadores_producto_de_producto($productos[0]->id);
				}
			}

			$datos = array();
			$datos["titulo"] = $titulo;
			$datos["proyecto"] = $proyecto;
			$datos["actividad"] = $actividad;
			$datos["productos"] = $productos;
			$datos["indicadores_producto"] = $indicadores_producto;
			$datos["reglas_cliente"] = $reglas_cliente;
			$datos["cantidad_meta_por_defecto"] = self::CANTIDAD_META_POR_DEFECTO;
			$datos["unidad_meta_por_defecto"] = self::UNIDAD_META_POR_DEFECTO;

			$this->load->view("actividad/formulario_actividad", $datos);
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	private function modificar_actividad_bd($id_proyecto, $id_actividad) {
		$nombre = $this->input->post("nombre");
		$fecha_inicio = $this->input->post("fecha_inicio");
		$fecha_fin = $this->input->post("fecha_fin");
		$con_meta = $this->input->post("con-meta") == "on";
		$cantidad = $this->input->post("cantidad");
		$unidad = $this->input->post("unidad");
		$con_producto = $this->input->post("con-producto") == "on";
		$id_producto = $this->input->post("producto");
		$con_indicador_producto = $this->input->post("con-indicador-producto") == "on";
		$porcentaje = $this->input->post("porcentaje");
		$id_indicador_producto = $this->input->post("indicador-producto");

		$array_validacion = array("nombre", "fecha_inicio", "fecha_fin");

		if ($con_meta) {
			$array_validacion[] = "cantidad";
			$array_validacion[] = "unidad";
		} else {
			$con_meta = TRUE;
			$cantidad = self::CANTIDAD_META_POR_DEFECTO;
			$unidad = self::UNIDAD_META_POR_DEFECTO;
		}

		if ($con_producto) {
			$array_validacion[] = "producto";

			if ($con_indicador_producto) {
				$array_validacion[] = "porcentaje";
				$array_validacion[] = "indicador-producto";
			}
		}

		if ($this->actividad_validacion->validar($array_validacion)) {
			$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
			$actividad = $this->get_actividad_de_proyecto($id_actividad, $id_proyecto);

			if ($proyecto && $actividad && !$actividad->finalizada) {
				if ($this->Modelo_actividad->update_actividad($id_actividad, $nombre, $fecha_inicio, $fecha_fin, $con_meta, $cantidad, $unidad, $con_producto, $id_producto, $con_indicador_producto, $porcentaje, $id_indicador_producto)) {
					redirect(base_url("actividad/editar_actividades/" . $id_proyecto));
				} else {
					redirect(base_url("actividad/modificar_actividad/" . $id_proyecto . "/" . $id_actividad), "refresh");
				}
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			unset($_POST["submit"]);
			$this->registrar_actividad($id_proyecto);
		}
	}

	public function eliminar_actividad($id_proyecto = FALSE, $id_actividad = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {
			if ($id_proyecto && $id_actividad) {
				$this->eliminar_actividad_bd($id_proyecto, $id_actividad);
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function eliminar_actividad_bd($id_proyecto, $id_actividad) {
		$proyecto = $this->get_proyecto_de_coordinador($id_proyecto);
		$actividad = $this->get_actividad_de_proyecto($id_actividad, $id_proyecto);

		if ($proyecto && $actividad && !$actividad->finalizada) {
			if ($this->Modelo_actividad->delete_actividad($id_actividad)) {
				redirect(base_url("actividad/editar_actividades/" . $id_proyecto));
			} else {
				redirect(base_url("actividad/editar_actividades/" . $id_proyecto), "refresh");
			}
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	public function cerrar_actividad($id_proyecto = FALSE, $id_actividad = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "empleado") {

			if ($id_proyecto && $id_actividad) {
				$this->cerrar_actividad_bd($id_proyecto, $id_actividad);
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function cerrar_actividad_bd($id_proyecto, $id_actividad) {
		$id_usuario = $this->session->userdata("id");
		$proyecto = $this->Modelo_proyecto->select_proyecto_por_id($id_proyecto, $id_usuario);
		$actividad = $this->get_actividad_de_proyecto($id_actividad, $id_proyecto, $id_usuario);

		if ($proyecto && $actividad) {
			if ($this->Modelo_actividad->finalizar_actividad($id_actividad)) {
				redirect(base_url("actividad/ver_actividades/" . $id_proyecto));
			} else {
				redirect(base_url("actividad/ver_actividades/" . $id_proyecto), "refresh");
			}
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

}
