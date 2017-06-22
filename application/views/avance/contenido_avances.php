<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid avances">

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

						<?php if ($actividad->finalizada): ?>

							<p><label>Estado:</label> Cerrada</p>

						<?php else: ?>

							<p><label>Estado:</label> Vigente 

								<?php if ($actividad->usuarios && is_value_in_array($this->session->userdata("id"), $actividad->usuarios, "id")): ?>

									<a href="<?= base_url("actividad/cerrar_actividad/" . $proyecto->id . "/" . $actividad->id) ?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-lock"></span> Cerrar</a>

								<?php endif; ?>

							</p>

						<?php endif; ?>

						<?php if (isset($actividad->id_meta_actividad)): ?>

							<div class="progress">

								<?php
								$porcentaje_avance = ($actividad->avance_acumulado / $actividad->cantidad) * 100;

								if ($porcentaje_avance > 100) {
									$porcentaje_avance = 100;
								}
								?>

								<div class="progress-bar" role="progressbar" aria-valuenow="<?= $actividad->avance_acumulado + 0 ?>" aria-valuemin="0" aria-valuemax="<?= $actividad->cantidad + 0 ?>" style="width: <?= $porcentaje_avance ?>%; min-width: 10em;">

									<p><?= $actividad->avance_acumulado + 0 ?> / <?= $actividad->cantidad + 0 ?> <?= $actividad->unidad ?></p>

								</div>

							</div>

						<?php endif; ?>

						<h4>Avances</h4>

						<?php if ($actividad->avances): ?>

							<div class="table-responsive">

								<table class="table table-bordered table-hover">

									<thead>

										<tr>

											<th class="fecha">Fecha</th>

											<th class="cantidad">Cantidad</th>

											<th class="descripcion">Descripción</th>

											<th class="documentos">Documentos</th>

											<?php if ($actividad->usuarios && is_value_in_array($this->session->userdata("id"), $actividad->usuarios, "id")): ?>

												<th class="acciones">Acciones</th>

											<?php endif; ?>

										</tr>

									</thead>

									<tbody>

										<?php foreach ($actividad->avances as $avance): ?>

											<tr>

												<td><?= $avance->fecha ?></td>

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

													<a href="<?= base_url("archivos/registrar_archivo/" . $proyecto->id . "/" . $avance->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></a>

												</td>

												<?php if ($actividad->usuarios && is_value_in_array($this->session->userdata("id"), $actividad->usuarios, "id")): ?>

													<td><a href="<?= base_url("avance/eliminar_avance/" . $proyecto->id . "/" . $avance->id) ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a></td>

												<?php endif; ?>

											</tr>

										<?php endforeach; ?>

									</tbody>

								</table>

							</div>

						<?php else: ?>

							<p class="text-justify">No se registraron avances.</p>

						<?php endif; ?>

						<?php if ($actividad->usuarios && is_value_in_array($this->session->userdata("id"), $actividad->usuarios, "id") && !$actividad->finalizada): ?>

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

<script type="text/javascript">
    $(".progress-bar").each(function () {
        var $this = $(this);
        var porcentaje = parseFloat($this[0].style.width);
        if (porcentaje < 33.33) {
            $this.addClass("progress-bar-danger");
        } else if (porcentaje >= 33.33 && porcentaje < 66.67) {
            $this.addClass("progress-bar-warning");
        } else {
            $this.addClass("progress-bar-success");
        }
    });
</script>