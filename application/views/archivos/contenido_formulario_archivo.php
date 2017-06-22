<div class="container-fluid">

	<h1><?= $titulo ?></h1>

	<p><label>Proyecto:</label> <?= $proyecto->nombre ?></p>

	<p><label>Actividad:</label> <?= $actividad->nombre ?></p>

	<h2>Avance</h2>

	<p><label>Fecha:</label> <?= $avance->fecha ?></p>

	<p><label>Cantidad:</label> <?= $avance->cantidad ?></p>

	<p><label>Descripción</label> <?= $avance->descripcion ?></p>

	<form id="form-archivo" action="<?= base_url("archivos/registrar_archivo/" . $proyecto->id . "/" . $avance->id) ?>" method="post" enctype="multipart/form-data">

		<div class="form-group">

			<input type="file" name="archivos[]" multiple>

		</div>

		<?php if ($this->session->flashdata("error_archivo")): ?>

			<label class="text-danger"><?= $this->session->flashdata("error_archivo") ?></label>

		<?php endif; ?>

		<p class="text-info"><label>Extensiones validas:</label> <?= str_replace("|", ", ", $extensiones_validas) . "." ?></p>

		<div>

			<input type="submit" id="submit" name="submit" class="btn btn-primary" value="Aceptar">

		</div>

	</form>

</div>

<?php if (isset($reglas_cliente)): ?>

	<script type="text/javascript">
	    $("#form-archivo").validate(<?= $reglas_cliente ?>);
	</script>

<?php endif; ?>