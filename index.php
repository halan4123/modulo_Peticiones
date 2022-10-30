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
    <title>Modulo de peticiones</title>


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
    <link rel="stylesheet" href="css/general.css">


</head>

<body>

    <?php include 'modales.php'; ?>

    <div class="container-fluid">

        <div class="container-fluid">

            <h2>Módulo Peticiones</h2>

            <button class="btn btn-default" onclick="colr() ">Colores</button>

            <ul class="nav nav-tabs">
                <li class="active"><a onfocus="displayData()" data-toggle="tab" href="#home">Peticiones</a></li>
                <li><a onfocus="graficarEstadisticasGenerales(); graficarAnualmente(); " data-toggle="tab" href="#menu3">Graficos</a></li>
                <li><a onfocus="displayDataDesarrollador()" data-toggle="tab" href="#menu1">Desarrolladores</a></li>
                <li><a onfocus="displayDataSoporte()" data-toggle="tab" href="#menu2">Soporte</a></li>

            </ul>

            <div class="tab-content">

                <div id="home" class="tab-pane fade in active">

                    <?php include 'tablas/tablaPeticiones.php'; ?>

                </div>

                <div id="menu3" class="tab-pane fade ">

                    <?php include 'tablas/tablaGraficos.php'; ?>

                </div>

                <div id="menu1" class="tab-pane fade">

                    <?php include 'tablas/tablaDesarrolladores.php'; ?>

                </div>

                <div id="menu2" class="tab-pane fade">

                    <?php include 'tablas/tablaSoportes.php'; ?>

                </div>


            </div>
        </div>



    </div>


    <!--CDN DATATABLE-->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>

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