<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">

	<?php $this->load->view("actividad/datos_generales"); ?>

	<h2>Actividades</h2>

	<?php if ($actividades): ?>

		<ol>

			<?php foreach ($actividades as $actividad): ?>

				<li>

					<h3><?= $actividad->nombre ?> <a href="<?= base_url("actividad/modificar_actividad/" . $proyecto->id . "/" . $actividad->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></a> <a href="<?= base_url("actividad/eliminar_actividad/" . $proyecto->id . "/" . $actividad->id) ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a></h3>

					<p><label>Fecha de inicio:</label> <?= $actividad->fecha_inicio ?></p>

					<p><label>Fecha de fin:</label> <?= $actividad->fecha_fin ?></p>

					<div class="table-responsive">

						<table class="table table-bordered">

							<thead>

								<tr>

									<th>Meta</th>

									<th>Producto asociado</th>
									
									<th>Indicador producto asociado</th>

								</tr>

							</thead>

							<tbody>

								<tr>

									<td>

										<?php if (isset($actividad->id_meta_actividad)): ?>

											<?= $actividad->cantidad ?> <?= $actividad->unidad ?>

										<?php endif; ?>

									</td>

									<td>

										<?php if (isset($actividad->id_producto)): ?>

											<?= $actividad->descripcion_producto ?>

										<?php endif; ?>

									</td>
									
									<td>
										
										<?php if (isset($actividad->id_indicador_producto)):?>
										
											<?= $actividad->descripcion_indicador_producto?> (<?= $actividad->porcentaje?>%)
										
										<?php endif; ?>
										
									</td>

								</tr>

							</tbody>

						</table>

					</div>

				</li>

			<?php endforeach; ?>

		</ol>

	<?php else: ?>

		<p class="text-justify">No se registraron actividades.</p>

	<?php endif; ?>

	<a href="<?= base_url("actividad/registrar_actividad/" . $proyecto->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> Actividad</a>

</div>