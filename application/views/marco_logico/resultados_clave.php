<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="resultados-clave" class="resultados-clave">

	<!-- Resultados clave -->

	<h2>Resultados clave</h2>

	<?php if (isset($proyecto->resultados) && $proyecto->resultados): ?>

		<ol class="lista-resultados">

			<?php foreach ($proyecto->resultados as $resultado): ?>

				<li>

					<h3><?= $resultado->nombre ?></h3>

					<?php if ($resultado->resultados_clave): ?>

						<ul class="lista-resultados-clave">

							<?php foreach ($resultado->resultados_clave as $resultado_clave): ?>

								<li>

									<p>

										<?= $resultado_clave->descripcion ?>

										<?php if ($proyecto->nombre_rol_proyecto == "coordinador" && $this->uri->segment(2) == "editar_marco_logico" && !$proyecto->finalizado): ?>

											<a href="<?= base_url("resultado_clave/modificar_resultado_clave/" . $proyecto->id . "/" . $resultado_clave->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>

											<a href="<?= base_url("resultado_clave/eliminar_resultado_clave/" . $proyecto->id . "/" . $resultado_clave->id) ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>

										<?php endif; ?>

									</p>

								</li>

							<?php endforeach; ?>

						</ul>

					<?php endif; ?>

					<?php if ($proyecto->nombre_rol_proyecto == "coordinador" && $this->uri->segment(2) == "editar_marco_logico" && !$proyecto->finalizado): ?>

						<div>

							<a href="<?= base_url("resultado_clave/registrar_resultado_clave/" . $proyecto->id . "/" . $resultado->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> Resultado clave</a>

						</div>

					<?php endif; ?>

				</li>

			<?php endforeach; ?>

		</ol>

	<?php else: ?>

		<p class="text-justify">No se registraron resultados clave.</p>

	<?php endif; ?>

</div>