<div>
    <div class="panel-group" id="acordion_graficas">

        <!--=====================================================================================================================
        ESTADISTICAS GENERALES 
        ======================================================================================================================-->

        <div class="panel panel-success">
            <div class="panel-heading ">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#acordion_graficas" href="#estadisticasGenerales">Estadisticas Generales</a>
                </h4>
            </div>
            <div id="estadisticasGenerales" class="panel-collapse collapse in">
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-12">

                            <div class="well ">

                                <div class=" flex-container">


                                    <button class="btn btn-success" onclick="pruebaGrafic()">Prueba</button>


                                </div>
                            </div>

                        </div>

                    </div>


                    <div class="row">

                        <div class="col-md-6">

                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-custom-5">Peticiones Aceptadas Por Desarrollador.</div>
                                <div class="panel-body">
                                    <div class="co">
                                        <canvas id="peticionesAceptadasDesarrolladores"></canvas>
                                    </div>
                                </div>

                            </div>


                        </div>

                        <div class="col-md-6">

                            <div class="panel panel-default">
                                <div class="panel-heading panel-heading-custom-5">Peticiones Registradas Por Soporte</div>
                                <div class="panel-body">
                                    <div class="co">
                                        <canvas id="graficas"></canvas>
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
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#acordion_graficas" href="#estadisticasLaboratorio">Estadisticas Laboratorios</a>
                </h4>
            </div>
            <div id="estadisticasLaboratorio" class="panel-collapse collapse">
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-12">

                            <div class="well ">

                                <div class=" flex-container">


                                    <!-- FILTRO DE FECHA INICIO -->
                                    <div>
                                        <label for=" filterFechaInicio">De:</label>
                                        <input type="date" class="form-control" id="filtroFechaInicioGraficos">
                                    </div>

                                    <!-- FILTRO DE FECHA FINAL -->
                                    <div>
                                        <label for="filterFechaFinal">A:</label>
                                        <input type="date" class="form-control" id="filtroFechaFinalGraficos">
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