<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("base/header"); ?>

<div class="login">

	<div class="titulo">

		<div class="container-fluid">

			<h1><?= $titulo ?></h1>

		</div>

	</div>

	<div class="ingreso">

		<div class="container-fluid">

			<div class="row">

				<div class="col-sm-3 col-md-4"></div>

				<div class="col-sm-6 col-md-4">

					<div class="formulario">

						<div class="titulo">

							<h2>Ingresar al sistema</h2>

						</div>

						<?php $this->load->view("login/contenido_formulario_login"); ?>

					</div>

				</div>

				<div class="col-sm-3 col-md-4"></div>

			</div>

		</div>

	</div>

</div>

<?php $this->load->view("base/footer"); ?>