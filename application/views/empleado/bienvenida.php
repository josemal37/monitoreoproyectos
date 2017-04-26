<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="text-center">

	<h1><?= $titulo ?></h1>

</div>

<div class="container">

	<p>Bienvenido al sistema</p>

	<a href="<?= base_url("login/cerrar_sesion") ?>">Cerrar sesión</a>

</div>

<?php $this->load->view("base/footer"); ?>