<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$accion = $this->uri->segment(2);
$url = "";
switch ($accion) {
	case "registrar_indicador_efecto":
		$url = base_url("indicador_efecto/registrar_indicador_efecto/" . $proyecto->id . "/" . $efecto->id);
		break;
	case "modificar_indicador_efecto":
		$url = base_url("indicador_efecto/modificar_indicador_efecto/" . $proyecto->id . "/" . $indicador_efecto->id);
		break;
}
?>

<div class="container-fluid">

	<h1><?= $titulo ?></h1>

	<p class="text-justify"><label>Proyecto:</label> <?= $proyecto->nombre ?></p>

	<p class="text-justify"><label>Efecto:</label> <?= $efecto->descripcion ?></p>

	<form id="form-indicador-efecto" action="<?= $url ?>" method="post">

		<div class="form-group">

			<label>Descripción <span class="text-red">*</span></label>

			<textarea id="descripcion" name="descripcion" class="form-control"><?php if ($accion == "modificar_indicador_efecto"): ?><?= $indicador_efecto->descripcion ?><?php endif; ?></textarea>

			<?= form_error("descripcion") ?>

		</div>

		<?php
		$con_meta = FALSE;

		if ($accion == "modificar_indicador_efecto" && $indicador_efecto->cantidad) {
			$con_meta = TRUE;
		}
		?>

		<div class="checkbox">

			<label><input type="checkbox" id="con-meta" name="con-meta"<?php if ($con_meta): ?>checked<?php endif; ?>>Meta</label>

		</div>

		<p class="text-info">En caso de no registrar una meta se establecerá la meta por defecto. (<?= $cantidad_meta_por_defecto ?> <?= $unidad_meta_por_defecto ?>)</p>

		<div id="contenedor-meta" <?php if (!$con_meta): ?>style="display: none;"<?php endif; ?>>

			<div class="form-group">

				<label>Cantidad <span class="text-red">*</span></label>

				<input type="number" id="cantidad" name="cantidad" class="form-control" <?php if ($con_meta): ?>value="<?= $indicador_efecto->cantidad ?>"<?php endif; ?>>

				<?= form_error("cantidad") ?>

			</div>

			<div class="form-group">

				<label>Unidad <span class="text-red">*</span></label>

				<input type="text" id="unidad" name="unidad" class="form-control" <?php if ($con_meta): ?>value="<?= $indicador_efecto->unidad ?>"<?php endif; ?>>

				<?= form_error("unidad") ?>

			</div>

		</div>

		<?php
		$con_indicador_impacto = FALSE;

		if ($accion == "modificar_indicador_efecto" && $indicador_efecto->id_indicador_impacto) {
			$con_indicador_impacto = TRUE;
		}
		?>

		<?php if ($indicadores_impacto): ?>

			<div id="checkbox" class="checkbox">

				<label><input type="checkbox" id="con-indicador-impacto" name="con-indicador-impacto"<?php if ($con_indicador_impacto): ?>checked<?php endif; ?>>Asociar a un indicador de impacto</label>

			</div>

			<div id="contenedor-indicador-impacto" <?php if (!$con_indicador_impacto): ?>style="display: none;"<?php endif; ?>>

				<div class="form-group">

					<label>Indicador de impacto <span class="text-red">*</span></label>

					<select id="indicador-impacto" name="indicador-impacto" class="form-control">

						<?php if ($indicadores_impacto): ?>

							<?php foreach ($indicadores_impacto as $indicador_impacto): ?>

								<?php
								$porcentaje_disponible = 100 - $indicador_impacto->porcentaje_acumulado;

								if (isset($indicador_efecto) && $indicador_impacto->id == $indicador_efecto->id_indicador_impacto) {
									$porcentaje_disponible += $indicador_efecto->porcentaje;
								}
								?>

								<option value="<?= $indicador_impacto->id ?>" data-porcentaje-disponible="<?= $porcentaje_disponible ?>" <?php if (isset($indicador_efecto) && $indicador_impacto->id == $indicador_efecto->id_indicador_impacto): ?>selected<?php endif; ?> <?php if ($porcentaje_disponible === 0): ?>disabled<?php endif; ?>>

									<?= $indicador_impacto->descripcion . " (" . $porcentaje_disponible . " %)" ?>

								</option>

							<?php endforeach; ?>

						<?php endif; ?>

					</select>

					<?= form_error("indicador-impacto") ?>

				</div>

				<div class="form-group">

					<label>Porcentaje que aporta al indicador de impacto <span class="text-red">*</span></label>

					<p class="text-info">Porcentaje disponible: <span id="porcentaje-disponible"></span> %</p>

					<input type="number" id="porcentaje" name="porcentaje" class="form-control" <?php if ($con_indicador_impacto): ?>value="<?= $indicador_efecto->porcentaje ?>"<?php endif; ?>>

					<?= form_error("porcentaje") ?>

				</div>

			</div>

		<?php endif; ?>

		<div>

			<input type="submit" id="submit" name="submit" value="Aceptar" class="btn btn-primary">

		</div>

	</form>

</div>

<script type="text/javascript">
    $("#con-meta").on("change", function () {
        if ($(this).prop("checked")) {
            $("#contenedor-meta").show();
        } else {
            $("#contenedor-meta").hide();
        }
    });

    $("#con-indicador-impacto").on("change", function () {
        if ($(this).prop("checked")) {
            $("#contenedor-indicador-impacto").show();
        } else {
            $("#contenedor-indicador-impacto").hide();
        }
    });

    $("#indicador-impacto").on("change", function () {
        var porcentaje_disponible = $("#indicador-impacto").find("option:selected").data("porcentaje-disponible");
        $("#porcentaje-disponible").html(porcentaje_disponible);
        $("#porcentaje").rules("remove", "range");
        $("#porcentaje").rules("add", {"range": [1, porcentaje_disponible]});
    });

    var porcentaje_inicial = $("#indicador-impacto").find("option:selected").data("porcentaje-disponible");

    if (porcentaje_inicial === undefined) {
        $("#con-indicador-impacto").attr("disabled", true);
        $("#checkbox").append("<p class='text-info'>Todos los indicadores de impacto estan asociados al 100 %</p>");
    } else {
        $("#porcentaje-disponible").html(porcentaje_inicial);
        $("#porcentaje").rules("remove", "range");
        $("#porcentaje").rules("add", {"range": [1, porcentaje_inicial]});
    }

</script>

<?php if (isset($reglas_cliente)): ?>

	<script type="text/javascript">
	    $("#form-indicador-efecto").validate(<?= $reglas_cliente ?>);
	</script>

<?php endif; ?>