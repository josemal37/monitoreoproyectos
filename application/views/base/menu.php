<nav class="navbar navbar-m2p sidebar" role="navigation">

    <div class="container-fluid">

        <div class="navbar-header">

            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">

				<span class="sr-only">Toggle navigation</span>

				<span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>

            </button>

            <a class="navbar-brand" href="#">Fundación Atica</a>

        </div>

        <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">

            <ul class="nav navbar-nav">

                <!-- Inicio -->
                <li class="active open">

					<a href="#">Inicio</a>

                </li>

				<?php if ($this->session->userdata("rol") == "empleado"): ?>

					<li class="separator">Proyecto</li>

					<!-- Proyectos -->

					<li><a href="#">Ver mis proyectos</a></li>

					<li><a href="#">Registrar proyecto</a></li>

				<?php elseif ($this->session->userdata("rol") == "administrador"): ?>

					<li class="separator">Administrador</li>

					<!-- Administrador -->

					<li><a href="#">Ver usuarios del sistema</a></li>

					<li><a href="#">Registrar usuario</a></li>

				<?php endif; ?>

                <li class="separator">Sistema</li>

                <!-- Usuario -->
                <li>

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuario <span class="caret"></span></a>

					<ul class="dropdown-menu forAnimate" role="menu">

                        <li><a href="#">Modificar contraseña</a></li>

                    </ul>

                </li>

                <!-- Salir -->
                <li>

                    <a href="<?= base_url("login/cerrar_sesion") ?>">Salir</a>

                </li>

            </ul>

        </div>

    </div>

</nav>