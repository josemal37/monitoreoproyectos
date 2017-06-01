<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$accion = $this->uri->segment(2);
$url = "";
switch ($accion) {
	case "registrar_personal_proyecto":
		$url = base_url("personal/registrar_personal_proyecto/" . $proyecto->id);
		break;
	case "modificar_personal_proyecto":
		$url = base_url("personal/modificar_personal_proyecto/" . $proyecto->id . "/" . $usuario->id);
		break;
	case "registrar_personal_actividad":
		$url = base_url("personal/registrar_personal_actividad/" . $proyecto->id . "/" . $actividad->id);
		break;
}
?>

<div class="container-fluid">

	<h1><?= $titulo ?></h1>

	<p class="text-justify"><label>Proyecto:</label> <?= $proyecto->nombre ?></p>

	<form id="form-personal" action="<?= $url ?>" method="post">

		<div class="form-group">

			<label>Usuario</label>

			<select id="usuario" name="usuario" class="form-control" <?php if ($accion == "modificar_personal_proyecto"): ?>disabled<?php endif; ?>>

				<?php foreach ($usuarios as $usuario): ?>

					<option value="<?= $usuario->id ?>" <?php if ($accion == "modificar_personal_proyecto" && $usuario->id == $registro->id_usuario): ?>selected<?php endif; ?>><?= $usuario->nombre_completo ?></option>

				<?php endforeach; ?>

			</select>

			<?= form_error("usuario") ?>

			<?php if ($this->session->flashdata("error")): ?>

				<label class="text-danger"><?= $this->session->flashdata("error") ?></label>

			<?php endif; ?>

		</div>

		<?php if ($accion == "registrar_personal_proyecto" || $accion == "modificar_personal_proyecto"): ?>

			<div class="form-group">

				<label>Rol en el proyecto</label>

				<select id="rol_proyecto" name="rol_proyecto" class="form-control">

					<?php foreach ($roles as $rol): ?>

						<option value="<?= $rol->id ?>" <?php if ($accion == "modificar_personal_proyecto" && $rol->id == $registro->id_rol_proyecto): ?>selected<?php endif; ?>><?= $rol->nombre ?></option>

					<?php endforeach; ?>

				</select>

			</div>

		<?php endif; ?>

		<input type="submit" id="submit" name="submit" value="Aceptar" class="btn btn-primary">

	</form>

</div>

<?php if (isset($reglas_cliente)): ?>

	<script type="text/javascript">
	    $("#form-personal").validate(<?= $reglas_cliente ?>);
	</script>

<?php endif; ?>