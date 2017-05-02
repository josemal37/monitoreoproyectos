<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">

	<h1><?= $titulo ?></h1>

	<?php if (isset($proyectos) && $proyectos): ?>

		<div class="proyectos">

			<div class="row">

				<?php foreach ($proyectos as $proyecto): ?>

					<div class="col-md-4 col-sm-6">

						<div class="proyecto">

							<div class="titulo">

								<label><?= $proyecto->nombre ?></label>

							</div>

							<div class="objetivo">

								<p><?= $proyecto->objetivo ?></p>

							</div>

							<div class="fecha">

								<p><?= $proyecto->fecha_inicio ?> - <?= $proyecto->fecha_fin ?></p>

							</div>

							<div class="acciones">

								<div>

									<a href="<?= base_url("proyecto/actividades/" . $proyecto->id) ?>" class="btn btn-default btn-xs">Actividades</a>

								</div>

								<div>

									<a href="<?= base_url("proyecto/marco_logico/" . $proyecto->id) ?>" class="btn btn-default btn-xs">Marco lógico</a>

								</div>

								<div>

									<a href="<?= base_url("proyecto/modificar/" . $proyecto->id) ?>" class="btn btn-default btn-xs">Modificar</a>

								</div>

								<div>

									<a href="<?= base_url("proyecto/eliminar/" . $proyecto->id) ?>" class="btn btn-default btn-xs">Eliminar</a>

								</div>

							</div>

						</div>

					</div>

				<?php endforeach; ?>

			</div>

		</div>

	<?php else: ?>

		<p>No se registraron proyectos.</p>

	<?php endif; ?>

</div>

<script type="text/javascript">
	//$(".contenido-variable").matchHeight();
	$(".titulo").matchHeight();
	$(".objetivo").matchHeight();
</script>