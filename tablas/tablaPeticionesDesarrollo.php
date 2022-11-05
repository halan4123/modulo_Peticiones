<div class="panel-group" id="accordionDesarrolloPeticionesData">

    <div class="panel panel-default">

        <div class="panel-heading panel-heading-custom-2">
            <h4 class="panel-title">
                <a onfocus="//displayDataDesarrollo()" data-toggle="collapse" data-parent="#accordionDesarrolloPeticionesData" href="#pendientesDesarrolloAccordionData">
                    Peticiones En Desarrollo</a>
            </h4>
        </div>

        <div id="pendientesDesarrolloAccordionData" class="panel-collapse collapse in">

            <div class="panel-body">

                <!--========================
                ICONOS DE REFERENCIA
                ========================-->
                <div class="row" style="margin-bottom: 10px;">

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
                INFO BOTON
                ========================-->
                <div class="row">
                    <div class="col-md-12">

                        <div class="well ">

                            <div class="flex-container_4">

                                <div>
                                    <label class="btn color-desarrollo-btn-info" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="
                                   
                                    Las peticiones en desarrollo se ordenan desde la peticion en desarrollo mas reciente a la mas antigua. <br>
                         
                                    " title="<b>Orden de las peticiones</b>"><span class="bi bi-question-lg"></span></label>
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
                        <div id="displayDataTableDesarrolloo">

                        </div>

                    </div>

                </div>



            </div>
        </div>

    </div>

</div>