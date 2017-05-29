<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">

	<?php $this->load->view("avance/datos_generales"); ?>

	<h2>Actividades</h2>

	<div class="actividades">

		<?php if ($actividades): ?>

			<ol class="lista-actividades">

				<?php foreach ($actividades as $actividad): ?>

					<li>

						<h3><?= $actividad->nombre ?></h3>

						<p><label>Fecha de inicio:</label> <?= $actividad->fecha_inicio ?></p>

						<p><label>Fecha de fin:</label> <?= $actividad->fecha_fin ?></p>

						<?php if (isset($actividad->id_meta_actividad)): ?>

							<p><label>Meta:</label> <?= $actividad->cantidad ?> <?= $actividad->unidad ?></p>

						<?php endif; ?>

						<p><label>Avance:</label> <?= $actividad->avance_acumulado ?> <?= $actividad->unidad ?></p>

						<h4>Avances</h4>

						<?php if ($actividad->avances): ?>

							<div class="table-responsive">

								<table class="table table-bordered">

									<thead>

										<tr>

											<th>Cantidad</th>

											<th>Descripción</th>

											<th>Documentos</th>

										</tr>

									</thead>

									<tbody>

										<?php foreach ($actividad->avances as $avance): ?>

											<tr>

												<td><?= $avance->cantidad ?> <?= $actividad->unidad ?>

												</td>

												<td><?= $avance->descripcion ?></td>

												<td>

													<?php if ($avance->documentos): ?>

														<ul>

															<?php foreach ($avance->documentos as $documento): ?>

																<li><a href="<?= base_url($documento->documento) ?>"><?= $documento->nombre ?></a></li>

															<?php endforeach; ?>

														</ul>

													<?php endif; ?>

												</td>

											</tr>

										<?php endforeach; ?>

									</tbody>

								</table>

							</div>

						<?php else: ?>

							<p class="text-justify">No se registraron avances.</p>

						<?php endif; ?>

						<?php if ($actividad->usuarios && is_value_in_array($this->session->userdata("id"), $actividad->usuarios, "id")): ?>

							<div>

								<a href="<?= base_url("avance/registrar_avance/" . $proyecto->id . "/" . $actividad->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> Avance</a>

							</div>

						<?php endif; ?>

					</li>

				<?php endforeach; ?>

			</ol>

		<?php else: ?>

			<p class="text-justify">No se registraron actividades.</p>

		<?php endif; ?>

	</div>

</div>