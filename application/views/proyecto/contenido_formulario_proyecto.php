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

	<form action="<?= $url ?>" method="post">

		<div class="form-group">

			<label>Nombre</label>

			<input type="text" id="nombre" name="nombre" class="form-control" <?php if ($accion == "modificar_proyecto"): ?>value="<?= $proyecto->nombre ?>"<?php endif; ?>>

			<?= form_error("nombre") ?>

		</div>

		<div class="form-group">

			<label>Objetivo</label>

			<textarea id="objetivo" name="objetivo" class="form-control"> <?php if ($accion == "modificar_proyecto"): ?><?= $proyecto->objetivo ?><?php endif; ?></textarea>

			<?= form_error("objetivo") ?>

		</div>

		<div class="form-group">

			<label>Fecha de inicio</label>

			<input type="text" id="fecha_inicio" name="fecha_inicio" class="form-control" <?php if ($accion == "modificar_proyecto"): ?>value="<?= $proyecto->fecha_inicio ?>"<?php endif; ?>>

			<?= form_error("fecha_inicio") ?>

		</div>

		<div class="form-group">

			<label>Fecha de fin</label>

			<input type="text" id="fecha_fin" name="fecha_fin" class="form-control" <?php if ($accion == "modificar_proyecto"): ?>value="<?= $proyecto->fecha_fin ?>"<?php endif; ?>>

			<?= form_error("fecha_fin") ?>

		</div>

		<?php if ($accion == "modificar_proyecto"): ?>

			<input type="hidden" id="id" name="id" value="<?= $proyecto->id ?>">

		<?php endif; ?>

		<div>

			<input type="submit" id="submit" name="submit" class="btn btn-primary">

		</div>

	</form>

</div>