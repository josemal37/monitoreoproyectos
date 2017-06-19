<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="indicadores-impacto" class="indicadores-impacto">

	<!-- Indicadores de impacto -->

	<h2>Indicadores de impacto</h2>

	<?php if ($proyecto->indicadores_impacto): ?>

		<div class="table-responsive">

			<table class="table table-bordered table-hover">

				<thead>

					<tr>

						<th class="descripcion">Descripción</th>

						<?php if ($this->uri->segment(2) == "ver_marco_logico"): ?>

							<th class="estado">Estado</th>

						<?php endif; ?>

						<?php if ($this->uri->segment(2) == "editar_marco_logico"): ?>

							<th class="meta">Meta</th>

						<?php endif; ?>

						<?php if ($proyecto->nombre_rol_proyecto == "coordinador" && $this->uri->segment(2) == "editar_marco_logico" && !$proyecto->finalizado): ?>

							<th class="acciones">Acciones</th>

						<?php endif; ?>

						<?php if ($proyecto->nombre_rol_proyecto == "coordinador" && $this->uri->segment(2) == "editar_marco_logico" && !$proyecto->finalizado): ?>

							<th class="porcentaje-asignado">Porcentaje asignado</th>

						<?php endif; ?>

					</tr>

				</thead>

				<tbody>

					<?php foreach ($proyecto->indicadores_impacto as $indicador_impacto): ?>

						<tr>

							<td><?= $indicador_impacto->descripcion ?></td>

							<?php if ($this->uri->segment(2) == "ver_marco_logico"): ?>

								<td>

									<p><?= $indicador_impacto->avance_acumulado + 0 ?> / <?= $indicador_impacto->cantidad + 0 ?> <?= $indicador_impacto->unidad ?></p>

									<div class="progress">

										<?php
										$porcentaje_avance = ($indicador_impacto->avance_acumulado / $indicador_impacto->cantidad) * 100;

										if ($porcentaje_avance > 100) {
											$porcentaje_avance = 100;
										}
										?>

										<div class="progress-bar" role="progressbar" aria-valuenow="<?= $indicador_impacto->avance_acumulado + 0 ?>" aria-valuemin="0" aria-valuemax="<?= $indicador_impacto->cantidad + 0 ?>" style="width: <?= $porcentaje_avance ?>%; min-width: 1%;"></div>

									</div>

								</td>

							<?php endif; ?>

							<?php if ($this->uri->segment(2) == "editar_marco_logico"): ?>

								<td><?= $indicador_impacto->cantidad ?> <?= $indicador_impacto->unidad ?></td>

							<?php endif; ?>

							<?php if ($proyecto->nombre_rol_proyecto == "coordinador" && $this->uri->segment(2) == "editar_marco_logico" && !$proyecto->finalizado): ?>

								<td>

									<a href="<?= base_url("indicador_impacto/modificar_indicador_impacto/" . $proyecto->id . "/" . $indicador_impacto->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>

									<a href="<?= base_url("indicador_impacto/eliminar_indicador_impacto/" . $proyecto->id . "/" . $indicador_impacto->id) ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>

								</td>

							<?php endif; ?>

							<?php if ($proyecto->nombre_rol_proyecto == "coordinador" && $this->uri->segment(2) == "editar_marco_logico" && !$proyecto->finalizado): ?>

								<td>

									<p><?= $indicador_impacto->porcentaje_acumulado ?> %</p>

									<div class="progress">

										<div class="progress-bar" role="progressbar" aria-valuenow="<?= $indicador_impacto->porcentaje_acumulado + 0 ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $indicador_impacto->porcentaje_acumulado ?>%; min-width: 1%;"></div>

									</div>

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