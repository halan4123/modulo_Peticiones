<div>
    <!--========================
    ICONOS DE REFERENCIA
    ========================-->
    <div class="row">

        <div class="col-md-12">

            <label class="referencia">
                <i style="color: green;" class="tam-i bi bi-check-circle-fill" aria-hidden="true"></i>Completado
            </label>

            <label class="referencia">
                <i style="color: #2995B8;" class="tam-i bi bi-laptop-fill" aria-hidden="true"></i>Desarrollo
            </label>

            <label class="referencia">
                <i style="color: orange;" class="tam-i bi bi-exclamation-triangle-fill" aria-hidden="true"></i>Pendiente
            </label>

            <label class="referencia">
                <i style="color: red;" class="tam-i bi bi-x-circle-fill" aria-hidden="true"></i>Rechazado
            </label>

            <label class="referencia">
                <i style="color: #363332;" class="tam-i bi bi-question-square-fill" aria-hidden="true"></i>Sin Definir
            </label>

        </div>
    </div>

    <!--========================
    FILTROS & BOTON AGREGAR
    ========================-->
    <div class="row">
        <div class="col-md-12">

            <div class="well ">

                <div class="flex-container_2">

                    <div>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAgregar">
                            Agregar Petición
                        </button>
                    </div>

                    <div>

                        <button type="button" class="btn btn-primary" onclick="window.location = 'excel.php?fechaInicio='+$('#filtroFechaInicio').val() + '&fechaFinal='+$('#filtroFechaFinal').val()">
                            Generar Excel
                        </button>

                    </div>

                </div>




                <div class=" flex-container">

                    <!-- FILTRO DE LABORATORIO -->
                    <div>
                        <label for="filtroLaboratorio">Laboratorio:</label>
                        <select class="form-control" id="filtroLaboratorio" onchange="displayData()">

                            <option value="todo">Todo</option>

                            <?php foreach ($laboratorios as $laboratorio) : ?>

                                <option value="<?php echo $laboratorio['ID_LABORATORIO']; ?>"><?php echo $laboratorio['NOMBRE']; ?></option>


                            <?php endforeach; ?>



                        </select>
                    </div>

                    <!-- FILTRO DE NIVEL -->
                    <div>
                        <label for="filtroNivel">Nivel:</label>
                        <select class="form-control" id="filtroNivel" onchange="displayData()">

                            <option value="todo">Todo</option>

                            <?php foreach ($niveles as $nivel) : ?>

                                <option value="<?php echo $nivel['ID_NIVEL']; ?>"><?php echo $nivel['NIVEL']; ?></option>


                            <?php endforeach; ?>



                        </select>
                    </div>

                    <!-- FILTRO DE ESTATUS -->
                    <div>
                        <label for="filtroEstatus">Estatus:</label>
                        <select class="form-control" id="filtroEstatus" onchange="displayData()">

                            <option value="todo">Todo</option>

                            <?php foreach ($soportes as $soporte) : ?>

                                <option value="<?php echo $soporte['ID_ESTATUS']; ?>"><?php echo $soporte['ESTATUS']; ?></option>


                            <?php endforeach; ?>


                        </select>
                    </div>

                    <!-- FILTRO DE FECHA INICIO -->
                    <div>
                        <label for=" filterFechaInicio">De:</label>
                        <input type="date" class="form-control" id="filtroFechaInicio" onchange="displayData()">
                    </div>

                    <!-- FILTRO DE FECHA FINAL -->
                    <div>
                        <label for="filterFechaFinal">A:</label>
                        <input type="date" class="form-control" id="filtroFechaFinal" onchange="displayData()">
                    </div>


                </div>

            </div>
        </div>

    </div>

    <!--========================
    TABLA
    ========================-->
    <div class="row">

        <div class="col-md-12">

            <!-- AQUI SE GENERA LA TABLA -->
            <div id="displayDataTable">

            </div>

        </div>

    </div>

</div>