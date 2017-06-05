<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="indicadores-impacto" class="indicadores-impacto">

	<!-- Indicadores de impacto -->

	<h2>Indicadores de impacto</h2>

	<?php if ($proyecto->indicadores_impacto): ?>

		<div class="table-responsive">

			<table class="table table-bordered">

				<thead>

					<tr>

						<th>Descripción</th>

						<th>Avance</th>

						<th>Meta</th>

						<?php if ($proyecto->nombre_rol_proyecto == "coordinador" && $this->uri->segment(2) == "editar_marco_logico" && !$proyecto->finalizado): ?>

							<th>Acciones</th>

						<?php endif; ?>

					</tr>

				</thead>

				<tbody>

					<?php foreach ($proyecto->indicadores_impacto as $indicador_impacto): ?>

						<tr>

							<td><?= $indicador_impacto->descripcion ?></td>

							<td><?= $indicador_impacto->avance_acumulado + 0 ?> <?= $indicador_impacto->unidad ?></td>

							<td><?= $indicador_impacto->cantidad ?> <?= $indicador_impacto->unidad ?></td>

							<?php if ($proyecto->nombre_rol_proyecto == "coordinador" && $this->uri->segment(2) == "editar_marco_logico" && !$proyecto->finalizado): ?>

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

	<?php if ($proyecto->nombre_rol_proyecto == "coordinador" && $this->uri->segment(2) == "editar_marco_logico" && !$proyecto->finalizado): ?>

		<a href="<?= base_url("indicador_impacto/registrar_indicador_impacto/" . $proyecto->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> Indicador impacto</a>

	<?php endif; ?>

</div>