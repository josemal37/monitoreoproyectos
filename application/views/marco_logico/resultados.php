<div id="resultados" class="resultados">

	<!-- Resultados -->

	<h2>Resultados</h2>

	<?php if (isset($proyecto->resultados) && $proyecto->resultados): ?>

		<ol class="lista-resultados">

			<?php foreach ($proyecto->resultados as $resultado): ?>

				<li>

					<h3>

						<?= $resultado->nombre ?>

						<?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?>

							<a href="<?= base_url("resultado/modificar_resultado/" . $proyecto->id . "/" . $resultado->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>

							<a href="<?= base_url("resultado/eliminar_resultado/" . $proyecto->id . "/" . $resultado->id) ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>

						<?php endif; ?>

					</h3>

					<?php if ($resultado->efectos): ?>

						<?php $tiene_efectos = TRUE; ?>

						<ol class="lista-efectos">

							<?php foreach ($resultado->efectos as $efecto): ?>

								<li>

									<p>

										<?= $efecto->descripcion ?>

										<?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?>

											<a href="<?= base_url("efecto/modificar_efecto/" . $proyecto->id . "/" . $efecto->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>

											<a href="<?= base_url("efecto/eliminar_efecto/" . $proyecto->id . "/" . $efecto->id) ?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></a>

										<?php endif; ?>

									</p>

								</li>

							<?php endforeach; ?>

						</ol>

					<?php endif; ?>

					<?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?>

						<a href="<?= base_url("efecto/registrar_efecto/" . $proyecto->id . "/" . $resultado->id) ?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span> Efecto</a>

					<?php endif; ?>

				</li>

			<?php endforeach; ?>

		</ol>

	<?php else: ?>

		<p>No se registraron resultados.</p>

	<?php endif; ?>

	<?php if ($proyecto->usuario->nombre_rol_proyecto == "coordinador"): ?>

		<a href="<?= base_url("resultado/registrar_resultado/" . $proyecto->id) ?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus"></span> Resultado</a>

	<?php endif; ?>

</div>