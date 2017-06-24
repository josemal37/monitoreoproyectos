<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid financiadores">

	<div class="text-center">

		<h1><?= $titulo ?></h1>

	</div>

	<?php if ($financiadores): ?>

		<div class="table-responsive">

			<table class="table table-bordered table-hover">

				<thead>

					<tr>

						<th>Nombre</th>

						<th class="acciones">Acciones</th>

					</tr>

				</thead>

				<tbody>

					<?php foreach ($financiadores as $financiador): ?>

						<tr>

							<td><?= $financiador->nombre ?></td>

							<td>

								<a href="<?= base_url("financiador/modificar_financiador/" . $financiador->id) ?>" class="btn btn-success btn-xs">Modificar</a>

								<a href="<?= base_url("financiador/eliminar_financiador/" . $financiador->id) ?>" class="btn btn-danger btn-xs">Eliminar</a>

							</td>

						</tr>

					<?php endforeach; ?>

				</tbody>

			</table>

		</div>

	<?php else: ?>

		<p>No se registraron financiadores.</p>

	<?php endif; ?>

</div>