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

                                    <?php
                                    date_default_timezone_set('America/Chihuahua'); //ESTABLECEMOS ZONA HORARIA

                                    //PRIMER DIA DEL MES ACTUAL
                                    $month = date('m');
                                    $year = date('Y');
                                    $primer_dia = date('Y-m-d', mktime(0,0,0, $month, 1, $year));

                                    //ULTIMO DIA DEL MES ACTUAL
                                    $day = date("d", mktime(0,0,0, $month+1, 0, $year));
                                    $ultimo_dia =date('Y-m-d', mktime(0,0,0, $month, $day, $year));
                                    ?>

                                    <!-- FILTRO DE FECHA INICIO -->
                                    <div>
                                        <label for=" filtroFechaInicioGraficos">De:</label>
                                        <input type="date" class="form-control" id="filtroFechaInicioGraficos" value="<?php echo date("Y-m-d", strtotime($primer_dia));  ?>" onchange="">
                                    </div>

                                    <!-- FILTRO DE FECHA FINAL -->
                                    <div>
                                        <label for="filtroFechaFinalGraficos">A:</label>
                                        <input type="date" class="form-control" id="filtroFechaFinalGraficos" value="<?php echo date("Y-m-d", strtotime($ultimo_dia));  ?>" onchange="">
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

                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Por defecto se muestra la informaci??n del mes actual." title="<b>Nota</b>">Peticiones asignadas a desarrollador <span class="bi bi-question-circle-fill"></span></label>

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

                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Por defecto se muestra la informaci??n del mes actual." title="<b>Nota</b>">Peticiones registradas por soporte <span class="bi bi-question-circle-fill"></span></label>

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
                    FILTRO POR A??O / GRAFICA 3 Y 4
                    ===================================================-->
                    <div class="row">
                        <div class="col-md-12">

                            <div class="well ">

                                <div class="flex-container">

                                    <!-- FILTRO DE A??O -->
                                    <div class="form-group">

                                        <select class="form-control" id="filtroAnualGrafica_3" onchange="graficarAnualmente()">

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
                                <!-- <div class="panel-heading panel-heading-custom-5" style="text-align: center;"><label>Peticiones Recibidas - Completadas - Rechazadas</label> </div> -->

                                <div class="panel-heading panel-heading-custom-5" style="text-align: center; ">

                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Muestra informaci??n de las peticiones recibidas, completadas y rechazadas durante el a??o seleccionado." title="<b>Nota</b>">Peticiones Recibidas - Completadas - Rechazadas <span class="bi bi-question-circle-fill"></span></label>

                                </div>

                                <div class="panel-body">
                                    <div class="dimensiones" id="contenedorMix">

                                        <canvas id="peticionesMix"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6 separacion">

                            <div class="panel panel-default">
                                <!-- <div class="panel-heading panel-heading-custom-5" style="text-align: center;"><label>Peticiones Recibidas</label></div> -->

                                <div class="panel-heading panel-heading-custom-5" style="text-align: center; ">

                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Muestra informaci??n de las peticiones recibidas por mes durante el a??o seleccionado." title="<b>Nota</b>">Peticiones Recibidas <span class="bi bi-question-circle-fill"></span></label>

                                </div>
                                <div class="panel-body">
                                    <div class="dimensiones" id="contenedor-anuales">

                                        <canvas id="peticionesAnuales"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6 separacion">

                            <div class="panel panel-default">
                                <!-- <div class="panel-heading panel-heading-custom-5" style="text-align: center;"><label>Peticiones Completadas </label> </div> -->

                                <div class="panel-heading panel-heading-custom-5" style="text-align: center; ">

                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Muestra informaci??n de las peticiones completadas por mes durante el a??o seleccionado." title="<b>Nota</b>">Peticiones Completadas <span class="bi bi-question-circle-fill"></span></label>

                                </div>
                                <div class="panel-body">
                                    <div class="dimensiones" id="contenedor-completadas-mes">

                                        <canvas id="peticionesCompletadasMes"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6 separacion">

                            <div class="panel panel-default">
                                <!-- <div class="panel-heading panel-heading-custom-5" style="text-align: center;"><label>Peticiones Rechazadas</label> </div> -->

                                <div class="panel-heading panel-heading-custom-5" style="text-align: center; ">

                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Muestra informaci??n de las peticiones rechazadas por mes durante el a??o seleccionado." title="<b>Nota</b>">Peticiones Rechazadas <span class="bi bi-question-circle-fill"></span></label>

                                </div>
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
            <div class="panel-heading panel-heading-custom-2">
                <h4 class="panel-title">
                    <a onfocus="buscadorLabGraficas()" data-toggle="collapse" data-parent="#acordion_graficas" href="#estadisticasLaboratorio">Estadisticas Laboratorios</a>
                </h4>
            </div>
            <div id="estadisticasLaboratorio" class="panel-collapse collapse ">
                <div class="panel-body">




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

                                    <!-- FILTRO DE A??O -->
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
                                <!-- <div class="panel-heading panel-heading-custom-2" style="text-align: center;"><label>Peticiones Recibidas - Completadas - Rechazadas</label> </div> -->

                                <div class="panel-heading panel-heading-custom-2" style="text-align: center; ">

                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Muestra la informaci??n de peticiones recibidas, completadas y rechazadas, en base al laboratorio y a??o seleccionado." title="<b>Nota</b>">Peticiones Recibidas - Completadas - Rechazadas <span class="bi bi-question-circle-fill"></span></label>

                                </div>



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
                                <!-- <div class="panel-heading panel-heading-custom-2" style="text-align: center;"><label>Peticiones Recibidas</label></div> -->

                                <div class="panel-heading panel-heading-custom-2" style="text-align: center; ">

                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Muestra informaci??n de las peticiones recibidas por mes en base al laboratorio y a??o seleccionado." title="<b>Nota</b>">Peticiones Recibidas <span class="bi bi-question-circle-fill"></span></label>

                                </div>
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
                                <!-- <div class="panel-heading panel-heading-custom-2" style="text-align: center;"><label>Peticiones Completadas</label></div> -->

                                <div class="panel-heading panel-heading-custom-2" style="text-align: center; ">

                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Muestra informaci??n de las peticiones completadas por mes en base al laboratorio y a??o seleccionado." title="<b>Nota</b>">Peticiones Completadas <span class="bi bi-question-circle-fill"></span></label>

                                </div>
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
                                <!-- <div class="panel-heading panel-heading-custom-2" style="text-align: center;"><label>Peticiones Rechazadas</label></div> -->

                                <div class="panel-heading panel-heading-custom-2" style="text-align: center; ">

                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Muestra informaci??n de las peticiones rechazadas por mes en base al laboratorio y a??o seleccionado." title="<b>Nota</b>">Peticiones Rechazadas <span class="bi bi-question-circle-fill"></span></label>

                                </div>
                                <div class="panel-body">
                                    <div class="dimensiones" id="contenedor-lab-rechazadas">

                                        <canvas id="peticionesPorLaboratorioRechazadas"></canvas>

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

                                <div class="panel-heading panel-heading-custom-2" style="text-align: center; "><label>Pendientes</label> </div>

                                <div class="contenedor-card dimensiones_2" id="">
                                    <p id="totalDatosPendientesLab"></p>
                                </div>


                            </div>
                        </div>

                        <div class="col-md-2 separacion">

                            <div class="panel panel-default">

                                <div class="panel-heading panel-heading-custom-2" style="text-align: center; "><label>En Desarrollo</label></div>

                                <div class="contenedor-card dimensiones_2" id="">
                                    <p id="totalDatosDesarrolloLab"></p>
                                </div>


                            </div>
                        </div>

                        <div class="col-md-2 separacion">

                            <div class="panel panel-default">

                                <div class="panel-heading panel-heading-custom-2" style="text-align: center; "><label>Completadas</label></div>

                                <div class="contenedor-card dimensiones_2" id="">
                                    <p id="totalDatosCompletadosLab"></p>
                                </div>


                            </div>
                        </div>

                        <div class="col-md-2 separacion">

                            <div class="panel panel-default">

                                <div class="panel-heading panel-heading-custom-2" style="text-align: center; "><label>Rechazadas</label></div>

                                <div class="contenedor-card dimensiones_2" id="">
                                    <p id="totalDatosRechazadosLab"></p>
                                </div>


                            </div>
                        </div>

                        <div class="col-md-2 separacion">

                            <div class="panel panel-default">

                                <div class="panel-heading panel-heading-custom-2" style="text-align: center; "><label>Total</label></div>

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
                        <div class="col-md-12 separacion">

                            <div class="panel panel-default">

                                <!-- <div class="panel-heading panel-heading-custom-2" style="text-align: center; "><label>Peticiones Recibidas - Completadas - Rechazadas</label>



                                </div> -->

                                <div class="panel-heading panel-heading-custom-2" style="text-align: center; ">

                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Muestra informaci??n de las peticiones recibidas, completadas y rechazadas en base al laboratorio y el rango de fechas seleccionado." title="<b>Nota</b>">Peticiones Recibidas - Completadas - Rechazadas <span class="bi bi-question-circle-fill"></span></label>

                                </div>

                                <div class="panel-body">

                                    <div class="dimensiones" id="contenedor-lab-fechas">

                                        <canvas id="peticionesLabFechas"></canvas>

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
            <div class="panel-heading panel-heading-custom-3">
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

                                <div class="flex-container" style="margin-bottom: 10px;">
                                    <div>
                                        <button id="opcion_1" class="btn btn-default" onclick="opcionAnual()">Anual</button>
                                    </div>

                                    <div>
                                        <button id="opcion_2" class="btn btn-default" onclick="opcionDiasMes()">Mensual</button>
                                    </div>
                                </div>



                                <div class=" flex-container">

                                    <div id="filtroDes_opcion_1">

                                        <select class="form-control" id="filtroDesarrolladorGrafica_all" style="width: 100%;">

                                        </select>

                                    </div>

                                    <div id="filtroDes_opcion_2">

                                        <select class="form-control" id="filtroDesarrolladorGrafica" style="width: 100%;">

                                        </select>

                                    </div>

                                    <!-- FILTRO DE A??O -->
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

                                <!-- <div class="panel-heading panel-heading-custom-3" style="text-align: center; ">
                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Rendimiento en base a las peticiones completadas." title="Nota">Rendimiento Anual <span class="bi bi-question-circle-fill"></span></label>
                                </div> -->

                                <div class="panel-heading panel-heading-custom-3" style="text-align: center; ">

                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Rendimiento anual en base a las peticiones completadas por desarrollador." title="<b>Nota</b>">Rendimiento Anual <span class="bi bi-question-circle-fill"></span></label>

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

                                <!-- <div class="panel-heading panel-heading-custom-3" style="text-align: center; ">
                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Rendimiento en base a las peticiones completadas." title="Nota">Rendimiento Mensual <span class="bi bi-question-circle-fill"></span></label>
                                </div> -->

                                <div class="panel-heading panel-heading-custom-3" style="text-align: center; ">

                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Rendimiento mensual en base a las peticiones completadas por desarrollador." title="<b>Nota</b>">Rendimiento Mnesual <span class="bi bi-question-circle-fill"></span></label>

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

                                <div class="panel-heading panel-heading-custom-3" style="text-align: center; "><label>Pendientes</label> </div>

                                <div class="contenedor-card dimensiones_2" id="">
                                    <p id="totalDatosPendientes"></p>
                                </div>


                            </div>
                        </div>

                        <div class="col-md-2 separacion">

                            <div class="panel panel-default">

                                <div class="panel-heading panel-heading-custom-3" style="text-align: center; "><label>En Desarrollo</label></div>

                                <div class="contenedor-card dimensiones_2" id="">
                                    <p id="totalDatosDesarrollo"></p>
                                </div>


                            </div>
                        </div>

                        <div class="col-md-2 separacion">

                            <div class="panel panel-default">

                                <div class="panel-heading panel-heading-custom-3" style="text-align: center; "><label>Completadas</label></div>

                                <div class="contenedor-card dimensiones_2" id="">
                                    <p id="totalDatosCompletados"></p>
                                </div>


                            </div>
                        </div>

                        <div class="col-md-2 separacion">

                            <div class="panel panel-default">

                                <div class="panel-heading panel-heading-custom-3" style="text-align: center; "><label>Rechazadas</label></div>

                                <div class="contenedor-card dimensiones_2" id="">
                                    <p id="totalDatosRechazados"></p>
                                </div>


                            </div>
                        </div>



                        <div class="col-md-2 separacion">

                            <div class="panel panel-default">

                                <div class="panel-heading panel-heading-custom-3" style="text-align: center; "><label>Total</label></div>

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

                                <!-- <div class="panel-heading panel-heading-custom-3" style="text-align: center; "><label>Desempe??o por desarrollador</label></div> -->

                                <div class="panel-heading panel-heading-custom-3" style="text-align: center; ">

                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Desempe??o por desarrollador en base al rango de fechas." title="<b>Nota</b>">Desempe??o por desarrollador <span class="bi bi-question-circle-fill"></span></label>

                                </div>

                                <div class="panel-body">

                                    <div class="dimensiones" id="contenedor-grafica-desarrollador-pendiente">

                                        <canvas id="desarrolladorGraficaPendiente"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>


                    <!--=================================================
                    FILTROS POR SELECTMULTIPLE
                    ===================================================-->
                    <div class="row">

                        <div class="col-md-12">

                            <div class="well ">

                                <div class="flex-container">

                                    <div class="">

                                        <select id="multiple-checkboxes_desarrollador" multiple="multiple">

                                            <?php foreach ($data as $desarrollador) : ?>
                                                <option value="<?php echo $desarrollador['ID_DESARROLLADOR']; ?>"><?php echo $desarrollador['NOMBRE']; ?></option>
                                            <?php endforeach; ?>

                                        </select>
                                    </div>

                                    <!-- FILTRO DE FECHA INICIO -->
                                    <div>
                                        <label for=" filtroFechaInicioMultiple">De:</label>
                                        <input type="date" class="form-control" id="filtroFechaInicioMultiple" onchange="">
                                    </div>

                                    <!-- FILTRO DE FECHA FINAL -->
                                    <div>
                                        <label for="filtroFechaFinalMultiple">A:</label>
                                        <input type="date" class="form-control" id="filtroFechaFinalMultiple" onchange="">
                                    </div>

                                    <div>

                                        <button type="button" class="btn btn-warning" onclick="limpiargraficamultipledes()">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>

                                    </div>

                                    <div>

                                        <button class="btn btn-success" onclick="graficarDesarrolladoresSeccion3()"><i class="bi bi-search"></i></button>

                                    </div>


                                </div>

                            </div>

                        </div>

                    </div>

                    <!--=================================================
                    GRAFICA SELECTMULTIPLE
                    ===================================================-->
                    <div class="row">

                        <div class="col-md-6 separacion">

                            <div class="panel panel-default">

                                <!-- <div class="panel-heading panel-heading-custom-3" style="text-align: center; "><label>Comparaci??n Completadas</label></div> -->

                                <div class="panel-heading panel-heading-custom-3" style="text-align: center; ">

                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Compara desarrolladores en base a las peticiones completas por un rango de fechas." title="<b>Nota</b>">Comparaci??n Completadas <span class="bi bi-question-circle-fill"></span></label>

                                </div>

                                <div class="panel-body">

                                    <div class="dimensiones" id="contenedor-grafica-desarrollador-comparacion-completas">

                                        <canvas id="desarrolladoresComparadosCompletas"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6 separacion">

                            <div class="panel panel-default">

                                <!-- <div class="panel-heading panel-heading-custom-3" style="text-align: center; "><label>Comparaci??n Rechazadas</label></div> -->

                                <div class="panel-heading panel-heading-custom-3" style="text-align: center; ">

                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Compara desarrolladores en base a las peticiones rechazadas por un rango de fechas." title="<b>Nota</b>">Comparaci??n Rechazadas <span class="bi bi-question-circle-fill"></span></label>

                                </div>

                                <div class="panel-body">

                                    <div class="dimensiones" id="contenedor-grafica-desarrollador-comparacion-rechazadas">

                                        <canvas id="desarrolladoresComparadosRechazadas"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6 separacion">

                            <div class="panel panel-default">

                                <!-- <div class="panel-heading panel-heading-custom-3" style="text-align: center; "><label>Comparaci??n Pendientes</label></div> -->

                                <div class="panel-heading panel-heading-custom-3" style="text-align: center; ">

                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Compara desarrolladores en base a las peticiones pendientes por un rango de fechas." title="<b>Nota</b>">Comparaci??n Pendientes <span class="bi bi-question-circle-fill"></span></label>

                                </div>

                                <div class="panel-body">

                                    <div class="dimensiones" id="contenedor-grafica-desarrollador-comparacion-pendientes">

                                        <canvas id="desarrolladoresComparadosPendientes"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6 separacion">

                            <div class="panel panel-default">

                                <!-- <div class="panel-heading panel-heading-custom-3" style="text-align: center; "><label>Comparaci??n en desarrollo</label></div> -->

                                <div class="panel-heading panel-heading-custom-3" style="text-align: center; ">

                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Compara desarrolladores en base a las peticiones en desarrollo por un rango de fechas." title="<b>Nota</b>">Comparaci??n en desarrollo <span class="bi bi-question-circle-fill"></span></label>

                                </div>

                                <div class="panel-body">

                                    <div class="dimensiones" id="contenedor-grafica-desarrollador-comparacion-desarrollo">

                                        <canvas id="desarrolladoresComparadosDesarrollo"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-12 separacion">

                            <div class="panel panel-default">

                                <!-- <div class="panel-heading panel-heading-custom-3" style="text-align: center; "><label>Comparaci??n total</label></div> -->

                                <div class="panel-heading panel-heading-custom-3" style="text-align: center; ">

                                    <label class="" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Compara desarrolladores en base a las peticiones totales por un rango de fechas." title="<b>Nota</b>">Comparaci??n total <span class="bi bi-question-circle-fill"></span></label>

                                </div>

                                <div class="panel-body">

                                    <div class="dimensiones" id="contenedor-grafica-desarrollador-comparacion-total">

                                        <canvas id="desarrolladoresComparadostotal"></canvas>

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