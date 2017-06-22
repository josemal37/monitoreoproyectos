<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="datos-generales" class="datos-generales">

	<!-- Nombre del proyecto -->

	<h1><?= $proyecto->nombre ?></h1>

	<?php if ($this->uri->segment(2) == "ver_personal_proyecto"): ?>

		<a href="<?= base_url("reporte/personal_docx/" . $proyecto->id) ?>" class="btn btn-primary">Reporte</a>

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

</div>