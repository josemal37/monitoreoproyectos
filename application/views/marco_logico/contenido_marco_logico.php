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

	<!-- Resultados -->

	<h2>Resultados</h2>

	<?php if (isset($proyecto->resultados) && $proyecto->resultados): ?>



	<?php else: ?>

		<p>No se registraron resultados.</p>

	<?php endif; ?>

	<a href="<?= base_url("resultado/registrar_resultado") ?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus"></span> Resultado</a>

	<!-- Indocadores de impacto -->

	<h2>Indicadores de impacto</h2>

	<?php if (isset($proyecto->indicadores_impacto) && $proyecto->indicadores_inpacto): ?>



	<?php else: ?>

		<p>No se registraron indicadores de impacto.</p>

	<?php endif; ?>

	<a href="<?= base_url("indicador_impacto/registrar_indicador_impacto") ?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus"></span> Indicador impacto</a>

</div>