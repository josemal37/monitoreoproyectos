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
}
?>

<div class="container-fluid">

	<h1><?= $titulo ?></h1>

	<p class="text-justify"><label>Proyecto:</label> <?= $proyecto->nombre ?></p>

	<form id="form-impacto" action="<?= $url ?>" method="post">

		<div class="form-group">

			<label>Usuario</label>

			<select id="usuario" name="usuario" class="form-control">

				<?php foreach ($usuarios as $usuario): ?>

					<option value="<?= $usuario->id ?>"><?= $usuario->nombre_completo ?></option>

				<?php endforeach; ?>

			</select>

			<?= form_error("usuario") ?>

			<?php if ($this->session->flashdata("error")): ?>

				<label class="text-danger"><?= $this->session->flashdata("error") ?></label>

			<?php endif; ?>

		</div>

		<div class="form-group">

			<label>Rol en el proyecto</label>

			<select id="rol_proyecto" name="rol_proyecto" class="form-control">

				<?php foreach ($roles as $rol): ?>

					<option value="<?= $rol->id ?>"><?= $rol->nombre ?></option>

				<?php endforeach; ?>

			</select>

		</div>

		<input type="submit" id="submit" name="submit" value="Aceptar" class="btn btn-primary">

	</form>

</div>