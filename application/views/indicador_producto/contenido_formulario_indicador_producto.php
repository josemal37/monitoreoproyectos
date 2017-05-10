<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$accion = $this->uri->segment(2);
$url = "";
switch ($accion) {
	case "registrar_indicador_producto":
		$url = base_url("indicador_producto/registrar_indicador_producto/" . $proyecto->id . "/" . $producto->id);
		break;
	case "modificar_indicador_producto":
		$url = base_url("indicador_producto/modificar_indicador_producto/" . $proyecto->id . "/" . $indicador_producto->id);
		break;
}
?>

<div class="container-fluid">

	<h1><?= $titulo ?></h1>

	<p class="text-justify"><label>Proyecto:</label> <?= $proyecto->nombre ?></p>

	<p class="text-justify"><label>Producto:</label> <?= $producto->descripcion ?></p>

	<form action="<?= $url ?>" method="post">

		<div class="form-group">

			<label>Descripción</label>

			<textarea id="descripcion" name="descripcion" class="form-control"><?php if ($accion == "modificar_indicador_producto"): ?><?= $indicador_producto->descripcion ?><?php endif; ?></textarea>

			<?= form_error("descripcion") ?>

		</div>

		<?php
		$con_meta = FALSE;

		if ($accion == "modificar_indicador_producto" && $indicador_producto->cantidad) {
			$con_meta = TRUE;
		}
		?>

		<div class="checkbox">

			<label><input type="checkbox" id="con-meta" name="con-meta"<?php if ($con_meta): ?>checked<?php endif; ?>>Meta</label>

		</div>

		<div id="contenedor-meta" <?php if (!$con_meta): ?>style="display: none;"<?php endif; ?>>

			<div class="form-group">

				<label>Cantidad</label>

				<input type="number" id="cantidad" name="cantidad" class="form-control" <?php if ($con_meta): ?>value="<?= $indicador_producto->cantidad ?>"<?php endif; ?>>

				<?= form_error("cantidad") ?>

			</div>

			<div class="form-group">

				<label>Unidad</label>

				<input type="text" id="unidad" name="unidad" class="form-control" <?php if ($con_meta): ?>value="<?= $indicador_producto->unidad ?>"<?php endif; ?>>

				<?= form_error("unidad") ?>

			</div>

		</div>

		<?php
		$con_indicador_efecto = FALSE;

		if ($accion == "modificar_indicador_producto" && $indicador_producto->id_indicador_efecto) {
			$con_indicador_efecto = TRUE;
		}
		?>

		<?php if ($indicadores_efecto): ?>

			<div class="checkbox">

				<label><input type="checkbox" id="con-indicador-efecto" name="con-indicador-efecto"<?php if ($con_indicador_efecto): ?>checked<?php endif; ?>>Asociar a un indicador de efecto</label>

			</div>

			<div id="contenedor-indicador-efecto" <?php if (!$con_indicador_efecto): ?>style="display: none;"<?php endif; ?>>

				<div class="form-group">

					<label>Porcentaje que aporta al indicador de efecto</label>

					<input type="number" id="porcentaje" name="porcentaje" class="form-control" <?php if ($con_indicador_efecto): ?>value="<?= $indicador_producto->porcentaje ?>"<?php endif; ?>>

					<?= form_error("porcentaje") ?>

				</div>

				<div class="form-group">

					<label>Indicador de efecto</label>

					<select id="indicador-efecto" name="indicador-efecto" class="form-control">

						<?php if ($indicadores_efecto): ?>

							<?php foreach ($indicadores_efecto as $indicador_efecto): ?>

								<option value="<?= $indicador_efecto->id ?>" <?php if (isset($indicador_producto) && $indicador_efecto->id == $indicador_producto->id_indicador_efecto): ?>selected<?php endif; ?>><?= $indicador_efecto->descripcion ?></option>

							<?php endforeach; ?>

						<?php endif; ?>

					</select>

					<?= form_error("indicador-efecto") ?>

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

	$("#con-indicador-efecto").on("change", function() {
		if ($(this).prop("checked")) {
			$("#contenedor-indicador-efecto").show();
		} else {
			$("#contenedor-indicador-efecto").hide();
		}
	});
</script>