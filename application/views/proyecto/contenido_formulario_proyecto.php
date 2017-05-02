<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$accion = $this->uri->segment(2);
$url = "";

switch ($accion) {
	case "registrar_proyecto":
		$url = base_url("proyecto/registrar_proyecto");
		break;
}
?>

<div class="container-fluid">

	<h1><?= $titulo ?></h1>

	<form action="<?= $url ?>" method="post">

		<div class="form-group">

			<label>Nombre</label>

			<input type="text" id="nombre" name="nombre" class="form-control">

			<?= form_error("nombre") ?>

		</div>

		<div class="form-group">

			<label>Objetivo</label>

			<textarea id="objetivo" name="objetivo" class="form-control"></textarea>

			<?= form_error("objetivo") ?>

		</div>

		<div class="form-group">

			<label>Fecha de inicio</label>

			<input type="text" id="fecha_inicio" name="fecha_inicio" class="form-control">

			<?= form_error("fecha_inicio") ?>

		</div>

		<div class="form-group">

			<label>Fecha de fin</label>

			<input type="text" id="fecha_fin" name="fecha_fin" class="form-control">

			<?= form_error("fecha_fin") ?>

		</div>

		<div>

			<input type="submit" id="submit" name="submit" class="btn btn-primary">

		</div>

	</form>

</div>