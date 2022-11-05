<div class="panel-group" id="accordion">






    <!--=====================================================================================================================
    BUSCADOR DE PENDIENTES - FILTROS - GENERADOR DE EXCEL
    ======================================================================================================================-->
    <div class="panel panel-default">
        <div class="panel-heading panel-heading-custom-6">
            <h4 class="panel-title">
                <a onfocus="displayData()" data-toggle="collapse" data-parent="#accordion" href="#buscadorPeticiones">
                    Buscador De Peticiones</a>
            </h4>
        </div>
        <div id="buscadorPeticiones" class="panel-collapse collapse">
            <div class="panel-body">

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
                FILTROS 
                ========================-->
                <div class="row">
                    <div class="col-md-12">

                        <div class="well ">
                            <div class="flex-container_3">
                                <div>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAgregar">
                                        Agregar Petición
                                    </button>
                                </div>

                                <div>
                                    <label class="btn color-buscador-btn-info" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="
                                   
                                    <b>1: </b>Peticiones pendientes. <br>
                                    <br>
                               
                                    <b>2: </b>Peticiones por fecha de llegada. <br>
                                    <br>
                                
                                    <b>3: </b>Peticiones en desarrollo. <br>
                                    <br>
                         
                                    <b>4: </b>Peticiones completadas. <br>
                                    <br>

                                    <b>5: </b>Peticiones rechazadas. <br> 
                                    <br>
                                    " title="<b>Orden de las peticiones</b>"><span class="bi bi-question-lg"></span></label>
                                </div>
                            </div>

                            <div class="flex-container_2">

                                <!-- <div>

                                    <button type="button" class="btn btn-success" onclick="window.location = 'excel.php?fechaInicio='+$('#filtroFechaInicio').val() + '&fechaFinal='+$('#filtroFechaFinal').val()">
                                        <i class="bi bi-filetype-xls"></i>
                                    </button>

                                </div> -->

                                <div>

                                    <button type="button" class="btn btn-warning" onclick="limpiarFiltros()">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>

                                </div>

                                <div>

                                    <button class="btn btn-info" onclick="displayData()"><i class="bi bi-search"></i></button>


                                </div>



                            </div>


                            <div class="flex-container">

                                <!-- FILTRO DE LABORATORIO -->
                                <div class="form-group">
                                    <div class="input-group">
                                        <select class="form-control" id="filtroLaboratorioPeti">
                                        </select>
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" onclick="limpiarLaboratorio()"><i class="bi bi-arrow-clockwise"></i></button>
                                        </span>
                                    </div>
                                </div>


                                <!-- FILTRO DE NIVEL -->
                                <div class="form-group">
                                    <div class="input-group">
                                        <select class="form-control" id="filtroNivel">
                                        </select>
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" onclick="limpiarNivel()"><i class="bi bi-arrow-clockwise"></i></button>
                                        </span>
                                    </div>
                                </div>

                                <!-- FILTRO DE SOPORTE -->
                                <div class="form-group">
                                    <div class="input-group">
                                        <select class="form-control" id="filtroSoportePeti">
                                        </select>
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" onclick="limpiarSoportew()"><i class="bi bi-arrow-clockwise"></i></button>
                                        </span>
                                    </div>
                                </div>

                                <!-- FILTRO DE DESARROLLADOR -->
                                <div class="form-group">
                                    <div class="input-group">
                                        <select class="form-control" id="filtroDesarrolladorPeti">
                                        </select>
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" onclick="limpiarDesarrolladorw()"><i class="bi bi-arrow-clockwise"></i></button>
                                        </span>
                                    </div>
                                </div>


                                <!-- FILTRO DE ESTATUS -->
                                <div class="form-group">
                                    <div class="input-group">
                                        <select class="form-control" id="filtroEstatus">
                                        </select>
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" onclick="limpiarEstatusw()"><i class="bi bi-arrow-clockwise"></i></button>
                                        </span>
                                    </div>
                                </div>

                                <?php
                                date_default_timezone_set('America/Chihuahua'); //ESTABLECEMOS ZONA HORARIA
                                $fecha_hoy = date("Y-m-d");
                                $fecha_hoy_2 = date("Y-m-d");
                                ?>

                                <!-- FILTRO DE FECHA INICIO -->
                                <div>
                                    <label for=" filterFechaInicio">De:</label>
                                    <input type="date" class="form-control" id="filtroFechaInicio" value="<?php echo date("Y-m-d", strtotime($fecha_hoy));  ?>" onchange="">
                                </div>

                                <!-- FILTRO DE FECHA FINAL -->
                                <div>
                                    <label for="filterFechaFinal">A:</label>
                                    <input type="date" class="form-control" id="filtroFechaFinal" value="<?php echo date("Y-m-d", strtotime($fecha_hoy_2));  ?>" onchange="">
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
        </div>
    </div>


</div>