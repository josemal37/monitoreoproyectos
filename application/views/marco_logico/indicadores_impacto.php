<div id="indicadores-impacto" class="indicadores-impacto">

	<!-- Indicadores de impacto -->

	<h2>Indicadores de impacto</h2>

	<?php if ($proyecto->indicadores_impacto): ?>

		<div class="table-responsive">

			<table class="table table-bordered">

				<thead>

					<tr>

						<th>Descripción</th>

						<th>Meta</th>

						<?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?>

							<th>Acciones</th>

						<?php endif; ?>

					</tr>

				</thead>

				<tbody>

					<?php foreach ($proyecto->indicadores_impacto as $indicador_impacto): ?>

						<tr>

							<td><?= $indicador_impacto->descripcion ?></td>

							<td><?= $indicador_impacto->cantidad ?> <?= $indicador_impacto->unidad ?></td>

							<?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?>

								<td>

									<a href="<?= base_url("indicador_impacto/modificar_indicador_impacto/" . $proyecto->id . "/" . $indicador_impacto->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>

									<a href="<?= base_url("indicador_impacto/eliminar_indicador_impacto/" . $proyecto->id . "/" . $indicador_impacto->id) ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>

								</td>

							<?php endif; ?>

						</tr>

					<?php endforeach; ?>

				</tbody>

			</table>

		</div>

	<?php else: ?>

		<p>No se registraron indicadores de impacto.</p>

	<?php endif; ?>

	<?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?>

		<a href="<?= base_url("indicador_impacto/registrar_indicador_impacto/" . $proyecto->id) ?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus"></span> Indicador impacto</a>

	<?php endif; ?>

</div>