<?php

/*
 * Sistema de Monitoreo de proyectos para la Fundación Atica
 */

/**
 * Description of My_model
 *
 * @author Jose
 */
class MY_Model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	protected function return_result($query) {
		if (!$query) {
			return FALSE;
		} else if ($query->num_rows() == 0) {
			return FALSE;
		} else {
			return $query->result();
		}
	}

	protected function return_row($query) {
		if (!$query) {
			return FALSE;
		} else if ($query->num_rows() == 0) {
			return FALSE;
		} else {
			return $query->row();
		}
	}
	
	protected function one_to_many($column_one = "", $one = FALSE, $column_many = "", $many = FALSE) {
		if($one && $many) {
			$datos = array();
			
			if(is_array($many)) {
				foreach ($many as $other) {
					$row = array(
						$column_one => $one,
						$column_many => $other
					);
					
					$datos[] = $row;
				}
			} else {
				$datos = FALSE;
			}
			
			return $datos;
		} else {
			return FALSE;
		}
	}
	
	protected function insert_many_to_many($tabla_intermedia = "", $id_tabla_1 = "", $dato_tabla_1 = FALSE, $id_tabla_2 = "", $datos_tabla_2 = FALSE) {
		if ($tabla_intermedia != "" &&$dato_tabla_1 && $datos_tabla_2 && $id_tabla_1 != "" && $id_tabla_2 != "") {
			$insertado = FALSE;

			$datos = array();

			if ($this->is_id_array($datos_tabla_2)) {
				$datos = $this->one_to_many($id_tabla_1, $dato_tabla_1, $id_tabla_2, $datos_tabla_2);

				$insertado = $this->db->insert_batch($tabla_intermedia, $datos);
			} else {
				$datos[$id_tabla_1] = $dato_tabla_1;
				$datos[$id_tabla_2] = $datos_tabla_2;

				$insertado = $this->db->insert($tabla_intermedia, $datos);
			}

			return $insertado;
		} else {
			return FALSE;
		}
	}

}
