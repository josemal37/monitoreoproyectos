<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $tiene_efectos = FALSE; ?>

<div class="container-fluid">

	<!-- Nombre del proyecto -->

	<h1><?= $proyecto->nombre ?></h1>

	<!-- Objetivo del proyecto -->

	<?php if ($proyecto->objetivo): ?>

		<h2>Objetivo</h2>

		<p class="text-justify"><?= $proyecto->objetivo ?></p>

	<?php endif; ?>

	<!-- Fecha de inicio y de fin -->

	<h2>Temporalidad</h2>

	<p><label>Fecha de inicio:</label> <?= $proyecto->fecha_inicio ?></p>

	<p><label>Fecha de fin:</label> <?= $proyecto->fecha_fin ?></p>

	<hr>

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

	<hr>

	<!-- Resultados -->

	<h2>Resultados</h2>

	<?php if (isset($proyecto->resultados) && $proyecto->resultados): ?>

		<ol>

			<?php foreach ($proyecto->resultados as $resultado): ?>

				<li>

					<div>

						<h3>

							<?= $resultado->nombre ?>

							<?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?>

								<a href="<?= base_url("resultado/modificar_resultado/" . $proyecto->id . "/" . $resultado->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>

								<a href="<?= base_url("resultado/eliminar_resultado/" . $proyecto->id . "/" . $resultado->id) ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>

							<?php endif; ?>

						</h3>

						<?php if ($resultado->efectos): ?>

							<?php $tiene_efectos = TRUE; ?>

							<ol>

								<?php foreach ($resultado->efectos as $efecto): ?>

									<li>

										<p class="text-justify">

											<?= $efecto->descripcion ?>

											<?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?>

												<a href="<?= base_url("efecto/modificar_efecto/" . $proyecto->id . "/" . $efecto->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>

												<a href="<?= base_url("efecto/eliminar_efecto/" . $proyecto->id . "/" . $efecto->id) ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>

											<?php endif; ?>

										</p>

									</li>

								<?php endforeach; ?>

							</ol>

						<?php endif; ?>

						<?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?>

							<a href="<?= base_url("efecto/registrar_efecto/" . $proyecto->id . "/" . $resultado->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> Efecto</a>

						<?php endif; ?>

					</div>

				</li>

			<?php endforeach; ?>

		</ol>

	<?php else: ?>

		<p>No se registraron resultados.</p>

	<?php endif; ?>

	<?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?>

		<a href="<?= base_url("resultado/registrar_resultado/" . $proyecto->id) ?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus"></span> Resultado</a>

	<?php endif; ?>

	<hr>

	<!-- Resultados clave -->

	<?php if (isset($proyecto->resultados) && $proyecto->resultados): ?>

		<h2>Resultados clave</h2>

		<ol>

			<?php foreach ($proyecto->resultados as $resultado): ?>

				<li>

					<div>

						<h3><?= $resultado->nombre ?></h3>

						<?php if ($resultado->resultados_clave): ?>

							<ul>

								<?php foreach ($resultado->resultados_clave as $resultado_clave): ?>

									<li>

										<p class="text-justify">

											<?= $resultado_clave->descripcion ?>

											<?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?>

												<a href="<?= base_url("resultado_clave/modificar_resultado_clave/" . $proyecto->id . "/" . $resultado_clave->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>

												<a href="<?= base_url("resultado_clave/eliminar_resultado_clave/" . $proyecto->id . "/" . $resultado_clave->id) ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>

											<?php endif; ?>

										</p>

									</li>

								<?php endforeach; ?>

							</ul>

						<?php endif; ?>

						<?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?>

							<a href="<?= base_url("resultado_clave/registrar_resultado_clave/" . $proyecto->id . "/" . $resultado->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> Resultado clave</a>

						<?php endif; ?>

					</div>

				</li>

			<?php endforeach; ?>

		</ol>

	<?php endif; ?>

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

															<?php else: ?>

																<p>Ninguno</p>

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

								<h3>Productos</h3>

								<?php if ($efecto->productos): ?>

									<ol>

										<?php foreach ($efecto->productos as $producto): ?>

											<li>

												<div>

													<p class="text-justify">

														<?= $producto->descripcion ?>

														<?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?>

															<a href="<?= base_url("producto/modificar_producto/" . $proyecto->id . "/" . $producto->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>

															<a href="<?= base_url("producto/eliminar_producto/" . $proyecto->id . "/" . $producto->id) ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>

														<?php endif; ?>

													</p>

												</div>

											</li>

										<?php endforeach; ?>

									</ol>

								<?php endif; ?>

								<?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?>

									<a href="<?= base_url("producto/registrar_producto/" . $proyecto->id . "/" . $efecto->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> Producto</a>

								<?php endif; ?>

							</div>

						</li>

					<?php endforeach; ?>

				<?php endif; ?>

			<?php endforeach; ?>

		</ol>

	<?php endif; ?>

</div>