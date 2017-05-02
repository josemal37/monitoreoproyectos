<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<?php $this->load->view("base/menu"); ?>

<div class="container-main">

	<?php $this->load->view($contenido); ?>

</div>

<?php $this->load->view("base/footer"); ?>