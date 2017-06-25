<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="datos-generales" class="datos-generales">

	<!-- Nombre del proyecto -->

	<h1><?= $proyecto->nombre ?></h1>

	<?php if ($this->uri->segment(2) == "ver_marco_logico"): ?>

		<a href="<?= base_url("reporte/marco_logico_docx/" . $proyecto->id) ?>" class="btn btn-primary">Reporte</a>

	<?php endif; ?>

	<!-- Objetivo del proyecto -->

	<?php if ($proyecto->objetivo): ?>

		<h2>Objetivo</h2>

		<p class="text-justify"><?= $proyecto->objetivo ?></p>

	<?php endif; ?>

	<!-- Fecha de inicio y de fin -->

	<h2>Temporalidad</h2>

	<p><label>Fecha de inicio:</label> <?= $proyecto->fecha_inicio ?></p>

	<p><label>Fecha de fin:</label> <?= $proyecto->fecha_fin ?></p>

	<?php if ($proyecto->finalizado): ?>

		<p><label>Estado:</label> Cerrado</p>

	<?php else: ?>

		<p><label>Estado:</label> Vigente</p>

	<?php endif; ?>

	<?php if (($proyecto->nombre_rol_proyecto == "coordinador" || $this->session->userdata("rol") == "direccion") && isset($proyecto->aportes) && $proyecto->aportes): ?>

		<?php
		$ejecutores = array();
		$financiadores = array();
		$otros = array();

		foreach ($proyecto->aportes as $aporte) {
			switch ($aporte->id_tipo_financiador) {
				case $id_ejecutor:
					$ejecutores[] = $aporte;
					break;
				case $id_financiador:
					$financiadores[] = $aporte;
					break;
				case $id_otro:
					$otros[] = $aporte;
					break;
			}
		}
		?>

		<div class="aportes">

			<h2>Costo del proyecto</h2>

			<?php if (sizeof($ejecutores) > 0): ?>

				<h3>Ejecutores</h3>

				<div class="table-responsive">

					<table class="table table-bordered table-hover">

						<thead>

							<tr>

								<th class="institucion">Institución</th>

								<th class="descripcion">Concepto</th>

								<th class="monto">Monto (Bs.)</th>

							</tr>

						</thead>

						<tbody>

							<?php foreach ($ejecutores as $ejecutor): ?>

								<tr>

									<td><?= $ejecutor->nombre_financiador ?></td>

									<td><?= $ejecutor->concepto ?></td>

									<td><?= $ejecutor->cantidad ?></td>

								</tr>

							<?php endforeach; ?>

						</tbody>

					</table>

				</div>

			<?php endif; ?>

			<?php if (sizeof($financiadores) > 0): ?>

				<h3>Financiadores</h3>

				<div class="table-responsive">

					<table class="table table-bordered table-hover">

						<thead>

							<tr>

								<th class="institucion">Institución</th>

								<th class="descripcion">Concepto</th>

								<th class="monto">Monto (Bs.)</th>

							</tr>

						</thead>

						<tbody>

							<?php foreach ($financiadores as $financiador): ?>

								<tr>

									<td><?= $financiador->nombre_financiador ?></td>

									<td><?= $financiador->concepto ?></td>

									<td><?= $financiador->cantidad ?></td>

								</tr>

							<?php endforeach; ?>

						</tbody>

					</table>

				</div>

			<?php endif; ?>

			<?php if (sizeof($otros) > 0): ?>

				<h3>Otros</h3>

				<div class="table-responsive">

					<table class="table table-bordered table-hover">

						<thead>

							<tr>

								<th class="institucion">Institución</th>

								<th class="descripcion">Concepto</th>

								<th class="monto">Monto (Bs.)</th>

							</tr>

						</thead>

						<tbody>

							<?php foreach ($otros as $otro): ?>

								<tr>

									<td><?= $otro->nombre_financiador ?></td>

									<td><?= $otro->concepto ?></td>

									<td><?= $otro->cantidad ?></td>

								</tr>

							<?php endforeach; ?>

						</tbody>

					</table>

				</div>

			<?php endif; ?>

		</div>

	<?php endif; ?>

</div>