<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<nav class="navbar navbar-m2p sidebar" role="navigation">

    <div class="container-fluid">

        <div class="navbar-header">

            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">

				<span class="sr-only">Toggle navigation</span>

				<span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>

            </button>

            <a class="navbar-brand" href="<?= base_url() ?>">Fundación Atica</a>

        </div>

        <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">

            <ul class="nav navbar-nav">

                <!-- Inicio -->
                <li <?php if ($this->uri->segment(1) == "administrador" || $this->uri->segment(1) == "empleado"): ?>class="active open"<?php endif; ?>>

					<a href="<?= base_url() ?>">Inicio<span class="glyphicon glyphicon-menu-hamburger pull-right"></span></a>

                </li>

				<?php if ($this->session->userdata("rol") == "empleado"): ?>

					<li class="separator">Proyecto</li>

					<!-- Proyectos -->

					<li <?php if ($this->uri->segment(1) == "proyecto" && $this->uri->segment(2) == "proyectos"): ?>class="active open"<?php endif; ?>>

						<a href="<?= base_url("proyecto/proyectos")?>">Ver mis proyectos<span class="glyphicon glyphicon-th-list pull-right"></span></a>

					</li>

					<li <?php if ($this->uri->segment(1) == "proyecto" && $this->uri->segment(2) == "registrar_proyecto"): ?>class="active open"<?php endif; ?>>
						
						<a href="<?= base_url("proyecto/registrar_proyecto")?>">Registrar proyecto<span class="glyphicon glyphicon-plus-sign pull-right"></span></a>
					
					</li>

				<?php elseif ($this->session->userdata("rol") == "administrador"): ?>

					<li class="separator">Administrador</li>

					<!-- Administrador -->

					<li <?php if ($this->uri->segment(1) == "usuario" && $this->uri->segment(2) == "usuarios"): ?>class="active open"<?php endif; ?>>

						<a href="<?= base_url("usuario/usuarios") ?>">Ver usuarios del sistema<span class="glyphicon glyphicon-th-list pull-right"></span></a>

					</li>

					<li <?php if ($this->uri->segment(1) == "usuario" && $this->uri->segment(2) == "registrar_usuario"): ?>class="active open"<?php endif; ?>>

						<a href="<?= base_url("usuario/registrar_usuario") ?>">Registrar usuario<span class="glyphicon glyphicon-plus-sign pull-right"></span></a>

					</li>

				<?php endif; ?>

                <li class="separator">Sistema</li>

                <!-- Usuario -->
                <li>

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuario <span class="caret"></span><span class="glyphicon glyphicon-user pull-right"></span></a>

					<ul class="dropdown-menu forAnimate" role="menu">

                        <li><a href="<?= base_url("usuario/modificar_password") ?>">Modificar contraseña<span class="glyphicon glyphicon-pencil pull-right"></span></a></li>

                    </ul>

                </li>

                <!-- Salir -->
                <li>

                    <a href="<?= base_url("login/cerrar_sesion") ?>">Salir<span class="glyphicon glyphicon-remove pull-right"></span></a>

                </li>

            </ul>

        </div>

    </div>

</nav>