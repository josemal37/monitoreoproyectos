<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $tiene_efectos = FALSE; ?>

<div class="container-fluid">

	<div class="marco-logico">

		<?php $this->load->view("marco_logico/datos_generales"); ?>

		<hr>

		<?php $this->load->view("marco_logico/indicadores_impacto"); ?>

		<hr>

		<?php $this->load->view("marco_logico/resultados"); ?>

		<hr>

		<?php $this->load->view("marco_logico/resultados_clave"); ?>

		<hr>

		<?php $this->load->view("marco_logico/efectos"); ?>

	</div>

</div>