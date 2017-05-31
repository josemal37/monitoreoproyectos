<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="productos">

	<h4>Productos</h4>

	<?php if ($efecto->productos): ?>

		<ol class="lista-productos">

			<?php foreach ($efecto->productos as $producto): ?>

				<li>

					<?php if ($proyecto->nombre_rol_proyecto == "coordinador" && $this->uri->segment(2) == "editar_marco_logico"): ?>

						<a href="<?= base_url("producto/modificar_producto/" . $proyecto->id . "/" . $producto->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>

						<a href="<?= base_url("producto/eliminar_producto/" . $proyecto->id . "/" . $producto->id) ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>

					<?php endif; ?>

					<p class="text-justify">

						<?= $producto->descripcion ?>

					</p>

					<h4>Indicadores de producto</h4>

					<?php if ($producto->indicadores): ?>

						<div class="table-responsive">

							<table class="table table-bordered">

								<thead>

									<tr>

										<th>Descripción</th>

										<th>Avance</th>

										<th>Meta</th>

										<th>Indicador de efecto</th>

										<?php if ($proyecto->nombre_rol_proyecto == "coordinador" && $this->uri->segment(2) == "editar_marco_logico"): ?>

											<th>Acciones</th>

										<?php endif; ?>

									</tr>

								</thead>

								<tbody>

									<?php foreach ($producto->indicadores as $indicador_producto): ?>

										<tr>

											<td><?= $indicador_producto->descripcion ?></td>

											<td><?= $indicador_producto->avance_acumulado + 0 ?> <?= $indicador_producto->unidad ?></td>

											<td><?= $indicador_producto->cantidad ?> <?= $indicador_producto->unidad ?></td>

											<td>

												<?php if ($indicador_producto->id_indicador_efecto): ?>

													<?= $indicador_producto->descripcion_indicador_efecto ?> (<?= $indicador_producto->porcentaje ?> %)

												<?php endif; ?>

											</td>

											<?php if ($proyecto->nombre_rol_proyecto == "coordinador" && $this->uri->segment(2) == "editar_marco_logico"): ?>

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

					<?php if ($proyecto->nombre_rol_proyecto == "coordinador" && $this->uri->segment(2) == "editar_marco_logico"): ?>

						<a href="<?= base_url("indicador_producto/registrar_indicador_producto/" . $proyecto->id . "/" . $producto->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> Indicador de producto</a>

					<?php endif; ?>

				</li>

			<?php endforeach; ?>

		</ol>

	<?php endif; ?>

	<?php if ($proyecto->nombre_rol_proyecto == "coordinador" && $this->uri->segment(2) == "editar_marco_logico"): ?>

		<a href="<?= base_url("producto/registrar_producto/" . $proyecto->id . "/" . $efecto->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> Producto</a>

	<?php endif; ?>

</div>