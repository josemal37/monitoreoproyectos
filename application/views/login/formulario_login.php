<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="text-center">

	<h1><?= $titulo ?></h1>

</div>

<div class="container">

	<h2>Ingresar al sistema</h2>

	<?php $this->load->view("login/contenido_formulario_login"); ?>

</div>

<?php $this->load->view("base/footer"); ?>