<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$accion = $this->uri->segment(2);
$url = "";

switch ($accion) {
	case "registrar_financiador":
		$url = base_url("financiador/registrar_financiador");
		break;
	case "modificar_financiador":
		$url = base_url("financiador/modificar_financiador/" . $financiador->id);
		break;
}
?>

<div class="container-fluid">

	<h1><?= $titulo ?></h1>

	<form id="form-financiador" action="<?= $url ?>" method="post">

		<div class="form-group">

			<label>Nombre <span class="text-red">*</span></label>

			<input type="text" id="nombre" name="nombre" class="form-control" <?php if ($accion == "modificar_financiador"): ?>value="<?= $financiador->nombre ?>"<?php endif; ?>>

			<?= form_error("nombre") ?>

		</div>

		<input type="submit" id="submit" name="submit" value="Aceptar" class="btn btn-primary">

	</form>

</div>

<?php if (isset($reglas_cliente)): ?>

	<script type="text/javascript">
	    $("#form-financiador").validate(<?= $reglas_cliente ?>);
	</script>

<?php endif; ?>