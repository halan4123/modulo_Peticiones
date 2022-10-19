<div>
    <div class="panel-group" id="acordion_graficas">

        <!--=====================================================================================================================
        ESTADISTICAS GENERALES 
        ======================================================================================================================-->

        <div class="panel panel-default">

            <div class="panel-heading panel-heading-custom-5">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#acordion_graficas" href="#estadisticasGenerales">Estadisticas Generales</a>
                </h4>
            </div>

            <div id="estadisticasGenerales" class="panel-collapse collapse in">

                <div class="panel-body">

                    <!--=================================================
                    FILTROS GRAFICA 1 Y 2
                    ===================================================-->
                    <div class="row">

                        <div class="col-md-12">

                            <div class="well ">

                                <div class=" flex-container">

                                    <!-- FILTRO DE FECHA INICIO -->
                                    <div>
                                        <label for=" filtroFechaInicioGraficos">De:</label>
                                        <input type="date" class="form-control" id="filtroFechaInicioGraficos" onchange="">
                                    </div>

                                    <!-- FILTRO DE FECHA FINAL -->
                                    <div>
                                        <label for="filtroFechaFinalGraficos">A:</label>
                                        <input type="date" class="form-control" id="filtroFechaFinalGraficos" onchange="">
                                    </div>

                                    <div>

                                        <button type="button" class="btn btn-warning" onclick="limpiarFiltrosGraficasGeneral()">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>

                                    </div>

                                    <!-- BOTON DE BUSCAR -->
                                    <div>
                                        <button class="btn btn-success" onclick="graficarEstadisticasGenerales()"><i class="bi bi-search"></i></button>
                                    </div>


                                </div>

                            </div>

                        </div>

                    </div>

                    <!--=================================================
                    GRAFICAS - PETICIONES POR DESARROLLADOR / SOPORTE 
                    ===================================================-->
                    <div class="row">

                        <!--=================================================
                        GRAFICA DE PETICIONES POR DESARROLLADOR 
                        ===================================================-->
                        <div class="col-md-6 separacion">

                            <div class="panel panel-default">

                                <div class="panel-heading panel-heading-custom-5" style="text-align: center; ">

                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Por defecto se muestra la información del mes actual." title="Nota">Peticiones aceptadas por desarrollador <span class="bi bi-question-circle-fill"></span></label>

                                </div>

                                <div class="panel-body">

                                    <div class="dimensiones" id="contenedor-desarrollador">

                                        <canvas id="peticionesAceptadasDesarrolladores"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <!--=================================================
                        GRAFICA DE PETICIONES POR SOPORTE 
                        ===================================================-->
                        <div class="col-md-6 separacion">

                            <div class="panel panel-default">

                                <!-- <div class="panel-heading panel-heading-custom-5" style="text-align: center; ">Peticiones aceptadas por soporte</div> -->
                                <div class="panel-heading panel-heading-custom-5" style="text-align: center; ">

                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Por defecto se muestra la información del mes actual." title="Nota">Peticiones registradas por soporte <span class="bi bi-question-circle-fill"></span></label>

                                </div>

                                <div class="panel-body">
                                    <div class="dimensiones" id="contenedor-soporte">

                                        <canvas id="peticionesRegistradasSoporte"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                    <!--=================================================
                    FILTRO POR AÑO / GRAFICA 3 Y 4
                    ===================================================-->
                    <div class="row">
                        <div class="col-md-12">

                            <div class="well ">

                                <div class="flex-container">

                                    <!-- FILTRO DE AÑO -->
                                    <div class="form-group">

                                        <select class="form-control" id="filtroAnualGrafica_3" onchange="graficarAnualmente()">

                                            <?php
                                            date_default_timezone_set('America/Chihuahua');
                                            $year = 2099;
                                            $year_actual = date('Y');
                                            $year_actual = intval($year_actual);

                                            ?>

                                            <option value="<?php echo $year_actual ?>"><?php echo $year_actual ?></option>
                                            <?php
                                            for ($i = 2022; $i <= $year_actual; $i++) {
                                                if ($i == $year_actual) {
                                                    continue;
                                                } else {
                                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                                }
                                            }
                                            ?>




                                        </select>

                                    </div>



                                    <!-- <div>

                                        <button class="btn btn-success" onclick=""><i class="bi bi-search"></i></button>

                                    </div> -->




                                </div>
                            </div>

                        </div>

                    </div>

                    <!--=================================================
                    GRAFICAS - ANUALES 
                    ===================================================-->
                    <div class="row">

                        <div class="col-md-12 separacion">

                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-custom-5" style="text-align: center;"><label>Peticiones Recibidas - Completadas - Rechazadas</label> </div>
                                <div class="panel-body">
                                    <div class="dimensiones" id="contenedorMix">

                                        <canvas id="peticionesMix"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6 separacion">

                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-custom-5" style="text-align: center;"><label>Peticiones Recibidas</label></div>
                                <div class="panel-body">
                                    <div class="dimensiones" id="contenedor-anuales">

                                        <canvas id="peticionesAnuales"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6 separacion">

                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-custom-5" style="text-align: center;"><label>Peticiones Completadas </label> </div>
                                <div class="panel-body">
                                    <div class="dimensiones" id="contenedor-completadas-mes">

                                        <canvas id="peticionesCompletadasMes"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6 separacion">

                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-custom-5" style="text-align: center;"><label>Peticiones Rechazadas</label> </div>
                                <div class="panel-body">
                                    <div class="dimensiones" id="contenedor-rechazadas-mes">

                                        <canvas id="peticionesRechazadasMes"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>




                    </div>



                </div>
            </div>
        </div>


        <!--=====================================================================================================================
        ESTADISTICAS DE LABORATORIO 
        ======================================================================================================================-->
        <div class="panel panel-default">
            <div class="panel-heading panel-heading-custom-3">
                <h4 class="panel-title">
                    <a onfocus="buscadorLabGraficas()" data-toggle="collapse" data-parent="#acordion_graficas" href="#estadisticasLaboratorio">Estadisticas Laboratorios</a>
                </h4>
            </div>
            <div id="estadisticasLaboratorio" class="panel-collapse collapse ">
                <div class="panel-body">

                    <!--=================================================
                    FILTROS POR FECHAS
                    ===================================================-->
                    <div class="row">

                        <div class="col-md-12">

                            <div class="well ">

                                <div class=" flex-container">

                                    <!-- FILTRO POR LABORATORIO -->
                                    <div>
                                        <select class="form-control" id="filtroLaboratorioGrafica_2" style="width: 100%;">
                                        </select>
                                    </div>

                                    <!-- FILTRO DE FECHA INICIO -->
                                    <div>
                                        <label for=" filtroFechaInicioGraficos">De:</label>
                                        <input type="date" class="form-control" id="filtroFechaInicioGraficosLaboratorio" onchange="">
                                    </div>

                                    <!-- FILTRO DE FECHA FINAL -->
                                    <div>
                                        <label for="filtroFechaFinalGraficos">A:</label>
                                        <input type="date" class="form-control" id="filtroFechaFinalGraficosLaboratorio" onchange="">
                                    </div>

                                    <div>

                                        <button type="button" class="btn btn-warning" onclick="limpiarFiltrosGraficasLab()">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>

                                    </div>

                                    <!-- BOTON DE BUSCAR -->
                                    <div>
                                        <button class="btn btn-success" onclick="graficarEstadisticasPorFechaLab()"><i class="bi bi-search"></i></button>
                                    </div>


                                </div>

                            </div>

                        </div>

                    </div>

                    <!--=================================================
                    DATOS NUMERICOS
                    ===================================================-->
                    <div class="row flex3">

                        <div class="col-md-2 separacion">

                            <div class="panel panel-default">

                                <div class="panel-heading panel-heading-custom-3" style="text-align: center; "><label>Pendientes</label> </div>

                                <div class="contenedor-card dimensiones_2" id="">
                                    <p id="totalDatosPendientesLab"></p>
                                </div>


                            </div>
                        </div>

                        <div class="col-md-2 separacion">

                            <div class="panel panel-default">

                                <div class="panel-heading panel-heading-custom-3" style="text-align: center; "><label>En Desarrollo</label></div>

                                <div class="contenedor-card dimensiones_2" id="">
                                    <p id="totalDatosDesarrolloLab"></p>
                                </div>


                            </div>
                        </div>

                        <div class="col-md-2 separacion">

                            <div class="panel panel-default">

                                <div class="panel-heading panel-heading-custom-3" style="text-align: center; "><label>Completadas</label></div>

                                <div class="contenedor-card dimensiones_2" id="">
                                    <p id="totalDatosCompletadosLab"></p>
                                </div>


                            </div>
                        </div>

                        <div class="col-md-2 separacion">

                            <div class="panel panel-default">

                                <div class="panel-heading panel-heading-custom-3" style="text-align: center; "><label>Rechazadas</label></div>

                                <div class="contenedor-card dimensiones_2" id="">
                                    <p id="totalDatosRechazadosLab"></p>
                                </div>


                            </div>
                        </div>



                        <div class="col-md-2 separacion">

                            <div class="panel panel-default">

                                <div class="panel-heading panel-heading-custom-3" style="text-align: center; "><label>Total</label></div>

                                <div class="contenedor-card dimensiones_2" id="">
                                    <p id="totalDatosLab"></p>
                                </div>

                            </div>
                        </div>

                    </div>

                    <!--=================================================
                    GRAFICAS 
                    ===================================================-->
                    <div class="row">

                        <!--=================================================
                        GRAFICA 
                        ===================================================-->
                        <div class="col-md-6 separacion">

                            <div class="panel panel-default">

                                <div class="panel-heading panel-heading-custom-3" style="text-align: center; "><label>Peticiones Recibidas - Completadas - Rechazadas</label>



                                </div>

                                <div class="panel-body">

                                    <div class="dimensiones" id="contenedor-lab-fechas">

                                        <canvas id="peticionesLabFechas"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>


                    <!--=================================================
                    FILTROS ANUAL
                    ===================================================-->
                    <div class="row">

                        <div class="col-md-12">

                            <div class="well ">

                                <div class=" flex-container">

                                    <!-- FILTRO POR LABORATORIO -->
                                    <div>
                                        <select class="form-control" id="filtroLaboratorioGrafica" style="width: 100%;">
                                        </select>
                                    </div>

                                    <!-- FILTRO DE AÑO -->
                                    <div class="form-group">

                                        <select class="form-control" id="filtroAnualGraficaLab">


                                            <?php
                                            date_default_timezone_set('America/Chihuahua');
                                            $year = 2099;
                                            $year_actual = date('Y');
                                            $year_actual = intval($year_actual);

                                            ?>

                                            <option value="<?php echo $year_actual ?>"><?php echo $year_actual ?></option>
                                            <?php
                                            for ($i = 2022; $i <= $year_actual; $i++) {
                                                if ($i == $year_actual) {
                                                    continue;
                                                } else {
                                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>

                                    <div>

                                        <button class="btn btn-success" onclick="graficarEstadisticasLaboratorios()"><i class="bi bi-search"></i></button>
                                        <!-- <button class="btn btn-success" onclick=""><i class="bi bi-search"></i></button> -->

                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                    <!--=================================================
                    GRAFICA DE LABORATORIOS ANUAL
                    ===================================================-->
                    <div class="row">

                        <!-- Peticiones Recibidas - Completadas - Rechazadas -->
                        <div class="col-md-12 separacion">

                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-custom-3" style="text-align: center;"><label>Peticiones Recibidas - Completadas - Rechazadas</label> </div>
                                <div class="panel-body">
                                    <div class="dimensiones" id="contenedorLabGrafica">

                                        <canvas id="peticionesPorLaboratorio"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <!-- Peticiones Recibidas-->
                        <div class="col-md-6 separacion">

                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-custom-3" style="text-align: center;"><label>Peticiones Recibidas</label></div>
                                <div class="panel-body">
                                    <div class="dimensiones" id="contenedor-lab-recibidas">

                                        <canvas id="peticionesPorLaboratorioRecibidas"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <!-- Peticiones Completadas-->
                        <div class="col-md-6 separacion">

                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-custom-3" style="text-align: center;"><label>Peticiones Completadas</label></div>
                                <div class="panel-body">
                                    <div class="dimensiones" id="contenedor-lab-completadas">

                                        <canvas id="peticionesPorLaboratorioCompletadas"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <!-- Peticiones Rechazadas-->
                        <div class="col-md-6 separacion">

                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-custom-3" style="text-align: center;"><label>Peticiones Rechazadas</label></div>
                                <div class="panel-body">
                                    <div class="dimensiones" id="contenedor-lab-rechazadas">

                                        <canvas id="peticionesPorLaboratorioRechazadas"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>


                    </div>


                </div>
            </div>
        </div>


        <!--=====================================================================================================================
        ESTADISTICAS DE DESARROLLADOR 
        ======================================================================================================================-->
        <div class="panel panel-default">
            <div class="panel-heading panel-heading-custom-2">
                <h4 class="panel-title">
                    <a onfocus="buscadorEstadisticasDesarrolladores()" data-toggle="collapse" data-parent="#acordion_graficas" href="#estadisticasDesarrollador">Estadisticas Desarrolladores</a>
                </h4>
            </div>
            <div id="estadisticasDesarrollador" class="panel-collapse collapse ">
                <div class="panel-body">

                    <!--=================================================
                    FILTROS POR FECHAS PARA COMPARAR A CADA DESAROLLADOR
                    ===================================================-->
                    <div class="row">

                        <div class="col-md-12">

                            <div class="well ">

                                <div class=" flex-container">

                                    <div id="filtroDes_opcion_1">

                                        <select class="form-control" id="filtroDesarrolladorGrafica_all" style="width: 100%;">

                                        </select>

                                    </div>

                                    <div id="filtroDes_opcion_2">

                                        <select class="form-control" id="filtroDesarrolladorGrafica" style="width: 100%;">

                                        </select>

                                    </div>

                                    <!-- FILTRO DE AÑO -->
                                    <div id="filtroYeardDes" class="form-group">

                                        <select class="form-control" id="filtroAnualGraficaDesarrollador">


                                            <?php
                                            date_default_timezone_set('America/Chihuahua');
                                            $year_actual = date('Y');
                                            $year_actual = intval($year_actual);

                                            ?>

                                            <option value="<?php echo $year_actual ?>"><?php echo $year_actual ?></option>
                                            <?php
                                            for ($i = 2022; $i <= $year_actual; $i++) {
                                                if ($i == $year_actual) {
                                                    continue;
                                                } else {
                                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>

                                    <!-- FILTRO DE MES -->
                                    <div id="filtroMonthDes">
                                        <label for=" filtroMes_1">De:</label>
                                        <input type="month" class="form-control" id="filtroMes_1" onchange="">
                                    </div>

                                    <div id="limpiar_opcion_1">
                                        <button type="button" class="btn btn-warning" onclick="limpiarFiltrosSeccion1Desarrolladores()">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                    </div>

                                    <div id="limpiar_opcion_2">
                                        <button type="button" class="btn btn-warning" onclick="limpiarDesMensual()">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                    </div>

                                    <div id="buscar_opcion_1">
                                        <button class="btn btn-success" onclick="graficarComparacionDesarrolladores()"><i class="bi bi-search"></i></button>
                                    </div>

                                    <div id="buscar_opcion_2">
                                        <button class="btn btn-success" onclick="graficarDesarrolladorMes()"><i class="bi bi-search"></i></button>
                                    </div>

                                    <div>
                                        <button id="opcion_1" class="btn btn-default" onclick="opcionAnual()">Anual</button>
                                    </div>

                                    <div>
                                        <button id="opcion_2" class="btn btn-default" onclick="opcionDiasMes()">Mensual</button>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!--=================================================
                    RENDIMIENTO POR DESARROLLADOR
                    ===================================================-->
                    <div class="row">

                        <div class="col-md-12 separacion" id="rendimiento_1">

                            <div class="panel panel-default">

                                <div class="panel-heading panel-heading-custom-2" style="text-align: center; ">
                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Rendimiento en base a las peticiones completadas." title="Nota">Rendimiento <span class="bi bi-question-circle-fill"></span></label>
                                </div>

                                <div class="panel-body">

                                    <div class="dimensiones" id="contenedor-comparacion-desarrollador">

                                        <canvas id="desarrolladorComparacion"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-12 separacion" id="rendimiento_2">

                            <div class="panel panel-default">

                                <div class="panel-heading panel-heading-custom-2" style="text-align: center; ">
                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Rendimiento en base a las peticiones completadas." title="Nota">Rendimiento <span class="bi bi-question-circle-fill"></span></label>
                                </div>

                                <div class="panel-body">

                                    <div class="dimensiones" id="contenedor-comparacion-desarrollador-diasMes">

                                        <canvas id="desarrolladorComparacionDiasMes"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>


                    </div>

                    <!--=================================================
                    FILTROS POR FECHAS
                    ===================================================-->
                    <div class="row">

                        <div class="col-md-12">

                            <div class="well ">

                                <div class=" flex-container">

                                    <div>

                                        <select class="form-control" id="filtroDesarrolladorGrafica_3" style="width: 100%;">

                                            <!-- <option value='0'>Valor</option> -->

                                        </select>

                                    </div>

                                    <!-- FILTRO DE FECHA INICIO -->
                                    <div>
                                        <label for=" filtroFechaInicioGraficosDesarrollador">De:</label>
                                        <input type="date" class="form-control" id="filtroFechaInicioGraficosDesarrolladorPersonal" onchange="">
                                    </div>

                                    <!-- FILTRO DE FECHA FINAL -->
                                    <div>
                                        <label for="filtroFechaFinalGraficosDesarrollador">A:</label>
                                        <input type="date" class="form-control" id="filtroFechaFinalGraficosDesarrolladorPersonal" onchange="">
                                    </div>

                                    <div>

                                        <button type="button" class="btn btn-warning" onclick="limpiarFiltrosGraficasDesa()">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>

                                    </div>

                                    <div>

                                        <button class="btn btn-success" onclick="graficarEstadisticasDesarrolladores()"><i class="bi bi-search"></i></button>
                                        <!-- <button class="btn btn-success" onclick=""><i class="bi bi-search"></i></button> -->

                                    </div>


                                </div>

                            </div>

                        </div>

                    </div>

                    <!--=================================================
                    DATOS NUMERICOS
                    ===================================================-->
                    <div class="row flex3">

                        <div class="col-md-2 separacion">

                            <div class="panel panel-default">

                                <div class="panel-heading panel-heading-custom-2" style="text-align: center; "><label>Pendientes</label> </div>

                                <div class="contenedor-card dimensiones_2" id="">
                                    <p id="totalDatosPendientes"></p>
                                </div>


                            </div>
                        </div>

                        <div class="col-md-2 separacion">

                            <div class="panel panel-default">

                                <div class="panel-heading panel-heading-custom-2" style="text-align: center; "><label>En Desarrollo</label></div>

                                <div class="contenedor-card dimensiones_2" id="">
                                    <p id="totalDatosDesarrollo"></p>
                                </div>


                            </div>
                        </div>

                        <div class="col-md-2 separacion">

                            <div class="panel panel-default">

                                <div class="panel-heading panel-heading-custom-2" style="text-align: center; "><label>Completadas</label></div>

                                <div class="contenedor-card dimensiones_2" id="">
                                    <p id="totalDatosCompletados"></p>
                                </div>


                            </div>
                        </div>

                        <div class="col-md-2 separacion">

                            <div class="panel panel-default">

                                <div class="panel-heading panel-heading-custom-2" style="text-align: center; "><label>Rechazadas</label></div>

                                <div class="contenedor-card dimensiones_2" id="">
                                    <p id="totalDatosRechazados"></p>
                                </div>


                            </div>
                        </div>



                        <div class="col-md-2 separacion">

                            <div class="panel panel-default">

                                <div class="panel-heading panel-heading-custom-2" style="text-align: center; "><label>Total</label></div>

                                <div class="contenedor-card dimensiones_2" id="">
                                    <p id="totalDatosDes"></p>
                                </div>

                            </div>
                        </div>

                    </div>

                    <!--=================================================
                    RENDIMIENTO POR DESARROLLADOR
                    ===================================================-->
                    <div class="row">

                        <div class="col-md-12 separacion">

                            <div class="panel panel-default">

                                <div class="panel-heading panel-heading-custom-2" style="text-align: center; "><label>Desempeño por desarrollador</label></div>

                                <div class="panel-body">

                                    <div class="dimensiones" id="contenedor-grafica-desarrollador-pendiente">

                                        <canvas id="desarrolladorGraficaPendiente"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>



                </div>
            </div>
        </div>

    </div>

</div>