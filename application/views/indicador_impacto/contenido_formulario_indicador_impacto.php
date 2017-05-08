<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$accion = $this->uri->segment(2);
$url = "";
switch ($accion) {
	case "registrar_indicador_impacto":
		$url = base_url("indicador_impacto/registrar_indicador_impacto/" . $proyecto->id);
		break;
	case "modificar_indicador_impacto":
		$url = base_url("indicador_impacto/modificar_indicador_impacto/" . $proyecto->id . "/" . $indicador_impacto->id);
		break;
}
?>

<div class="container-fluid">

	<h1><?= $titulo ?></h1>

	<p class="text-justify"><label>Proyecto:</label> <?= $proyecto->nombre ?></p>

	<form action="<?= $url ?>" method="post">

		<div class="form-group">

			<label>Descripción</label>

			<textarea id="descripcion" name="descripcion" class="form-control"><?php if ($accion == "modificar_indicador_impacto"): ?><?= $indicador_impacto->descripcion ?><?php endif; ?></textarea>

			<?= form_error("descripcion") ?>

		</div>

		<?php
		$con_meta = FALSE;

		if ($accion == "modificar_indicador_impacto" && $indicador_impacto->cantidad) {
			$con_meta = TRUE;
		}
		?>

		<div class="checkbox">

			<label><input type="checkbox" id="con-meta" name="con-meta"<?php if ($con_meta): ?>checked<?php endif; ?>>Meta</label>

		</div>

		<div id="contenedor-meta" <?php if (!$con_meta): ?>style="display: none;"<?php endif; ?>>

			<div class="form-group">

				<label>Cantidad</label>

				<input type="number" id="cantidad" name="cantidad" class="form-control" <?php if ($con_meta): ?>value="<?= $indicador_impacto->cantidad ?>"<?php endif; ?>>

			</div>

			<div class="form-group">

				<label>Unidad</label>

				<input type="text" id="unidad" name="unidad" class="form-control" <?php if ($con_meta): ?>value="<?= $indicador_impacto->unidad ?>"<?php endif; ?>>

			</div>

		</div>

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
</script>