<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid">

	<?php $this->load->view("actividad/datos_generales"); ?>

	<h2>Actividades</h2>

	<div class="actividades">

		<?php if ($actividades): ?>

			<ol class="lista-actividades">

				<?php foreach ($actividades as $actividad): ?>

					<li>

						<h3><?= $actividad->nombre ?> 

							<?php if ($proyecto->nombre_rol_proyecto == "coordinador" && $this->uri->segment(2) == "editar_actividades"): ?>

								<a href="<?= base_url("actividad/modificar_actividad/" . $proyecto->id . "/" . $actividad->id) ?>" class="btn btn-success btn-xs">

									<span class="glyphicon glyphicon-pencil"></span>

								</a> 

								<a href="<?= base_url("actividad/eliminar_actividad/" . $proyecto->id . "/" . $actividad->id) ?>" class="btn btn-danger btn-xs">

									<span class="glyphicon glyphicon-trash"></span>

								</a>

							<?php endif; ?>

						</h3>

						<p><label>Fecha de inicio:</label> <?= $actividad->fecha_inicio ?></p>

						<p><label>Fecha de fin:</label> <?= $actividad->fecha_fin ?></p>

						<?php if (isset($actividad->id_meta_actividad)): ?>

							<p><label>Meta:</label> <?= $actividad->cantidad ?> <?= $actividad->unidad ?></p>

						<?php endif; ?>

						<p><label>Avance:</label> <?= $actividad->avance_acumulado ?> <?= $actividad->unidad ?></p>

						<?php if (isset($actividad->id_producto)): ?>

							<p><label>Producto asociado:</label> <?= $actividad->descripcion_producto ?></p>

						<?php endif; ?>

						<?php if (isset($actividad->id_indicador_producto)): ?>

							<p><label>Indicador de producto asociado:</label> <?= $actividad->descripcion_indicador_producto ?> (<?= $actividad->porcentaje ?>%)</p>

						<?php endif; ?>

					</li>

				<?php endforeach; ?>

			</ol>

		<?php else: ?>

			<p class="text-justify">No se registraron actividades.</p>

		<?php endif; ?>

		<?php if ($proyecto->nombre_rol_proyecto == "coordinador" && $this->uri->segment(2) == "editar_actividades"): ?>

			<a href="<?= base_url("actividad/registrar_actividad/" . $proyecto->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> Actividad</a>

		<?php endif; ?>

	</div>

</div>