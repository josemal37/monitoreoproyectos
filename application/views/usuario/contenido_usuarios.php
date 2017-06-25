<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid usuarios">

	<div class="text-center">

		<h1><?= $titulo ?></h1>

	</div>

	<?php if (isset($usuarios) && $usuarios): ?>

		<div class="table-responsive">

			<table class="table table-bordered table-hover">

				<thead>

					<tr>

						<th class="nombre-completo">Nombre completo</th>

						<th class="nombre-completo">Correo electrónico</th>

						<th class="login">Login</th>

						<th class="rol">Rol</th>

						<th class="acciones">Acciones</th>

					</tr>

				</thead>

				<tbody>

					<?php foreach ($usuarios as $usuario): ?>

						<tr>

							<td><?= $usuario->nombre_completo ?></td>

							<td><?= $usuario->e_mail ?></td>

							<td><?= $usuario->login ?></td>

							<td><?= $usuario->nombre_rol ?></td>

							<td>

								<a href="<?= base_url("usuario/modificar_usuario/" . $usuario->id) ?>" class="btn btn-success btn-xs">Modificar</a>

								<a href="<?= base_url("usuario/modificar_password_usuario/" . $usuario->id) ?>" class="btn btn-warning btn-xs">Modificar contraseña</a>

								<a href="<?= base_url("usuario/eliminar_usuario/" . $usuario->id) ?>" class="btn btn-danger btn-xs">Eliminar</a>

							</td>

						</tr>

					<?php endforeach; ?>

				</tbody>

			</table>

		</div>

	<?php else: ?>

		<p>No se registraron usuarios.</p>

	<?php endif; ?>

</div>