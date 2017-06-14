<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#reporte">Reporte</button>

<!-- Modal -->

<div id="reporte" class="modal fade" role="dialog">

	<div class="modal-dialog">

		<div class="modal-content">

			<form action="<?= base_url("reporte/avances_docx/" . $proyecto->id) ?>" id="form-reporte" method="post">

				<div class="modal-header">

					<button type="button" class="close" data-dismiss="modal">&times;</button>

					<h4 class="modal-title">Reporte</h4>

				</div>

				<div class="modal-body">

					<h4>Actividades</h4>

					<div class="text-center">

						<div class="radio-inline">

							<label><input type="radio" name="fecha-actividades" value="todas" checked> Todas las actividades</label>

						</div>

						<div class="radio-inline">

							<label><input type="radio" name="fecha-actividades" value="periodo"> Seleccionar periodo</label>

						</div>

					</div>

					<div id="contenedor-fecha-actividades" style="display: none;">

						<div class="container-fluid">

							<div class="row">

								<div class="col-sm-6">

									<div class="form-group">

										<label>Fecha de inicio</label>

										<input type="text" id="fecha-inicio-actividades" name="fecha-inicio-actividades" class="form-control">

									</div>

								</div>

								<div class="col-sm-6">

									<div class="form-group">

										<label>Fecha de fin</label>

										<input type="text" id="fecha-fin-actividades" name="fecha-fin-actividades" class="form-control">

									</div>

								</div>

							</div>

						</div>

					</div>

					<h4>Periodo de avances</h4>

					<div class="text-center">

						<div class="radio-inline">

							<label><input type="radio" name="fecha-avances" value="todos" checked> Todos los avances</label>

						</div>

						<div class="radio-inline">

							<label><input type="radio" name="fecha-avances" value="periodo"> Seleccionar periodo</label>

						</div>

					</div>

					<div id="contenedor-fecha-avances" style="display: none;">

						<div class="container-fluid">

							<div class="row">

								<div class="col-sm-6">

									<div class="form-group">

										<label>Fecha de inicio</label>

										<input type="text" id="fecha-inicio-avances" name="fecha-inicio-avances" class="form-control">

									</div>

								</div>

								<div class="col-sm-6">

									<div class="form-group">

										<label>Fecha de fin</label>

										<input type="text" id="fecha-fin-avances" name="fecha-fin-avances" class="form-control">

									</div>

								</div>

							</div>

						</div>

					</div>

				</div>

				<div class="modal-footer">

					<input type="submit" id="submit" name="submit" value="Aceptar" class="btn btn-primary">

				</div>

			</form>

		</div>

	</div>

</div>

<script type="text/javascript">
    $("#fecha-inicio-actividades").datepicker({dateFormat: 'yy-mm-dd'});
    $("#fecha-fin-actividades").datepicker({dateFormat: 'yy-mm-dd'});
    $("#fecha-inicio-avances").datepicker({dateFormat: 'yy-mm-dd'});
    $("#fecha-fin-avances").datepicker({dateFormat: 'yy-mm-dd'});

    $("input[name=fecha-actividades]").on("change", function () {
        var fecha_actividades = $("input[name=fecha-actividades]:checked").val();
        if (fecha_actividades == "todas") {
            $("#contenedor-fecha-actividades").hide();
        } else {
            $("#contenedor-fecha-actividades").show();
        }
    });

    $("input[name=fecha-avances]").on("change", function () {
        var fecha_avances = $("input[name=fecha-avances]:checked").val();
        if (fecha_avances == "todos") {
            $("#contenedor-fecha-avances").hide();
        } else {
            $("#contenedor-fecha-avances").show();
        }
    });
</script>