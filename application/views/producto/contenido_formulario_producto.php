<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$accion = $this->uri->segment(2);
$url = "";
switch ($accion) {
	case "registrar_producto":
		$url = base_url("producto/registrar_producto/" . $proyecto->id . "/" . $efecto->id);
		break;
	case "modificar_producto":
		$url = base_url("producto/modificar_producto/" . $proyecto->id . "/" . $producto->id);
		break;
}
?>

<div class="container-fluid">

	<h1><?= $titulo ?></h1>

	<p class="text-justify"><label>Proyecto:</label> <?= $proyecto->nombre ?></p>

	<p class="text-justify"><label>Efecto:</label> <?= $efecto->descripcion ?></p>

	<form id="form-producto" action="<?= $url ?>" method="post">

		<div class="form-group">

			<label>Descripción</label>

			<textarea id="descripcion" name="descripcion" class="form-control"><?php if ($accion == "modificar_producto"): ?><?= $producto->descripcion ?><?php endif; ?></textarea>

			<?= form_error("descripcion") ?>

		</div>

		<div>

			<input type="submit" id="submit" name="submit" value="Aceptar" class="btn btn-primary">

		</div>

	</form>

</div>

<?php if (isset($reglas_cliente)): ?>

	<script type="text/javascript">
		$("#form-producto").validate(<?= $reglas_cliente ?>);
	</script>

<?php endif; ?>