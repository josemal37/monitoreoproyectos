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

</div>