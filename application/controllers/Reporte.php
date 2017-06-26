<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Reporte
 *
 * @author Jose
 */
class Reporte extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library("phpword");

		$this->load->model(array(
			"Modelo_proyecto",
			"Modelo_efecto",
			"Modelo_producto",
			"Modelo_resultado",
			"Modelo_resultado_clave",
			"Modelo_indicador_impacto",
			"Modelo_meta_impacto",
			"Modelo_indicador_efecto",
			"Modelo_meta_efecto",
			"Modelo_indicador_producto",
			"Modelo_meta_producto",
			"Modelo_rol_proyecto",
			"Modelo_actividad",
			"Modelo_meta_actividad",
			"Modelo_producto",
			"Modelo_indicador_producto",
			"Modelo_avance",
			"Modelo_documento_avance",
			"Modelo_usuario",
			"Modelo_actividad_usuario",
			"Modelo_proyecto_usuario",
			"Modelo_aporte",
			"Modelo_financiador",
			"Modelo_tipo_financiador"
		));

		$this->load->database("default");
	}

	public function index() {
		redirect(base_url());
	}

	public function marco_logico_docx($id_proyecto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "técnico" || $rol == "dirección") {
			if ($id_proyecto) {
				$this->generar_marco_logico_docx($id_proyecto);
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function generar_marco_logico_docx($id_proyecto) {
		$id_usuario = $this->session->userdata("id");

		if ($this->session->userdata("rol") == "dirección") {
			$id_usuario = FALSE;
		}

		$proyecto = $this->Modelo_proyecto->select_marco_logico_proyecto($id_proyecto, $id_usuario);

		if ($proyecto) {
			$seccion = $this->phpword->get_section();

			$this->add_datos_generales($proyecto, $seccion);
			$this->add_indicadores_impacto($proyecto, $seccion);
			$this->add_resultados($proyecto, $seccion);
			$this->add_resultados_clave($proyecto, $seccion);
			$this->add_efectos($proyecto, $seccion);

			$this->phpword->download("Marco Lógico - " . $proyecto->nombre . ".docx");
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	private function add_datos_generales($proyecto, $seccion) {
		$this->phpword->add_document_title($proyecto->nombre, $seccion);

		if ($proyecto->objetivo) {
			$this->phpword->add_title("Objetivo", 1, $seccion);
			$this->phpword->add_text($proyecto->objetivo, $seccion);
		}

		$this->phpword->add_title("Temporalidad", 1, $seccion);
		$this->phpword->add_text("Fecha de inicio: " . $proyecto->fecha_inicio, $seccion);
		$this->phpword->add_text("Fecha de fin: " . $proyecto->fecha_fin, $seccion);

		if ($proyecto->finalizado) {
			$this->phpword->add_text("Estado: Cerrado", $seccion);
		} else {
			$this->phpword->add_text("Estado: Vigente", $seccion);
		}

		$this->add_aportes($proyecto, $seccion);
	}

	private function add_aportes($proyecto, $seccion) {
		$id_ejecutor = $this->Modelo_tipo_financiador->select_id_ejecutor();
		$id_financiador = $this->Modelo_tipo_financiador->select_id_financiador();
		$id_otro = $this->Modelo_tipo_financiador->select_id_otro();

		if (($proyecto->nombre_rol_proyecto == "coordinador" || $this->session->userdata("rol") == "direccion") && isset($proyecto->aportes) && $proyecto->aportes) {
			$ejecutores = array();
			$financiadores = array();
			$otros = array();

			foreach ($proyecto->aportes as $aporte) {
				switch ($aporte->id_tipo_financiador) {
					case $id_ejecutor:
						$ejecutores[] = array($aporte->nombre_financiador, $aporte->concepto , $aporte->cantidad);
						break;
					case $id_financiador:
						$financiadores[] = array($aporte->nombre_financiador, $aporte->concepto, $aporte->cantidad);
						break;
					case $id_otro:
						$otros[] = array($aporte->nombre_financiador, $aporte->concepto, $aporte->cantidad);
						break;
				}
			}

			$this->phpword->add_title("Costo del proyecto", 1, $seccion);

			$cabecera = array("Institución", "Concepto", "Monto");

			if (sizeof($ejecutores) > 0) {
				$this->phpword->add_title("Ejecutores", 2, $seccion);

				$this->phpword->add_table($cabecera, $ejecutores, $seccion);
			}

			if (sizeof($financiadores) > 0) {
				$this->phpword->add_title("Financiadores", 2, $seccion);

				$this->phpword->add_table($cabecera, $financiadores, $seccion);
			}

			if (sizeof($otros) > 0) {
				$this->phpword->add_title("Otros", 2, $seccion);

				$this->phpword->add_table($cabecera, $otros, $seccion);
			}
		}
	}

	private function add_indicadores_impacto($proyecto, $seccion) {
		if ($proyecto->indicadores_impacto) {
			$this->phpword->add_title("Indicadores de impacto", 1, $seccion);

			$cabecera_indicadores_impacto = array("Descripción", "Avance", "Meta");

			$array_indicadores_impacto = array();

			foreach ($proyecto->indicadores_impacto as $indicador_impacto) {
				$fila = array(
					$indicador_impacto->descripcion,
					$indicador_impacto->avance_acumulado + 0 . " " . $indicador_impacto->unidad,
					$indicador_impacto->cantidad + 0 . " " . $indicador_impacto->unidad
				);

				$array_indicadores_impacto[] = $fila;
			}

			$this->phpword->add_table($cabecera_indicadores_impacto, $array_indicadores_impacto, $seccion);
		}
	}

	private function add_resultados($proyecto, $seccion) {
		if (isset($proyecto->resultados) && $proyecto->resultados) {
			$this->phpword->add_title("Resultados", 1, $seccion);

			foreach ($proyecto->resultados as $resultado) {
				$this->phpword->add_title($resultado->nombre, 2, $seccion);

				if ($resultado->efectos) {
					$i = 1;
					foreach ($resultado->efectos as $efecto) {
						$this->phpword->add_text("Efecto " . $i . ": " . $efecto->descripcion, $seccion);

						$i += 1;
					}
				}
			}
		}
	}

	private function add_resultados_clave($proyecto, $seccion) {
		if ($proyecto->resultados) {
			$this->phpword->add_title("Resultados clave", 1, $seccion);

			foreach ($proyecto->resultados as $resultado) {
				$this->phpword->add_title($resultado->nombre, 2, $seccion);

				if ($resultado->resultados_clave) {
					foreach ($resultado->resultados_clave as $resultado_clave) {
						$this->phpword->add_unordered_list_item($resultado_clave->descripcion, $seccion);
					}
				}
			}
		}
	}

	private function add_efectos($proyecto, $seccion) {
		if ($proyecto->resultados) {
			$existe_efectos = FALSE;

			foreach ($proyecto->resultados as $resultado) {
				if ($resultado->efectos) {
					$existe_efectos = TRUE;
					break;
				}
			}

			if ($existe_efectos) {
				$this->phpword->add_title("Efectos", 1, $seccion);
				$i = 1;

				foreach ($proyecto->resultados as $resultado) {
					if ($resultado->efectos) {
						foreach ($resultado->efectos as $efecto) {
							$this->phpword->add_title("Efecto " . $i, 2, $seccion);
							$this->phpword->add_text($efecto->descripcion, $seccion);
							$this->add_indicadores_efecto($efecto, $seccion);
							$this->add_productos($efecto, $seccion);

							$i += 1;
						}
					}
				}
			}
		}
	}

	private function add_indicadores_efecto($efecto, $seccion) {
		if ($efecto->indicadores) {
			$this->phpword->add_title("Indicadores de efecto", 3, $seccion);

			$cabecera = array("Descripción", "Avance", "Meta", "Indicador de impacto");

			$datos = array();

			foreach ($efecto->indicadores as $indicador) {
				$fila = array(
					$indicador->descripcion,
					$indicador->avance_acumulado + 0 . " " . $indicador->unidad,
					$indicador->cantidad + 0 . " " . $indicador->unidad
				);

				$indicador_impacto = "";

				if ($indicador->id_indicador_impacto) {
					$indicador_impacto = $indicador->descripcion_indicador_impacto . " (" . $indicador->porcentaje . "%)";
				}

				$fila[] = $indicador_impacto;

				$datos[] = $fila;
			}

			$this->phpword->add_table($cabecera, $datos, $seccion);
		}
	}

	private function add_productos($efecto, $seccion) {
		if ($efecto->productos) {
			$this->phpword->add_title("Productos", 3, $seccion);

			$i = 1;

			foreach ($efecto->productos as $producto) {
				$this->phpword->add_title("Producto " . $i, 4, $seccion);
				$this->phpword->add_text($producto->descripcion, $seccion);
				$this->add_indicadores_producto($producto, $seccion);

				$i += 1;
			}
		}
	}

	private function add_indicadores_producto($producto, $seccion) {
		if ($producto->indicadores) {
			$this->phpword->add_title("Indicadores de producto", 5, $seccion);

			$cabecera = array("Descripción", "Avance", "Meta", "Indicador de efecto");

			$datos = array();

			foreach ($producto->indicadores as $indicador) {
				$fila = array(
					$indicador->descripcion,
					$indicador->avance_acumulado + 0 . " " . $indicador->unidad,
					$indicador->cantidad + 0 . " " . $indicador->unidad
				);

				$indicador_efecto = "";

				if ($indicador->id_indicador_efecto) {
					$indicador_efecto = $indicador->descripcion_indicador_efecto . " (" . $indicador->porcentaje . "%)";
				}

				$fila[] = $indicador_efecto;

				$datos[] = $fila;
			}

			$this->phpword->add_table($cabecera, $datos, $seccion);
		}
	}

	public function personal_docx($id_proyecto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "técnico" || $rol == "dirección") {
			if ($id_proyecto) {
				$this->generar_personal_docx($id_proyecto);
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function generar_personal_docx($id_proyecto) {
		$id_usuario = $this->session->userdata("id");

		if ($this->session->userdata("rol") == "dirección") {
			$id_usuario = FALSE;
		}

		$proyecto = $this->Modelo_proyecto->select_proyecto_por_id($id_proyecto, $id_usuario);

		if ($proyecto) {
			$usuarios = $this->Modelo_usuario->select_usuarios_de_proyecto($id_proyecto);
			$actividades = $this->Modelo_actividad->select_actividades_de_proyecto_con_personal($id_proyecto);

			$seccion = $this->phpword->get_section();

			$this->add_datos_generales($proyecto, $seccion);
			$this->add_usuarios_de_proyecto($usuarios, $seccion);
			$this->add_responsables_de_actividades($actividades, $seccion);

			$this->phpword->download("Personal - " . $proyecto->nombre . ".docx");
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	private function add_usuarios_de_proyecto($usuarios, $seccion) {
		$this->phpword->add_title("Personal asignado", 1, $seccion);

		if ($usuarios) {
			$cabecera = array("Nombre completo", "Rol");

			$datos = array();

			foreach ($usuarios as $usuario) {
				$fila = array(
					$usuario->nombre_completo,
					$usuario->nombre_rol_proyecto
				);

				$datos[] = $fila;
			}

			$this->phpword->add_table($cabecera, $datos, $seccion);
		} else {
			$this->phpword->add_text("No se registraron usuarios para el proyecto.", $seccion);
		}
	}

	private function add_responsables_de_actividades($actividades, $seccion) {
		$this->phpword->add_title("Responsables de actividades", 1, $seccion);

		if ($actividades) {
			foreach ($actividades as $actividad) {
				$this->phpword->add_title($actividad->nombre, 2, $seccion);

				if ($actividad->usuarios) {
					$cabecera = array("Nombre completo");

					$datos = array();

					foreach ($actividad->usuarios as $usuario) {
						$fila = array(
							$usuario->nombre_completo
						);

						$datos[] = $fila;
					}

					$this->phpword->add_table($cabecera, $datos, $seccion);
				} else {
					$this->phpword->add_text("No se registró responsables para esta actividad.", $seccion);
				}
			}
		} else {
			$this->phpword->add_text("No se registraron actividades en el proyecto.", $seccion);
		}
	}

	public function actividades_docx($id_proyecto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "técnico" || $rol == "dirección") {
			if ($id_proyecto) {
				$this->generar_actividades_docx($id_proyecto);
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function generar_actividades_docx($id_proyecto) {
		$id_usuario = $this->session->userdata("id");

		if ($this->session->userdata("rol") == "dirección") {
			$id_usuario = FALSE;
		}

		$proyecto = $this->Modelo_proyecto->select_proyecto_por_id($id_proyecto, $id_usuario);

		if ($proyecto) {
			$actividades = $this->Modelo_actividad->select_actividades_de_proyecto($id_proyecto);

			$seccion = $this->phpword->get_section();

			$this->add_datos_generales($proyecto, $seccion);
			$this->add_actividades($actividades, $seccion);

			$this->phpword->download("Actividades - " . $proyecto->nombre . ".docx");
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	private function add_actividades($actividades, $seccion) {
		$this->phpword->add_title("Actividades", 1, $seccion);

		if ($actividades) {
			foreach ($actividades as $actividad) {
				$actividad->cantidad += 0;
				$actividad->avance_acumulado += 0;
				$this->phpword->add_title($actividad->nombre, 2, $seccion);
				$this->phpword->add_text("Fecha de inicio: " . $actividad->fecha_inicio, $seccion);
				$this->phpword->add_text("Fecha de fin: " . $actividad->fecha_fin, $seccion);
				$this->phpword->add_text("Meta: " . $actividad->cantidad . " " . $actividad->unidad, $seccion);
				$this->phpword->add_text("Avance: " . $actividad->avance_acumulado . " " . $actividad->unidad, $seccion);
				if ($actividad->finalizada) {
					$this->phpword->add_text("Estado: Cerrada", $seccion);
				} else {
					$this->phpword->add_text("Estado: Vigente", $seccion);
				}

				if (isset($actividad->id_producto)) {
					$this->phpword->add_title("Producto asociado", 3, $seccion);
					$this->phpword->add_text($actividad->descripcion_producto, $seccion);
				}

				if (isset($actividad->id_indicador_producto)) {
					$this->phpword->add_title("Indicador de producto asociado", 3, $seccion);
					$this->phpword->add_text($actividad->descripcion_indicador_producto . " (" . $actividad->porcentaje . " %)", $seccion);
				}
			}
		} else {
			$this->phpword->add_text("No se registraron actividades en el proyecto.", $seccion);
		}
	}

	public function avances_docx($id_proyecto = FALSE) {
		$rol = $this->session->userdata("rol");

		if ($rol == "técnico" || $rol == "dirección") {
			if ($id_proyecto) {
				$this->generar_avances_docx($id_proyecto);
			} else {
				redirect(base_url("proyecto/proyectos"));
			}
		} else {
			redirect(base_url());
		}
	}

	private function generar_avances_docx($id_proyecto) {
		$id_usuario = $this->session->userdata("id");

		if ($this->session->userdata("rol") == "dirección") {
			$id_usuario = FALSE;
		}

		$proyecto = $this->Modelo_proyecto->select_proyecto_por_id($id_proyecto, $id_usuario);

		if ($proyecto) {
			$fecha_actividades = FALSE;
			$fecha_inicio_actividades = FALSE;
			$fecha_fin_actividades = FALSE;
			$fecha_avances = FALSE;
			$fecha_inicio_avances = FALSE;
			$fecha_fin_avances = FALSE;

			if (isset($_POST["submit"])) {
				$fecha_actividades = $this->input->post("fecha-actividades") == "periodo";
				$fecha_avances = $this->input->post("fecha-avances") == "periodo";
				if ($fecha_actividades) {
					$fecha_inicio_actividades = $this->input->post("fecha-inicio-actividades");
					$fecha_fin_actividades = $this->input->post("fecha-fin-actividades");
				}
				if ($fecha_avances) {
					$fecha_inicio_avances = $this->input->post("fecha-inicio-avances");
					$fecha_fin_avances = $this->input->post("fecha-fin-avances");
				}
			}

			$actividades = $this->Modelo_actividad->select_actividades_de_proyecto_con_avances($id_proyecto, $fecha_actividades, $fecha_inicio_actividades, $fecha_fin_actividades, $fecha_avances, $fecha_inicio_avances, $fecha_fin_avances);
			$seccion = $this->phpword->get_section();

			$this->add_datos_generales($proyecto, $seccion);
			$this->add_actividades_con_avances($actividades, $seccion);

			$this->phpword->download("Avances - " . $proyecto->nombre . ".docx");
		} else {
			redirect(base_url("proyecto/proyectos"));
		}
	}

	private function add_actividades_con_avances($actividades, $seccion) {
		$this->phpword->add_title("Actividades", 1, $seccion);

		if ($actividades) {
			foreach ($actividades as $actividad) {
				$actividad->cantidad += 0;
				$actividad->avance_acumulado += 0;
				$this->phpword->add_title($actividad->nombre, 2, $seccion);
				$this->phpword->add_text("Fecha de inicio: " . $actividad->fecha_inicio, $seccion);
				$this->phpword->add_text("Fecha de fin: " . $actividad->fecha_fin, $seccion);
				$this->phpword->add_text("Meta: " . $actividad->cantidad . " " . $actividad->unidad, $seccion);
				$this->phpword->add_text("Avance: " . $actividad->avance_acumulado . " " . $actividad->unidad, $seccion);
				if ($actividad->finalizada) {
					$this->phpword->add_text("Estado: Cerrada", $seccion);
				} else {
					$this->phpword->add_text("Estado: Vigente", $seccion);
				}

				$this->add_avances($actividad, $seccion);
			}
		} else {
			$this->phpword->add_text("No se registraron actividades en el proyecto.", $seccion);
		}
	}

	private function add_avances($actividad, $seccion) {
		$this->phpword->add_title("Avances", 3, $seccion);

		$avances = $actividad->avances;

		if ($avances) {
			$cabecera = array("Fecha", "Cantidad", "Descripción");

			$datos = array();

			foreach ($avances as $avance) {
				$avance->cantidad += 0;
				$fila = array(
					$avance->fecha,
					$avance->cantidad . " " . $actividad->unidad,
					$avance->descripcion
				);

				$datos[] = $fila;
			}

			$this->phpword->add_table($cabecera, $datos, $seccion);
		} else {
			$this->phpword->add_text("No se registraron avances.", $seccion);
		}
	}

}
