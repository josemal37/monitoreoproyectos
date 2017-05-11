<?php
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

	<?php if ($tiene_efectos): ?>

		<h2>Efectos</h2>

		<ol>

			<?php foreach ($proyecto->resultados as $resultado): ?>

				<?php if ($resultado->efectos): ?>

					<?php foreach ($resultado->efectos as $efecto): ?>

						<li>

							<div>

								<p class="text-justify"><?= $efecto->descripcion ?></p>

								<h3>Indicadores de efecto</h3>

								<?php if ($efecto->indicadores): ?>

									<div class="table-responsive">

										<table class="table table-bordered">

											<thead>

												<tr>

													<th>Descripción</th>

													<th>Meta</th>

													<th>Indicador de impacto</th>

													<?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?>

														<th>Acciones</th>

													<?php endif; ?>

												</tr>

											</thead>

											<tbody>

												<?php foreach ($efecto->indicadores as $indicador_efecto): ?>

													<tr>

														<td><?= $indicador_efecto->descripcion ?></td>

														<td><?= $indicador_efecto->cantidad ?> <?= $indicador_efecto->unidad ?></td>

														<td>

															<?php if ($indicador_efecto->id_indicador_impacto): ?>

																<p><?= $indicador_efecto->descripcion_indicador_impacto ?> (<?= $indicador_efecto->porcentaje ?> %)</p>

															<?php endif; ?>

														</td>

														<?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?>

															<td>

																<a href="<?= base_url("indicador_efecto/modificar_indicador_efecto/" . $proyecto->id . "/" . $indicador_efecto->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>

																<a href="<?= base_url("indicador_efecto/eliminar_indicador_efecto/" . $proyecto->id . "/" . $indicador_efecto->id) ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>

															</td>

														<?php endif; ?>

													</tr>

												<?php endforeach; ?>

											</tbody>

										</table>

									</div>

								<?php endif; ?>

								<?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?>

									<a href="<?= base_url("indicador_efecto/registrar_indicador_efecto/" . $proyecto->id . "/" . $efecto->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> Indicador de efecto</a>

								<?php endif; ?>

								<?php $this->load->view("marco_logico/productos", array("efecto" => $efecto)); ?>

							</div>

						</li>

					<?php endforeach; ?>

				<?php endif; ?>

			<?php endforeach; ?>

		</ol>

	<?php endif; ?>

</div>