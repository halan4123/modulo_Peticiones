<?php
include 'app/connectionController.php';

$conn = connect();

include 'valoresPredeterminados.php';

include 'filtros.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modulo de peticiones SLA</title>


    <!--CDN jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!--CDN BOOTSTRAP 3.4.1 Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- CDN BOOTSTRAP 3.4.1 Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- CDN CSS BOOTSTRAP PLUGIN MULTISELECT -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>

    <!-- CDN JS BOOTSTRAP PLUGIN MULTISELECT -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

    <!--CDN DATATABLE-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.css" />

    <!--CDN SELECT2-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!--CDN TEMA BOOTSTRAP 3 SELECT2-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" integrity="sha512-kq3FES+RuuGoBW3a9R2ELYKRywUEQv0wvPTItv3DSGqjpbNtGWVdvT8qwdKkqvPzT93jp8tSF4+oN4IeTEIlQA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!--CDN ICONOS BOOTSTRAP-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <!-- ESTILOS LIBRERIA Trumbowyg -->
    <link rel="stylesheet" href="libs/Trumbowyg/dist/ui/trumbowyg.min.css">

    <!--MY CSS-->
    <link rel="stylesheet" href="css/estructura.css">

    <link rel="stylesheet" href="css/general.css">


</head>

<body>

    <?php include 'modales.php'; ?>


    <nav class="navbar navbar-inverse fondoHeader">
        <div class="container-fluid ">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand not-active" href="#" style="color: white;">Módulo Peticiones</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#" style="color: white;"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                </ul>
            </div>
        </div>
    </nav>



    <div style="background: white;">

        <div class="container-fluid text-center">
            <div class="row content">

                <div class="col-sm-2 sidenav">
                    <ul class="nav nav-pills nav-stacked">

                        <!-- <li class="active"><a onfocus="//displayData()" data-toggle="pill" href="#home">Peticiones</a></li> -->

                        <li class="active"><a onfocus="displayDataPendientes()" data-toggle="pill" href="#peticionesPendientesVista">Peticiones Pendientes <span id="spanPeticionesPendientes" class="badge"></span></a></li>

                        <li><a onfocus="displayDataDesarrollo()" data-toggle="pill" href="#peticionesDesarrolloVista">Peticiones En Desarrollo <span id="spanPeticionesDesarrollo" class="badge"></span></a></li>

                        <li><a onfocus="displayDataCompletas()" data-toggle="pill" href="#peticionesSinEnviarVista">Peticiones Sin Enviar <span id="spanPeticionesSinEnviar" class="badge"></span></a></li>

                        <li><a onfocus="displayData()" data-toggle="pill" href="#peticionesBuscadirVista">Historial De Peticiones</a></li>


                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Admin
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a onfocus="graficarEstadisticasGenerales(); graficarAnualmente();" data-toggle="pill" href="#menuGraficos">Graficas</a></li>
                                <li><a onfocus="displayDataDesarrollador()" data-toggle="pill" href="#menuDesarrollador">Desarrolladores</a></li>
                                <li><a onfocus="displayDataSoporte()" data-toggle="pill" href="#menuSoporte">Soporte</a></li>
                                <li><a onfocus="mostrarModificacionesHistorial()" data-toggle="pill" href="#menuModificaciones">Modificaciones</a></li>
                            </ul>
                        </li>

                    </ul>
                </div>


                <div class="col-sm-10 text-left">

                    <div class="tab-content">

                        <div id="peticionesPendientesVista" class="tab-pane fade in active" style="padding-top: 20px;">

                            <?php include 'tablas/tablaPeticionesPendientes.php'; ?>

                        </div>

                        <div id="peticionesDesarrolloVista" class="tab-pane fade " style="padding-top: 20px;">

                            <?php include 'tablas/tablaPeticionesDesarrollo.php';
                            ?>

                        </div>

                        <div id="peticionesSinEnviarVista" class="tab-pane fade " style="padding-top: 20px;">

                            <?php include 'tablas/tablaPeticionesSinEnviar.php';
                            ?>

                        </div>

                        <div id="peticionesBuscadirVista" class="tab-pane fade " style="padding-top: 20px;">

                            <?php include 'tablas/tablaBuscadorPeticiones.php';
                            ?>

                        </div>


                        <div id="menuGraficos" class="tab-pane fade " style="padding-top: 20px;">

                            <?php include 'tablas/tablaGraficos.php';
                            ?>

                        </div>

                        <div id="menuDesarrollador" class="tab-pane fade" style="padding-top: 20px;">

                            <?php include 'tablas/tablaDesarrolladores.php';
                            ?>

                        </div>

                        <div id="menuSoporte" class="tab-pane fade" style="padding-top: 20px;">

                            <?php include 'tablas/tablaSoportes.php';
                            ?>

                        </div>

                        <div id="menuModificaciones" class="tab-pane fade" style="padding-top: 20px;">

                            <?php include 'tablas/tablaModificaciones.php';
                            ?>

                        </div>



                    </div>



                </div>

            </div>
        </div>

    </div>






    <!--CDN DATATABLE-->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>

    <!-- CDN BOTONES DATATABLE EXCEL, COPY, PDF  -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.53/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.53/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- CDN SELECT2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Importar chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

    <!-- Muestra Numeros Graficas -->
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>

    <!-- CDN MOMENT -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js" integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- LIBRERIA Trumbowyg -->
    <script src="libs/Trumbowyg/dist/trumbowyg.min.js"></script>

    <!-- LIBRERIA PLUGIN EMOJI -->
    <script src="libs/Trumbowyg/dist/plugins/emoji/trumbowyg.emoji.min.js"></script>

    <!-- LIBRERIA PLUGIN UPLOAD -->
    <script src="libs/Trumbowyg/dist/plugins/upload/trumbowyg.upload.min.js"></script>


    <!-- MY JS -->
    <script src="js/AjaxPeticion.js"></script>

    <script src="js/AjaxDesarrollador.js"></script>

    <script src="js/AjaxSoporte.js"></script>

    <script src="js/AjaxGraficas.js"></script>

</body>

</html>