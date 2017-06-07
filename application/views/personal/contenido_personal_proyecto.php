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

						<?php if ($this->uri->segment(2) == "editar_personal_proyecto" && !$proyecto->finalizado): ?>

							<th>Acciones</th>

						<?php endif; ?>

					</tr>

				</thead>

				<tbody>

					<?php foreach ($usuarios as $usuario): ?>

						<tr>

							<td><?= $usuario->nombre_completo ?></td>

							<td><?= $usuario->nombre_rol_proyecto ?></td>

							<?php if ($this->uri->segment(2) == "editar_personal_proyecto" && !$proyecto->finalizado): ?>

								<td>

									<?php if ($usuario->id != $this->session->userdata("id")): ?>

										<a href="<?= base_url("personal/modificar_personal_proyecto/" . $proyecto->id . "/" . $usuario->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>

										<a href="<?= base_url("personal/eliminar_personal_proyecto/" . $proyecto->id . "/" . $usuario->id) ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>

									<?php endif; ?>

								</td>

							<?php endif; ?>

						</tr>

					<?php endforeach; ?>

				</tbody>

			</table>

		</div>

	<?php else: ?>

		<p>No se asignó personal al proyecto.</p>

	<?php endif; ?>

	<?php if ($this->uri->segment(2) == "editar_personal_proyecto" && !$proyecto->finalizado): ?>

		<div>

			<a href="<?= base_url("personal/registrar_personal_proyecto/" . $proyecto->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> Personal</a>

		</div>

	<?php endif; ?>

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

											<?php if ($this->uri->segment(2) == "editar_personal_proyecto" && !$actividad->finalizada): ?>

												<th>Acciones</th>

											<?php endif; ?>

										</tr>

									</thead>

									<tbody>

										<?php foreach ($actividad->usuarios as $usuario): ?>

											<tr>

												<td><?= $usuario->nombre_completo ?></td>

												<?php if ($this->uri->segment(2) == "editar_personal_proyecto" && !$actividad->finalizada): ?>

													<td>

														<a href="<?= base_url("personal/eliminar_personal_actividad/" . $proyecto->id . "/" . $actividad->id . "/" . $usuario->id) ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>

													</td>

												<?php endif; ?>

											</tr>

										<?php endforeach; ?>

									</tbody>

								</table>

							</div>

						<?php else: ?>

							<p>No se registró responsables para esta actividad.</p>

						<?php endif; ?>

						<?php if ($this->uri->segment(2) == "editar_personal_proyecto" && !$actividad->finalizada): ?>

							<div>

								<a href="<?= base_url("personal/registrar_personal_actividad/" . $proyecto->id . "/" . $actividad->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> Responsable</a>

							</div>

						<?php endif; ?>

					</li>

				<?php endforeach; ?>

			</ol>

		<?php else: ?>

			<p class="text-justify">No se registraron actividades.</p>

		<?php endif; ?>

	</div>

</div>