<div class="panel-group" id="accordionHistorialPeticionesData">

    <div class="panel panel-default">

        <div class="panel-heading panel-heading-custom-1">
            <h4 class="panel-title">
                <a class="not-active" data-toggle="collapse" data-parent="#accordionHistorialPeticionesData" href="#historialAccordionData">
                    Modificaciones de peticiones</a>
            </h4>
        </div>

        <div id="historialAccordionData" class="panel-collapse collapse in">

            <div class="panel-body">



                <!--========================
                INFO BOTON
                ========================-->
                <div class="row">
                    <div class="col-md-12">

                        <div class="well ">

                            <div class="flex-container_4">

                                <div>
                                    <label class="btn color-pendiente-btn-info" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="
                                   
                                    Cada fila muestra la información anteriror de dicha petición al momento de ser actualizada o eliminada de alguna forma,
                                    se ordena por fecha de moficación desde la modificación mas reciente a la mas antigua. <br>
                                    " title="<b>Orden de las peticiones</b>"><span class="bi bi-question-lg"></span></label>
                                </div>
                            </div>

                            <div class="flex-container">

                                <?php
                                date_default_timezone_set('America/Chihuahua'); //ESTABLECEMOS ZONA HORARIA
                                $fecha_hoy = date("Y-m-d");
                                $fecha_hoy_2 = date("Y-m-d");
                                ?>

                                <!-- FILTRO DE FECHA INICIO -->
                                <div>
                                    <label for="filtroFechaInicioModificaciones">De:</label>
                                    <input type="date" class="form-control" id="filtroFechaInicioModificaciones" value="<?php echo date("Y-m-d", strtotime($fecha_hoy));  ?>" onchange="">
                                </div>

                                <!-- FILTRO DE FECHA FINAL -->
                                <div>
                                    <label for="filtroFechaFinalModificaciones">A:</label>
                                    <input type="date" class="form-control" id="filtroFechaFinalModificaciones" value="<?php echo date("Y-m-d", strtotime($fecha_hoy_2));  ?>" onchange="">
                                </div>

                                <div>

                                    <button type="button" class="btn btn-warning" onclick="limpiarFiltrosModificaciones()">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>

                                </div>

                                <div>

                                    <button class="btn btn-info" onclick="mostrarModificacionesHistorial()"><i class="bi bi-search"></i></button>


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
                        <div id="displayDataTableHistorialModificaciones">


                        </div>

                    </div>

                </div>



            </div>
        </div>

    </div>

</div>