<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">

	<?php $this->load->view("personal/datos_generales"); ?>

	<h2>Personal asignado</h2>

	<?php if ($usuarios): ?>

		<div class="table-responsive">

			<table class="table table-bordered">

				<thead>

					<tr>

						<th>Nombre completo</th>

						<th>Rol</th>

						<th>Acciones</th>

					</tr>

				</thead>

				<tbody>

					<?php foreach ($usuarios as $usuario): ?>

						<tr>

							<td><?= $usuario->nombre_completo ?></td>

							<td><?= $usuario->nombre_rol_proyecto ?></td>

							<td>

								<a href="<?= base_url("personal/modificar_personal_proyecto/" . $proyecto->id . "/" . $usuario->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>

								<a href="<?= base_url("personal/eliminar_personal_proyecto/" . $proyecto->id . "/" . $usuario->id) ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>

							</td>

						</tr>

					<?php endforeach; ?>

				</tbody>

			</table>

		</div>

	<?php else: ?>

		<p>No se asignó personal al proyecto.</p>

	<?php endif; ?>

	<a href="<?= base_url("personal/registrar_personal_proyecto/" . $proyecto->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> Personal</a>

	<div class="actividades">

		<h2>Responsables de actividades</h2>

		<?php if ($actividades): ?>

			<ol class="lista-actividades">

				<?php foreach ($actividades as $actividad): ?>

					<li>

						<h3><?= $actividad->nombre ?></h3>

						<?php if ($actividad->usuarios): ?>

							<div class="table-responsive">

								<table class="table table-bordered">

									<thead>

										<tr>

											<th>Nombre completo</th>

											<th>Acciones</th>

										</tr>

									</thead>

									<tbody>

										<?php foreach ($actividad->usuarios as $usuario): ?>

											<tr>

												<td><?= $usuario->nombre_completo ?></td>

												<td><a href="<?= base_url("personal/eliminar_personal_actividad/" . $proyecto->id . "/" . $actividad->id . "/" . $usuario->id) ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a></td>

											</tr>

										<?php endforeach; ?>

									</tbody>

								</table>

							</div>

						<?php endif; ?>

						<div>

							<a href="<?= base_url("personal/registrar_personal_actividad/" . $proyecto->id . "/" . $actividad->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> Responsable</a>

						</div>

					</li>

				<?php endforeach; ?>

			</ol>

		<?php else: ?>

			<p class="text-justify">No se registraron actividades.</p>

		<?php endif; ?>

	</div>

</div>