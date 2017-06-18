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

<script type="text/javascript">
    $(".progress-bar").each(function () {
        var $this = $(this);
        var porcentaje = parseFloat($this[0].style.width);
        if (porcentaje < 33.33) {
            $this.addClass("progress-bar-danger");
        } else if (porcentaje >= 33.33 && porcentaje < 66.67) {
            $this.addClass("progress-bar-warning");
        } else {
            $this.addClass("progress-bar-success");
        }
    });
</script>