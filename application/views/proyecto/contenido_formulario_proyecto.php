<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$accion = $this->uri->segment(2);
$url = "";

switch ($accion) {
	case "registrar_proyecto":
		$url = base_url("proyecto/registrar_proyecto");
		break;
	case "modificar_proyecto":
		$url = base_url("proyecto/modificar_proyecto/" . $proyecto->id);
		break;
}
?>

<div class="container-fluid">

	<h1><?= $titulo ?></h1>

	<form id="form-proyecto" action="<?= $url ?>" method="post">

		<div class="form-group">

			<label>Nombre <span class="text-red">*</span></label>

			<input type="text" id="nombre" name="nombre" class="form-control" <?php if ($accion == "modificar_proyecto"): ?>value="<?= $proyecto->nombre ?>"<?php endif; ?>>

			<?= form_error("nombre") ?>

		</div>

		<div class="form-group">

			<label>Objetivo</label>

			<textarea id="objetivo" name="objetivo" class="form-control"> <?php if ($accion == "modificar_proyecto"): ?><?= $proyecto->objetivo ?><?php endif; ?></textarea>

			<?= form_error("objetivo") ?>

		</div>

		<div class="form-group">

			<label>Fecha de inicio <span class="text-red">*</span></label>

			<input type="text" id="fecha_inicio" name="fecha_inicio" class="form-control" <?php if ($accion == "modificar_proyecto"): ?>value="<?= $proyecto->fecha_inicio ?>"<?php endif; ?>>

			<?= form_error("fecha_inicio") ?>

		</div>

		<div class="form-group">

			<label>Fecha de fin <span class="text-red">*</span></label>

			<input type="text" id="fecha_fin" name="fecha_fin" class="form-control" <?php if ($accion == "modificar_proyecto"): ?>value="<?= $proyecto->fecha_fin ?>"<?php endif; ?>>

			<?= form_error("fecha_fin") ?>

		</div>

		<?php if ($accion == "modificar_proyecto"): ?>

			<input type="hidden" id="id" name="id" value="<?= $proyecto->id ?>">

		<?php endif; ?>

		<?php if (isset($financiadores) && $financiadores): ?>

			<div class="checkbox">

				<label><input type="checkbox" id="con-financiadores" name="con-financiadores"> Registrar costo del proyecto</label>

			</div>

			<div id="contenedor-financiadores" style="display: none;">

				<div>

					<label>Ejecutores</label>

					<ol id="lista-ejecutores"></ol>

					<p>

						<button id="aniadir-ejecutores" class="btn btn-success btn-xs aniadir-financiador"><span class="glyphicon glyphicon-plus"></span></button>

					</p>

				</div>

				<div>

					<label>Financiadores</label>

					<ol id="lista-financiadores"></ol>

					<p>

						<button id="aniadir-financiadores" class="btn btn-success btn-xs aniadir-financiador"><span class="glyphicon glyphicon-plus"></span></button>

					</p>

				</div>

				<div>

					<label>Otros</label>

					<ol id="lista-otros"></ol>

					<p>

						<button id="aniadir-otros" class="btn btn-success btn-xs aniadir-financiador"><span class="glyphicon glyphicon-plus"></span></button>

					</p>

				</div>

			</div>

			<div id="contenedor-form-financiadores" style="display: none;">

				<div class="form-financiador">

					<div class="form-group">

						<label>Institución <span class="text-red">*</span></label>

						<select class="form-control institucion">

							<?php foreach ($financiadores as $financiador): ?>

								<option value="<?= $financiador->id ?>"><?= $financiador->nombre ?></option>

							<?php endforeach; ?>

						</select>

					</div>

					<div class="form-group">

						<label>Monto (Bs.) <span class="text-red">*</span></label>

						<input type="number" class="form-control cantidad">

					</div>

					<div class="form-group">

						<label>Concepto <span class="text-red">*</span></label>

						<textarea class="form-control concepto"></textarea>

					</div>

					<div>

						<button class="btn btn-danger btn-xs eliminar-financiador"><span class="glyphicon glyphicon-trash"></span></button>

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
    $("#fecha_inicio").datepicker({dateFormat: 'yy-mm-dd'});
    $("#fecha_fin").datepicker({dateFormat: 'yy-mm-dd'});

    $('#fecha_inicio').change(function () {
        var fecha_inicio = $("#fecha_inicio").datepicker("getDate");
        $("#fecha_fin").datepicker("option", "minDate", fecha_inicio);
    });
    $('#fecha_fin').change(function () {
        var fecha_fin = $("#fecha_fin").datepicker("getDate");
        $("#fecha_inicio").datepicker("option", "maxDate", fecha_fin);
    });

    $("#con-financiadores").on("change", function () {
        if ($(this).prop("checked")) {
            $("#contenedor-financiadores").show();
        } else {
            $("#contenedor-financiadores").hide();
        }
    });

    $(".aniadir-financiador").on("click", function (e) {
        e.preventDefault();
        var form_financiador = $("#contenedor-form-financiadores .form-financiador").clone();
        var institucion = $(form_financiador).find(".institucion");
        var cantidad = $(form_financiador).find(".cantidad");
        var concepto = $(form_financiador).find(".concepto");

        var li = $("<li>");
        var id = $(this).attr("id");
        switch (id) {
            case "aniadir-ejecutores":
                institucion.attr("name", "instituciones-ejecutores[]");
                cantidad.attr("name", "cantidades-ejecutores[]");
                concepto.attr("name", "conceptos-ejecutores[]");
                li.append(form_financiador);
                $("#lista-ejecutores").append(li);
                break;
            case "aniadir-financiadores":
                institucion.attr("name", "instituciones-financiadores[]");
                cantidad.attr("name", "cantidades-financiadores[]");
                concepto.attr("name", "conceptos-financiadores[]");
                li.append(form_financiador);
                $("#lista-financiadores").append(li);
                break;
            case "aniadir-otros":
                institucion.attr("name", "instituciones-otros[]");
                cantidad.attr("name", "cantidades-otros[]");
                concepto.attr("name", "conceptos-otros[]");
                li.append(form_financiador);
                $("#lista-otros").append(li);
                break;

        }
    });

    $("#contenedor-financiadores").on("click", ".eliminar-financiador", function (e) {
        e.preventDefault();
        $(this).closest("li").remove();
    });
</script>

<?php if (isset($reglas_cliente)): ?>

	<script type="text/javascript">
	    $("#form-proyecto").validate(<?= $reglas_cliente ?>);
	</script>

<?php endif; ?>
