<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$accion = $this->uri->segment(2);
$url = "";
switch ($accion) {
	case "registrar_actividad":
		$url = base_url("actividad/registrar_actividad/" . $proyecto->id);
		break;
	case "modificar_actividad":
		$url = base_url("actividad/modificar_actividad/" . $proyecto->id . "/" . $actividad->id);
		break;
}
?>

<div class="container-fluid">

	<h1><?= $titulo ?></h1>

	<p class="text-justify"><label>Proyecto:</label> <?= $proyecto->nombre ?></p>

	<form id="form-actividad" action="<?= $url ?>" method="post">

		<div class="form-group">

			<label>Nombre</label>

			<input type="text" id="nombre" name="nombre" class="form-control" <?php if ($accion == "modificar_actividad"): ?>value="<?= $actividad->nombre ?>"<?php endif; ?>>

			<?= form_error("nombre") ?>

		</div>

		<div class="form-group">

			<label>Fecha de inicio</label>

			<input type="text" id="fecha_inicio" name="fecha_inicio" class="form-control" <?php if ($accion == "modificar_actividad"): ?>value="<?= $actividad->fecha_inicio ?>"<?php endif; ?>>

			<?= form_error("fecha_inicio") ?>

		</div>

		<div class="form-group">

			<label>Fecha de fin</label>

			<input type="text" id="fecha_fin" name="fecha_fin" class="form-control" <?php if ($accion == "modificar_actividad"): ?>value="<?= $actividad->fecha_fin ?>"<?php endif; ?>>

			<?= form_error("fecha_fin") ?>

		</div>

		<?php
		$con_meta = FALSE;

		if ($accion == "modificar_actividad" && $actividad->cantidad) {
			$con_meta = TRUE;
		}
		?>

		<div class="checkbox">

			<label><input type="checkbox" id="con-meta" name="con-meta"<?php if ($con_meta): ?>checked<?php endif; ?>>Meta</label>

		</div>

		<div id="contenedor-meta" <?php if (!$con_meta): ?>style="display: none;"<?php endif; ?>>

			<div class="form-group">

				<label>Cantidad</label>

				<input type="number" id="cantidad" name="cantidad" class="form-control" <?php if ($con_meta): ?>value="<?= $actividad->cantidad ?>"<?php endif; ?>>

				<?= form_error("cantidad") ?>

			</div>

			<div class="form-group">

				<label>Unidad</label>

				<input type="text" id="unidad" name="unidad" class="form-control" <?php if ($con_meta): ?>value="<?= $actividad->unidad ?>"<?php endif; ?>>

				<?= form_error("unidad") ?>

			</div>

		</div>

		<?php
		$con_producto = FALSE;

		if ($accion == "modificar_actividad" && $actividad->id_producto) {
			$con_producto = TRUE;
		}
		?>

		<?php if ($productos): ?>

			<div class="checkbox">

				<label><input type="checkbox" id="con-producto" name="con-producto" <?php if ($con_producto): ?>checked<?php endif; ?>>Asociar a un producto</label>

			</div>

			<div id="contenedor-producto" <?php if (!$con_producto): ?>style="display: none;"<?php endif; ?>>

				<div class="form-group">

					<label>Producto</label>

					<select id="producto" name="producto" class="form-control">

						<?php foreach ($productos as $producto): ?>

							<option value="<?= $producto->id ?>" title="<?= $producto->descripcion ?>" <?php if ($accion == "modificar_actividad" && isset($actividad->id_producto) && $producto->id == $actividad->id_producto): ?>selected<?php endif; ?>><?= $producto->descripcion ?></option>

						<?php endforeach; ?>

					</select>

				</div>

				<?php
				$con_indicador_producto = FALSE;

				if ($accion == "modificar_actividad" && $actividad->id_indicador_producto) {
					$con_indicador_producto = TRUE;
				}
				?>

				<div class="checkbox">

					<label><input type="checkbox" id="con-indicador-producto" name="con-indicador-producto" <?php if ($con_indicador_producto): ?>checked<?php endif; ?>>Asociar a un indicador de producto</label>

				</div>

				<div id="contenedor-indicador-producto" <?php if (!$con_indicador_producto): ?>style="display: none;"<?php endif; ?>>

					<div class="form-group">

						<label>Porcentaje</label>

						<input type="number" id="porcentaje" name="porcentaje" class="form-control" <?php if ($accion == "modificar_actividad" && isset($actividad->id_indicador_producto)): ?>value="<?= $actividad->porcentaje ?>"<?php endif; ?>>

						<?= form_error("porcentaje") ?>

					</div>

					<div class="form-group">

						<label>Indicador de producto</label>

						<select id="indicador-producto" name="indicador-producto" class="form-control">

							<?php if ($indicadores_producto): ?>

								<?php foreach ($indicadores_producto as $indicador_producto): ?>

									<option value="<?= $indicador_producto->id ?>" title="<?= $indicador_producto->descripcion ?>" <?php if ($accion == "modificar_actividad" && isset($actividad->id_indicador_producto) && $indicador_producto->id == $actividad->id_indicador_producto): ?>selected<?php endif; ?>><?= $indicador_producto->descripcion ?></option>

								<?php endforeach; ?>

							<?php endif; ?>

						</select>

					</div>

				</div>

			</div>

		<?php endif; ?>

		<div>

			<input type="submit" id="submit" name="submit" value="Aceptar" class="btn btn-primary">

		</div>

	</form>

</div>

<script type="text/javascript">
	$("#con-meta").on("change", function() {
		if ($(this).prop("checked")) {
			$("#contenedor-meta").show();
		} else {
			$("#contenedor-meta").hide();
		}
	});

	$("#con-indicador-producto").on("change", function() {
		if ($(this).prop("checked")) {
			$("#contenedor-indicador-producto").show();
		} else {
			$("#contenedor-indicador-producto").hide();
		}
	});

	$("#con-producto").on("change", function() {
		if ($(this).prop("checked")) {
			$("#contenedor-producto").show();
		} else {
			$("#contenedor-producto").hide();
		}
	});

	$("#producto").on("change", function() {
		var id_producto = $(this).find("option:selected").prop("value");

		$.ajax({
			url: "<?= base_url("indicador_producto/get_indicadores_de_producto_ajax") ?>",
			method: "POST",
			data: {
				id_producto: id_producto
			},
			dataType: "json"
		}).done(function(response) {
			var opciones = Array();
			for (var i = 0; i < response.length; i++) {
				var indicador_producto = response[i];
				var opcion = $("<option/>").prop("value", indicador_producto.id).html(indicador_producto.descripcion);
				opciones.push(opcion);
			}
			$("#indicador-producto").find("option").remove();
			$("#indicador-producto").append(opciones);
		});
	});
</script>

<?php if (isset($reglas_cliente)): ?>

	<script type="text/javascript">
		$("#form-actividad").validate(<?= $reglas_cliente ?>);
	</script>

<?php endif; ?>