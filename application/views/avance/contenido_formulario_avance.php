<div class="container-fluid">

	<h1><?= $titulo ?></h1>

	<p><label>Proyecto:</label> <?= $proyecto->nombre ?></p>

	<p><label>Actividad:</label> <?= $actividad->nombre ?></p>

	<?php if ($actividad->id_meta_actividad): ?>

		<p><label>Meta:</label> <?= $actividad->cantidad ?> <?= $actividad->unidad ?></p>

	<?php endif; ?>

	<form id="form-avance" action="" method="post" enctype="multipart/form-data">

		<div class="form-group">

			<label>Cantidad</label>

			<input type="number" id="cantidad" name="cantidad" class="form-control">

			<?= form_error("cantidad") ?>

		</div>

		<div class="form-group">

			<label>Descripción</label>

			<textarea id="descripcion" name="descripcion" class="form-control"></textarea>

			<?= form_error("descripcion") ?>

		</div>

		<div class="checkbox">

			<label><input type="checkbox" id="con-archivos" name="con-archivos">Adjuntar archivos</label>

		</div>

		<div id="contenedor-archivos" style="display: none;">

			<div class="form-group">

				<input type="file" name="archivos[]" multiple>

			</div>

			<?php if ($this->session->flashdata("error_archivo")): ?>

				<label class="text-danger"><?= $this->session->flashdata("error_archivo") ?></label>

			<?php endif; ?>

		</div>

		<div>

			<input type="submit" id="submit" name="submit" class="btn btn-primary" value="Aceptar">

		</div>

	</form>

</div>

<script type="text/javascript">
    $("#con-archivos").on("change", function () {
        if ($(this).prop("checked")) {
            $("#contenedor-archivos").show();
        } else {
            $("#contenedor-archivos").hide();
        }
    });
</script>