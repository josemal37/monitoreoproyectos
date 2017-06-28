<?php

//conexion a la base de datos

$host = 'localhost';
$usuario = 'fundatca_mon_ati';
$password = 'monatica123';
$base_de_datos = 'fundatca_monitoreo_atica';

$mysqli = new mysqli($host, $usuario, $password, $base_de_datos);

if (!$mysqli->connect_errno) {
	$dias_restantes = array(0, 3, 5, 10);

	$actividades_proximas = obtener_actividades_proximas($dias_restantes, $mysqli);

	$mysqli->close();

	enviar_correos($actividades_proximas);

	echo ("Exito al conectarse a la base de datos.");
} else {
	echo ("Hubo un error al conectarse a la base de datos.");
}

function obtener_actividades_proximas($dias_restantes, $mysqli) {
	$actividades_proximas = FALSE;

	if (is_array($dias_restantes)) {
		$dias = implode(", ", $dias_restantes);

		$sql = "
			SELECT\n
				`actividad`.`nombre` as nombre_actividad,\n
				`actividad`.`fecha_inicio`,\n
				`actividad`.`fecha_fin`,\n
				DATEDIFF(\n
					`actividad`.`fecha_fin`,\n
					now()\n
				) AS dias_restantes,\n
				avance_actividad.avance_acumulado AS avance,\n
				meta_actividad.cantidad AS meta,\n
				meta_actividad.unidad,\n
				`usuario`.`e_mail`,\n
				`usuario`.`nombre`,\n
				`usuario`.`apellido_paterno`,\n
				`usuario`.`apellido_materno`,\n
				`proyecto`.`nombre` as nombre_proyecto\n
			FROM\n
				`actividad`\n
			LEFT JOIN `avance_actividad` ON `avance_actividad`.`id_actividad` = `actividad`.`id`\n
			LEFT JOIN `meta_actividad` ON `meta_actividad`.`id_actividad` = `actividad`.`id`\n
			LEFT JOIN `actividad_usuario` ON `actividad_usuario`.`id_actividad` = `actividad`.`id`\n
			LEFT JOIN `usuario` ON `usuario`.`id` = `actividad_usuario`.`id_usuario`\n
			LEFT JOIN `proyecto` ON `proyecto`.`id` = `actividad`.`id_proyecto`\n
			WHERE\n
				`avance_actividad`.`avance_acumulado` < `meta_actividad`.`cantidad`\n
			AND (\n
				`actividad`.`finalizada` = FALSE\n
				OR `actividad`.`finalizada` IS NULL\n
			)\n
			HAVING\n
				DATEDIFF(\n
					`actividad`.`fecha_fin`,\n
					now()\n
				) IN (" . $dias . ")\n
		";

		$resultados = $mysqli->query($sql);

		if ($resultados->num_rows > 0) {
			$actividades_proximas = array();

			while ($resultado = $resultados->fetch_assoc()) {
				$actividades_proximas[] = $resultado;
			}
		}

		$resultados->free();
	}

	return $actividades_proximas;
}

function enviar_correos($actividades_proximas) {
	foreach ($actividades_proximas as $actividad_proxima) {
		enviar_correo($actividad_proxima);
	}
}

function enviar_correo($actividad_proxima) {
	if ($actividad_proxima["e_mail"]) {

		$nombre_completo = get_nombre_completo($actividad_proxima);
		$nombre_actividad = $actividad_proxima["nombre_actividad"];
		$nombre_proyecto = $actividad_proxima["nombre_proyecto"];
		$avance = $actividad_proxima["avance"] + 0;
		$meta = $actividad_proxima["meta"] + 0;
		$unidad = $actividad_proxima["unidad"];
		$dias_restantes = $actividad_proxima["dias_restantes"];

		$para = $actividad_proxima["e_mail"];
		$titulo = "Recordatorio: " . $nombre_actividad;
		$mensaje = "Buenos días " . $nombre_completo . "\r\n<br />"
				. "\r\n<br />"
				. "Este es un mensaje para recordarle que todavía no completó el"
				. "registro de avances de la actividad " . $nombre_actividad
				. " del proyecto " . $nombre_proyecto . ".\r\n<br />"
				. "\r\n<br />"
				. "Avance: " . $avance . " " . $unidad . "\r\n<br />"
				. "Meta: " . $meta . " " . $unidad . "\r\n<br />"
				. "Días restantes: " . $dias_restantes . " días\r\n<br />"
				. "\r\n<br />"
				. "Por favor no responda este mensaje.\r\n<br />"
				. "\r\n<br />"
				. "Sistema de Monitoreo: Fundación ATICA\r\n<br />";

		$mensaje = wordwrap($mensaje, 70, "\r\n", FALSE);

		$cabeceras = "From: sistema.monitoreo@fundacionatica.org\r\n"
				. "Content-Type: text/html; charset=UTF-8";

		mail($para, $titulo, $mensaje, $cabeceras);
	}
}

function get_nombre_completo($actividad_proxima) {
	$nombre_completo = FALSE;

	if (isset($actividad_proxima->nombre)) {
		$nombre_completo = $actividad_proxima->nombre;
	}

	if ($actividad_proxima->apellido_paterno) {
		$nombre_completo .= " " . $actividad_proxima->apellido_paterno;
	}

	if ($actividad_proxima->apellido_paterno) {
		$nombre_completo .= " " . $actividad_proxima->apellido_materno;
	}

	return $nombre_completo;
}
