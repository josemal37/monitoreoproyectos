<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$accion = $this->uri->segment(2);
$url = "";

switch ($accion) {
	case "registrar_usuario":
		$url = base_url("usuario/registrar_usuario");
		break;
	case "modificar_usuario":
		$url = base_url("usuario/modificar_usuario/" . $usuario->id);
		break;
	case "modificar_password_usuario":
		$url = base_url("usuario/modificar_password_usuario/" . $usuario->id);
		break;
}
?>

<div class="container-fluid">

	<h1><?= $titulo ?></h1>

	<form id="form-usuario" action="<?= $url ?>" method="post">

		<?php if ($accion == "registrar_usuario" || $accion == "modificar_usuario"): ?>

			<div class="form-group">

				<label>Nombre <span class="text-red">*</span></label>

				<input type="text" id="nombre" name="nombre" class="form-control" <?php if ($accion == "modificar_usuario"): ?>value="<?= $usuario->nombre ?>"<?php endif; ?>>

				<?= form_error("nombre") ?>

			</div>

			<div class="form-group">

				<label>Apellido paterno</label>

				<input type="text" id="apellido_paterno" name="apellido_paterno" class="form-control" <?php if ($accion == "modificar_usuario"): ?>value="<?= $usuario->apellido_paterno ?>"<?php endif; ?>>

				<?= form_error("apellido_paterno") ?>

			</div>

			<div class="form-group">

				<label>Apellido materno</label>

				<input type="text" id="apellido_materno" name="apellido_materno" class="form-control" <?php if ($accion == "modificar_usuario"): ?>value="<?= $usuario->apellido_materno ?>"<?php endif; ?>>

				<?= form_error("apellido_materno") ?>

			</div>

			<div class="form-group">

				<label>Rol <span class="text-red">*</span></label>

				<select id="rol" name="rol" class="form-control">

					<?php if (isset($roles) && $roles): ?>

						<?php foreach ($roles as $rol): ?>

							<option value="<?= $rol->id ?>"  <?php if ($accion == "modificar_usuario" && $rol->id == $usuario->id_rol): ?>selected<?php endif; ?>><?= $rol->nombre ?></option>

						<?php endforeach; ?>

					<?php endif; ?>

				</select>

			</div>

			<div class="form-group">

				<label>Nombre de usuario <span class="text-red">*</span></label>

				<input type="text" id="login" name="login" class="form-control" <?php if ($accion == "modificar_usuario"): ?>value="<?= $usuario->login ?>"<?php endif; ?>>

				<?= form_error("login") ?>

				<?php if ($this->session->flashdata("existe")): ?>

					<label class="text-danger"><?= $this->session->flashdata("existe") ?></label>

				<?php endif; ?>

			</div>

		<?php endif; ?>

		<?php if ($accion == "modificar_password_usuario"): ?>

			<div>

				<p><label>Nombre:</label> <?= $usuario->nombre_completo ?></p>

			</div>

		<?php endif; ?>

		<?php if ($accion == "modificar_password"): ?>

			<div class="form-group">

				<label>Contraseña anterior <span class="text-red">*</span></label>

				<input type="password" id="password_anterior" name="password_anterior" class="form-control">

				<?= form_error("password_anterior") ?>

				<?php if ($this->session->flashdata("password_anterior")): ?>

					<label class="text-danger"><?= $this->session->flashdata("password_anterior") ?></label>

				<?php endif; ?>

			</div>

		<?php endif; ?>

		<?php if ($accion == "registrar_usuario" || $accion == "modificar_password_usuario" || $accion == "modificar_password"): ?>

			<div class="form-group">

				<?php if ($accion == "registrar_usuario" || $accion == "modificar_password_usuario"): ?>

					<label>Contraseña <span class="text-red">*</span></label>

				<?php endif; ?>

				<?php if ($accion == "modificar_password"): ?>

					<label>Contraseña nueva <span class="text-red">*</span></label>

				<?php endif; ?>

				<input type="password" id="password" name="password" class="form-control">

				<?= form_error("password") ?>

			</div>

			<div class="form-group">

				<label>Confirmar contraseña <span class="text-red">*</span></label>

				<input type="password" id="confirmacion_password" name="confirmacion_password" class="form-control">

				<?= form_error("confirmacion_password") ?>

			</div>

		<?php endif; ?>

		<?php if ($accion == "modificar_usuario" || $accion == "modificar_password_usuario"): ?>

			<input type="hidden" id="id" name="id" value="<?= $usuario->id ?>">

		<?php endif; ?>

		<input type="submit" id="submit" name="submit" value="Aceptar" class="btn btn-primary">

	</form>

</div>

<?php if (isset($reglas_cliente)): ?>

	<script type="text/javascript">
		$("#form-usuario").validate(<?= $reglas_cliente ?>);
	</script>

<?php endif; ?>