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

                                <div class="panel-heading panel-heading-custom-5" style="text-align: center; ">Peticiones Aceptadas Por Desarrollador</div>

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
                                <div class="panel-heading panel-heading-custom-5" style="text-align: center; ">Peticiones Aceptadas Por Soporte</div>
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

                                            <option selected value="">Selecciona el año</option>
                                            <?php $year = 2099;
                                            for ($i = 2022; $i <= $year; $i++) {
                                                echo '<option value="' . $i . '">' . $i . '</option>';
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
                                <div class="panel-heading panel-heading-custom-5" style="text-align: center;">Peticiones Recibidas - Completadas - Rechazadas</div>
                                <div class="panel-body">
                                    <div class="dimensiones" id="contenedorMix">

                                        <canvas id="peticionesMix"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6 separacion">

                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-custom-5" style="text-align: center;">Peticiones Recibidas</div>
                                <div class="panel-body">
                                    <div class="dimensiones" id="contenedor-anuales">

                                        <canvas id="peticionesAnuales"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6 separacion">

                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-custom-5" style="text-align: center;">Peticiones Completadas</div>
                                <div class="panel-body">
                                    <div class="dimensiones" id="contenedor-completadas-mes">

                                        <canvas id="peticionesCompletadasMes"></canvas>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6 separacion">

                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-custom-5" style="text-align: center;">Peticiones Rechazadas</div>
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
                    FILTROS GRAFICA DE LABORATORIOS
                    ===================================================-->
                    <div class="row">

                        <div class="col-md-12">

                            <div class="well ">

                                <div class=" flex-container">



                                    <div>

                                        <select class="form-control" id="filtroLaboratorioGrafica" style="width: 100%;">

                                            <!-- <option value='0'>Seleccionar</option> -->

                                        </select>
                                    </div>

                                    <!-- FILTRO DE AÑO -->
                                    <div class="form-group">

                                        <select class="form-control" id="filtroAnualGraficaLab">

                                            <option selected value="">Selecciona el año</option>
                                            <?php $year = 2099;
                                            for ($i = 2022; $i <= $year; $i++) {
                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                            }
                                            ?>
                                        </select>

                                    </div>


                                    <!-- FILTRO DE FECHA INICIO -->
                                    <!-- <div>
                                        <label for=" filtroFechaInicioGraficosLab">De:</label>
                                        <input type="date" class="form-control" id="filtroFechaInicioGraficosLab">
                                    </div> -->

                                    <!-- FILTRO DE FECHA FINAL -->
                                    <!-- <div>
                                        <label for="filtroFechaFinalGraficosLab">A:</label>
                                        <input type="date" class="form-control" id="filtroFechaFinalGraficosLab">
                                    </div> -->

                                    <div>

                                        <button class="btn btn-success" onclick="graficarEstadisticasLaboratorios()"><i class="bi bi-search"></i></button>
                                        <!-- <button class="btn btn-success" onclick=""><i class="bi bi-search"></i></button> -->

                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                    <!--=================================================
                    GRAFICA DE LABORATORIOS
                    ===================================================-->
                    <div class="row">

                        <div class="col-md-12 separacion">

                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-custom-3" style="text-align: center;">Peticiones Recibidas - Completadas - Rechazadas</div>
                                <div class="panel-body">
                                    <div class="dimensiones" id="contenedorLabGrafica">

                                        <canvas id="peticionesPorLaboratorio"></canvas>

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
                    FILTROS GRAFICA 1 Y 2
                    ===================================================-->
                    <div class="row">

                        <div class="col-md-12">

                            <div class="well ">

                                <div class=" flex-container">

                                    <div>

                                        <select class="form-control" id="filtroDesarrolladorGrafica" style="width: 100%;">

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
                    AQUI SE COLOCA UNA TABLA POR CADA DESARROLLADOR
                    ===================================================-->
                    <div class="row">

                        <div class="col-md-12 separacion">

                            <div class="panel panel-default">

                                <div class="panel-heading panel-heading-custom-5" style="text-align: center; ">Desempeño Por Desarrollador</div>

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