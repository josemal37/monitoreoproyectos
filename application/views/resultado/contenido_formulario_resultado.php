<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$accion = $this->uri->segment(2);
$url = "";
switch ($accion) {
	case "registrar_resultado":
		$url = base_url("resultado/registrar_resultado/" . $proyecto->id);
		break;
	case "modificar_resultado":
		$url = base_url("resultado/modificar_resultado/" . $proyecto->id . "/" . $resultado->id);
		break;
}
?>

<div class="container-fluid">

	<h1><?= $titulo ?></h1>

	<p class="text-justify"><label>Proyecto:</label> <?= $proyecto->nombre ?></p>

	<form id="form-resultado" action="<?= $url ?>" method="post">

		<div class="form-group">

			<label>Nombre</label>

			<input type="text" id="nombre" name="nombre" class="form-control" <?php if ($accion == "modificar_resultado"): ?>value="<?= $resultado->nombre ?>"<?php endif; ?>>

			<?= form_error("nombre") ?>

		</div>

		<div>

			<input type="submit" id="submit" name="submit" value="Aceptar" class="btn btn-primary">

		</div>

	</form>

</div>

<?php if (isset($reglas_cliente)): ?>

	<script type="text/javascript">
		$("#form-resultado").validate(<?= $reglas_cliente ?>);
	</script>

<?php endif; ?>