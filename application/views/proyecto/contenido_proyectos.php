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

								<a href="<?= base_url("actividad/ver_actividades/" . $proyecto->id) ?>" class="btn btn-default btn-xs">Ver proyecto</a>

								<?php if ($proyecto->nombre_rol_proyecto == "coordinador" && !$proyecto->finalizado): ?>

									<a href="<?= base_url("proyecto/eliminar_proyecto/" . $proyecto->id) ?>" class="btn btn-default btn-xs">Eliminar</a>

								<?php endif; ?>

							</div>

						</div>

					</div>

				<?php endforeach; ?>

			</div>

		</div>

	<?php else: ?>

		<p>No se registraron proyectos.</p>

	<?php endif; ?>

	<div>

		<a href="<?= base_url("proyecto/registrar_proyecto") ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> Proyecto</a>

	</div>

</div>

<script type="text/javascript">
    $(".titulo").matchHeight();
    $(".objetivo").matchHeight();
    $(".acciones").matchHeight();
</script>