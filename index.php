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

    <!--CDN BOOTSTRAP 3.4.1 Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!--MY CSS-->
    <link rel="stylesheet" href="css/general.css">

    <!--CDN DATATABLE-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.css" />

    <!--CDN SELECT2-->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>

<body>

    <?php include 'modales.php'; ?>

    <div class="container-fluid">

        <div class="container-fluid">

            <h2>Módulo Peticiones</h2>

            <ul class="nav nav-tabs">
                <li class="active"><a onfocus="displayData()" data-toggle="tab" href="#home">Peticiones</a></li>
                <li><a onfocus="displayDataDesarrollador()" data-toggle="tab" href="#menu1">Desarrolladores</a></li>
                <li><a onfocus="displayDataSoporte()" data-toggle="tab" href="#menu2">Soporte</a></li>
                <li><a data-toggle="tab" href="#menu3">Graficos</a></li>
            </ul>

            <div class="tab-content">

                <div id="home" class="tab-pane fade in active">

                    <?php include 'tablas/tablaPeticiones.php'; ?>

                </div>

                <div id="menu1" class="tab-pane fade">

                    <?php include 'tablas/tablaDesarrolladores.php'; ?>

                </div>

                <div id="menu2" class="tab-pane fade">

                    <?php include 'tablas/tablaSoportes.php'; ?>

                </div>

                <div id="menu3" class="tab-pane fade">

                    <?php include 'tablas/tablaGraficos.php'; ?>

                </div>



            </div>
        </div>



    </div>


    <!--CDN jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- CDN BOOTSTRAP 3.4.1 Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- Font Awesome CDN -->
    <!-- <script src="https://use.fontawesome.com/2dc70da5bb.js"></script> -->

    <!--CDN DATATABLE-->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>

    <!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- CDN SELECT2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <!-- Importar highcharts.js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>


    <!-- MY JS -->
    <script src="js/AjaxPeticion.js"></script>

    <script src="js/AjaxDesarrollador.js"></script>

    <script src="js/AjaxSoporte.js"></script>

    <script src="js/AjaxGraficas.js"></script>

</body>

</html>