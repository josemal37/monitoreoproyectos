<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form action="<?= base_url("login") ?>" method="post">

	<div class="form-group">

		<label>Nombre de usuario</label>

		<input type="text" id="login" name="login" class="form-control">

		<?= form_error("login") ?>

	</div>

	<div class="form-group">

		<label>Contraseña</label>

		<input type="password" id="password" name="password" class="form-control">

		<?= form_error("password") ?>

	</div>

	<input type="submit" id="submit" name="submit" value="Aceptar" class="btn btn-default">

</form>