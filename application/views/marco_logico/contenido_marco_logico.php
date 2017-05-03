<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

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

	<?php if (isset($proyecto->indicadores_impacto) && $proyecto->indicadores_inpacto): ?>



	<?php else: ?>

		<p>No se registraron indicadores de impacto.</p>

	<?php endif; ?>

	<?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?>

		<a href="<?= base_url("indicador_impacto/registrar_indicador_impacto") ?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus"></span> Indicador impacto</a>

	<?php endif; ?>

	<hr>

	<!-- Resultados -->

	<h2>Resultados</h2>

	<?php if (isset($proyecto->resultados) && $proyecto->resultados): ?>

		<ol>

			<?php foreach ($proyecto->resultados as $resultado): ?>

				<li>

					<div>

						<h3><?= $resultado->nombre ?> <?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?><a href="<?= base_url("resultado/modificar_resultado/" . $proyecto->id . "/" . $resultado->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></a> <a class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a><?php endif; ?></h3>

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

						<?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?>

							<a href="<?= base_url("resultado_clave/registrar_resultado_clave/" . $proyecto->id . "/" . $resultado->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> Resultado clave</a>

						<?php endif; ?>

					</div>

				</li>

			<?php endforeach; ?>

		</ol>

	<?php endif; ?>

</div>