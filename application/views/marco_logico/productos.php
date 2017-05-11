<div class="productos">

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

						<h4>Indicadores de producto</h4>

						<?php if ($producto->indicadores): ?>

							<div class="table-responsive">

								<table class="table table-bordered">

									<thead>

										<tr>

											<th>Descripción</th>

											<th>Meta</th>

											<th>Indicador de efecto</th>

											<?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?>

												<th>Acciones</th>

											<?php endif; ?>

										</tr>

									</thead>

									<tbody>

										<?php foreach ($producto->indicadores as $indicador_producto): ?>

											<tr>

												<td><?= $indicador_producto->descripcion ?></td>

												<td><?= $indicador_producto->cantidad ?> <?= $indicador_producto->unidad ?></td>

												<td>

													<?php if ($indicador_producto->id_indicador_efecto): ?>

														<?= $indicador_producto->descripcion_indicador_efecto ?> (<?= $indicador_producto->porcentaje ?> %)

													<?php endif; ?>

												</td>

												<?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?>

													<td>

														<a href="<?= base_url("indicador_producto/modificar_indicador_producto/" . $proyecto->id . "/" . $indicador_producto->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>

														<a href="<?= base_url("indicador_producto/eliminar_indicador_producto/" . $proyecto->id . "/" . $indicador_producto->id) ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>

													</td>

												<?php endif; ?>

											</tr>

										<?php endforeach; ?>

									</tbody>

								</table>

							</div>

						<?php endif; ?>

						<?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?>

							<a href="<?= base_url("indicador_producto/registrar_indicador_producto/" . $proyecto->id . "/" . $producto->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> Indicador de producto</a>

						<?php endif; ?>

					</div>

				</li>

			<?php endforeach; ?>

		</ol>

	<?php endif; ?>

	<?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?>

		<a href="<?= base_url("producto/registrar_producto/" . $proyecto->id . "/" . $efecto->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> Producto</a>

	<?php endif; ?>

</div>