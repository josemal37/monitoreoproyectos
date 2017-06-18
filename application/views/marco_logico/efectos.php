<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
$tiene_efectos = FALSE;

if (isset($proyecto->resultados) && $proyecto->resultados) {
	foreach ($proyecto->resultados as $resultado) {
		if ($resultado->efectos) {
			$tiene_efectos = TRUE;
		}
	}
}
?>

<div id="efectos" class="efectos">

	<!-- Efectos -->

	<h2>Efectos</h2>

	<?php if ($tiene_efectos): ?>

		<ol class="lista-efectos">

			<?php foreach ($proyecto->resultados as $resultado): ?>

				<?php if ($resultado->efectos): ?>

					<?php foreach ($resultado->efectos as $efecto): ?>

						<li>

							<p class="text-justify"><?= $efecto->descripcion ?></p>

							<h4>Indicadores de efecto</h4>

							<?php if ($efecto->indicadores): ?>

								<div class="table-responsive">

									<table class="table table-bordered">

										<thead>

											<tr>

												<th class="descripcion">Descripción</th>

												<?php if ($this->uri->segment(2) == "editar_marco_logico"): ?>

													<th class="meta">Meta</th>

												<?php endif; ?>

												<th class="indicador-asociado">Indicador de impacto</th>

												<?php if ($this->uri->segment(2) == "ver_marco_logico"): ?>

													<th class="estado">Estado</th>

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

											<?php foreach ($efecto->indicadores as $indicador_efecto): ?>

												<tr>

													<td><?= $indicador_efecto->descripcion ?></td>

													<?php if ($this->uri->segment(2) == "editar_marco_logico"): ?>

														<td><?= $indicador_efecto->cantidad ?> <?= $indicador_efecto->unidad ?></td>

													<?php endif; ?>

													<td>

														<?php if ($indicador_efecto->id_indicador_impacto): ?>

															<p><?= $indicador_efecto->descripcion_indicador_impacto ?> (<?= $indicador_efecto->porcentaje ?> %)</p>

														<?php endif; ?>

													</td>

													<?php if ($this->uri->segment(2) == "ver_marco_logico"): ?>

														<td>

															<p><?= $indicador_efecto->avance_acumulado + 0 ?> / <?= $indicador_efecto->cantidad + 0 ?> <?= $indicador_efecto->unidad ?></p>

															<div class="progress">

																<?php
																$porcentaje_avance = ($indicador_efecto->avance_acumulado / $indicador_efecto->cantidad) * 100;

																if ($porcentaje_avance > 100) {
																	$porcentaje_avance = 100;
																}
																?>

																<div class="progress-bar" role="progressbar" aria-valuenow="<?= $indicador_efecto->avance_acumulado + 0 ?>" aria-valuemin="0" aria-valuemax="<?= $indicador_efecto->cantidad + 0 ?>" style="width: <?= $porcentaje_avance ?>%; min-width: 1%;"></div>

															</div>

														</td>

													<?php endif; ?>

													<?php if ($proyecto->nombre_rol_proyecto == "coordinador" && $this->uri->segment(2) == "editar_marco_logico" && !$proyecto->finalizado): ?>

														<td>

															<a href="<?= base_url("indicador_efecto/modificar_indicador_efecto/" . $proyecto->id . "/" . $indicador_efecto->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>

															<a href="<?= base_url("indicador_efecto/eliminar_indicador_efecto/" . $proyecto->id . "/" . $indicador_efecto->id) ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>

														</td>

													<?php endif; ?>

													<?php if ($proyecto->nombre_rol_proyecto == "coordinador" && $this->uri->segment(2) == "editar_marco_logico" && !$proyecto->finalizado): ?>

														<td>

															<p><?= $indicador_efecto->porcentaje_acumulado ?> %</p>

															<div class="progress">

																<div class="progress-bar" role="progressbar" aria-valuenow="<?= $indicador_efecto->porcentaje_acumulado + 0 ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $indicador_efecto->porcentaje_acumulado ?>%; min-width: 1%;"></div>

															</div>

														</td>

													<?php endif; ?>

												</tr>

											<?php endforeach; ?>

										</tbody>

									</table>

								</div>

							<?php endif; ?>

							<?php if ($proyecto->nombre_rol_proyecto == "coordinador" && $this->uri->segment(2) == "editar_marco_logico" && !$proyecto->finalizado): ?>

								<a href="<?= base_url("indicador_efecto/registrar_indicador_efecto/" . $proyecto->id . "/" . $efecto->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> Indicador de efecto</a>

							<?php endif; ?>

							<?php $this->load->view("marco_logico/productos", array("efecto" => $efecto)); ?>

						</li>

					<?php endforeach; ?>

				<?php endif; ?>

			<?php endforeach; ?>

		</ol>

	<?php else: ?>

		<p class="text-justify">No se registraron efectos.</p>

	<?php endif; ?>

</div>