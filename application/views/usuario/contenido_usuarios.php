<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">

	<div class="text-center">

		<h1><?= $titulo ?></h1>

	</div>

	<?php if (isset($usuarios) && $usuarios): ?>

		<div class="table-responsive">

			<table class="table table-bordered">

				<thead>

					<tr>

						<th>Nombre completo</th>

						<th>Login</th>

						<th>Rol</th>

						<th>Acciones</th>

					</tr>

				</thead>

				<tbody>

					<?php foreach ($usuarios as $usuario): ?>

						<tr>

							<td><?= $usuario->nombre_completo ?></td>

							<td><?= $usuario->login ?></td>

							<td><?= $usuario->nombre_rol ?></td>

							<td>

								<a href="<?= base_url("usuario/modificar_usuario/" . $usuario->id) ?>" class="btn btn-default btn-xs">Modificar</a>

								<a href="<?= base_url("usuario/modificar_password_usuario/" . $usuario->id) ?>" class="btn btn-default btn-xs">Modificar contraseña</a>

								<a href="<?= base_url("usuario/eliminar_usuario/" . $usuario->id) ?>" class="btn btn-default btn-xs">Eliminar</a>

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