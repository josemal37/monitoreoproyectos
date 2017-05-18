<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$accion = $this->uri->segment(2);
$url = "";
switch ($accion) {
	case "registrar_efecto":
		$url = base_url("efecto/registrar_efecto/" . $proyecto->id . "/" . $resultado->id);
		break;
	case "modificar_efecto":
		$url = base_url("efecto/modificar_efecto/" . $proyecto->id . "/" . $efecto->id);
		break;
}
?>

<div class="container-fluid">

	<h1><?= $titulo ?></h1>

	<p class="text-justify"><label>Proyecto:</label> <?= $proyecto->nombre ?></p>

	<p class="text-justify"><label>Resultado:</label> <?= $resultado->nombre ?></p>

	<form id="form-efecto" action="<?= $url ?>" method="post">

		<div class="form-group">

			<label>Descripción <span class="text-red">*</span></label>

			<textarea id="descripcion" name="descripcion" class="form-control"><?php if ($accion == "modificar_efecto"): ?><?= $efecto->descripcion ?><?php endif; ?></textarea>

			<?= form_error("descripcion") ?>

		</div>

		<div>

			<input type="submit" id="submit" name="submit" value="Aceptar" class="btn btn-primary">

		</div>

	</form>

</div>

<?php if (isset($reglas_cliente)): ?>

	<script type="text/javascript">
		$("#form-efecto").validate(<?= $reglas_cliente ?>);
	</script>

<?php endif; ?>