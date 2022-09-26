<?php
include 'app/connectionController.php';

$conn = connect();

//CONSULTA PARA OBTENER EL ID DEL NIVEL REQUERIDO QUE SEA EL POR DEFECTO
$query = "SELECT ID_NIVEL FROM nivel WHERE NIVEL = 'Sin Definir'";

$result = $conn->query($query);  // or mysqli_query($con, $tourquery);

$ID_NIVEL = $result->fetch_array()[0] ?? ''; //OR $tourresult = $result->fetch_array()['roomprice'] ?? '';

//CONSULTA PARA OBTENER EL ID DEL DESARROLLADOR REQUERIDO QUE SEA EL POR DEFECTO
$query = "SELECT ID_DESARROLLADOR FROM desarrollador WHERE NOMBRE = 'Sin Definir'";

$result = $conn->query($query);

$ID_DESARROLLADOR = $result->fetch_array()[0] ?? '';

//CONSULTA PARA OBTENER EL ID DEL ESTATUS REQUERIDO QUE SEA EL POR DEFECTO
$query = "SELECT ID_ESTATUS FROM estatus WHERE ESTATUS = 'pendiente'";

$result = $conn->query($query);

$ID_ESTATUS = $result->fetch_array()[0] ?? '';

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

</head>

<body>

    <!--========================
    MODAL AGREGAR PETICION
    ========================-->
    <div id="modalAgregar" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal-color">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Agregar</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="asuntoAdd">Asunto:</label>
                        <input type="text" class="form-control" id="asuntoAdd" placeholder="Asunto">
                    </div>


                    <div class="form-group">
                        <label for="laboratorioAdd">Laboratorio:</label>
                        <select class="form-control" id="laboratorioAdd" style="width: 100%;">

                            <!-- <option value='0'>Seleccionar</option> -->

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="soporteAdd">Soporte:</label>
                        <select class="form-control" id="soporteAdd" style="width: 100%;">

                            <!-- <option value='0'>Seleccionar</option> -->

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="descripcionAdd">Descripción:</label>
                        <textarea class="form-control" rows="15" id="descripcionAdd" placeholder="Descripción"></textarea>
                    </div>

                    <input type="hidden" id="fechaEntregaEstimadaAdd" value="0000-00-00 00:00:00">

                    <input type="hidden" id="fechaCompletadoAdd" value="0000-00-00 00:00:00">

                    <input type="hidden" id="desarrolladorAdd" value="<?php echo $ID_DESARROLLADOR ?>">

                    <input type="hidden" id="nivelAdd" value="<?php echo $ID_NIVEL ?>">

                    <input type="hidden" id="estatusAdd" value="<?php echo $ID_ESTATUS ?>">


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="agregar()">Agregar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>

        </div>
    </div>

    <!--========================
    MODAL INFORMACIÓN PETICION
    ========================-->
    <div id="modalVer" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal-color">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Consultar</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="idSee">id</label>
                        <input type="text" class="form-control" id="idSee" disabled>
                    </div>

                    <div class="form-group">
                        <label for="asuntoSee">Asunto:</label>
                        <input type="text" class="form-control" id="asuntoSee" disabled>
                    </div>

                    <div class="form-group">
                        <label for="laboratorioSee">Laboratorio:</label>
                        <input type="text" class="form-control" id="laboratorioSee" disabled>
                    </div>

                    <div class="form-group">
                        <label for="fecha_llegadaSee">Fecha de solicitud:</label>
                        <input type="text" class="form-control" id="fecha_llegadaSee" disabled>
                    </div>

                    <div class="form-group">
                        <label for="fecha_entregaSee">Fecha de entrega:</label>
                        <input type="text" class="form-control" id="fecha_entregaSee" disabled>
                    </div>

                    <div class="form-group">
                        <label for="fecha_completadoSee">Fecha de completado:</label>
                        <input type="text" class="form-control" id="fecha_completadoSee" disabled>
                    </div>

                    <div class="form-group">
                        <label for="soporteSee">Soporte:</label>
                        <input type="text" class="form-control" id="soporteSee" disabled>
                    </div>

                    <div class="form-group">
                        <label for="desarrolladorSee">Desarrollador:</label>
                        <input type="text" class="form-control" id="desarrolladorSee" disabled>
                    </div>

                    <div class="form-group">
                        <label for="nivelSee">Nivel:</label>
                        <input type="text" class="form-control" id="nivelSee" disabled>
                    </div>

                    <div class="form-group">
                        <label for="estatusSee">Estatus:</label>
                        <input type="text" class="form-control" id="estatusSee" disabled>
                    </div>

                    <div class="form-group">
                        <label for="descripcionSee">Descripción:</label>
                        <textarea class="form-control" rows="5" id="descripcionSee" disabled></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

                </div>
            </div>

        </div>
    </div>

    <!--========================
    MODAL EDITAR PETICION
    ========================-->
    <div id="modalEditar" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal-color">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="asuntoUpdate">Asunto:</label>
                        <input type="text" class="form-control" id="asuntoUpdate">
                    </div>

                    <div class="form-group">
                        <label for="laboratorioUpdate">Laboratorio:</label>
                        <select class="form-control" id="laboratorioUpdate" style="width: 100%;">

                            <!-- <option value='0'>Seleccionar</option> -->

                        </select>
                    </div>

                    <!-- <div class="form-group">
                        <label for="fecha_llegadaUpdate">Fecha de solicitud:</label>
                        <input type="text" class="form-control" id="fecha_llegadaUpdate" disabled>
                    </div> -->

                    <div class="form-group">
                        <label for="fecha_entregaUpdate">Fecha de entrega:</label>
                        <input type="datetime-local" class="form-control" id="fecha_entregaUpdate">
                    </div>

                    <!-- <div class="form-group">
                        <label for="fecha_completadoUpdate">Fecha de completado:</label>
                        <input type="text" class="form-control" id="fecha_completadoUpdate" disabled>
                    </div>

                    <div class="form-group">
                        <label for="soporteUpdate">Soporte:</label>
                        <input type="text" class="form-control" id="soporteUpdate" disabled>
                    </div> -->

                    <div class="form-group">
                        <label for="desarrolladorUpdate">Desarrollador:</label>
                        <select class="form-control" id="desarrolladorUpdate" style="width: 100%;">

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nivelUpdate">Nivel:</label>
                        <select class="form-control" id="nivelUpdate" style="width: 100%;">

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="estatusUpdate">Estatus:</label>
                        <select class="form-control" id="estatusUpdate" style="width: 100%;">

                        </select>
                    </div>

                    <!-- <div class="form-group">
                        <label for="estatusUpdate">Estatus:</label>
                        <input type="text" class="form-control" id="estatusUpdate">
                    </div> -->

                    <div class="form-group">
                        <label for="descripcionUpdate">Descripción:</label>
                        <textarea class="form-control" rows="15" id="descripcionUpdate"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="actualizar()">Actualizar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <input type="hidden" id="idHidden">
                </div>
            </div>

        </div>
    </div>

    <!--========================
    MODAL AGREGAR DESARROLLADOR
    ========================-->
    <div id="modalAgregarDesarrollador" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal-color">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Agregar Desarrollador</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="nombreDesarrolladorAdd">Nombre(s):</label>
                        <input type="text" class="form-control" id="nombreDesarrolladorAdd" placeholder="Nombre(s)">
                    </div>

                    <div class="form-group">
                        <label for="apellidoDesarrolladorAdd">Apellido(s):</label>
                        <input type="text" class="form-control" id="apellidoDesarrolladorAdd" placeholder="Nombre(s)">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="agregarDesarrollador()">Agregar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>

        </div>
    </div>

    <!--========================
    MODAL INFO DESARROLLADOR
    ========================-->
    <div id="modalInfoDesarrollador" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal-color">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Consultar Desarrollador</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="idDesarrolladorSee">id:</label>
                        <input type="text" class="form-control" id="idDesarrolladorSee" disabled>
                    </div>

                    <div class="form-group">
                        <label for="nombreDesarrolladorSee">Nombre(s):</label>
                        <input type="text" class="form-control" id="nombreDesarrolladorSee" disabled>
                    </div>

                    <div class="form-group">
                        <label for="apellidoDesarrolladorSee">Apellido(s):</label>
                        <input type="text" class="form-control" id="apellidoDesarrolladorSee" disabled>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="agregarDesarrollador()">Agregar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>

        </div>
    </div>

    <div class="container">

        <div class="container">
            <h2>Módulo Peticiones</h2>

            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Peticiones</a></li>
                <li><a data-toggle="tab" href="#menu1">Desarrolladores</a></li>
                <li><a data-toggle="tab" href="#menu2">Soporte</a></li>
                <li><a data-toggle="tab" href="#menu3">Laboratorio</a></li>
            </ul>

            <div class="tab-content">

                <div id="home" class="tab-pane fade in active">
                    <!-- <h3>Peticiones</h3> -->

                    <div>
                        <!--========================
                        TITULO
                        ========================-->
                        <!-- <div class="row">

                            <div class="col-md-12 ">
                                <h3 style="font-weight: bold;">Peticiones Recibidas</h3>
                            </div>

                        </div> -->

                        <!--========================
                        BOTÓN AGREGAR PETICIÓN
                        ========================-->
                        <div class="row">

                            <div class="col-md-12">

                                <div>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAgregar" style="margin-bottom: 5px; margin-top: 5px;">
                                        Agregar
                                    </button>
                                </div>

                            </div>

                        </div>

                        <!--========================
                        ICONOS DE REFERENCIA
                        ========================-->
                        <div class="row">

                            <div class="col-md-12">

                                <label class="referencia">
                                    <i style="color: green;" class="fa fa-check-circle" aria-hidden="true"></i>Completado
                                </label>

                                <label class="referencia">
                                    <i style="color: #2995B8;" class="fa fa-desktop" aria-hidden="true"></i>Desarrollo
                                </label>

                                <label class="referencia">
                                    <i style="color: orange;" class="fa fa-exclamation-triangle" aria-hidden="true"></i>Pendiente
                                </label>

                                <label class="referencia">
                                    <i style="color: red;" class="fa fa-times-circle" aria-hidden="true"></i>Rechazado
                                </label>

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

                <div id="menu1" class="tab-pane fade">
                    <!-- <h3>Desarrolladores</h3> -->

                    <div>

                        <!--========================
                        BOTÓN AGREGAR DESARROLLADOR
                        ========================-->
                        <div class="row">

                            <div class="col-md-12">

                                <div>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAgregarDesarrollador" style="margin-bottom: 5px; margin-top: 5px;">
                                        Agregar
                                    </button>
                                </div>

                            </div>

                        </div>

                        <!--========================
                        TABLA DESARROLLADORES
                        ========================-->
                        <div class="row">

                            <div class="col-md-12">

                                <!-- AQUI SE GENERA LA TABLA -->
                                <div id="displayDataTableDesarrollador">

                                </div>

                            </div>
                        </div>

                    </div>

                </div>

                <div id="menu2" class="tab-pane fade">
                    <h3>Menu 2</h3>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                </div>

                <div id="menu3" class="tab-pane fade">
                    <h3>Menu 3</h3>
                    <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                </div>

            </div>
        </div>





    </div>


    <!--CDN jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- CDN BOOTSTRAP 3.4.1 Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- Font Awesome CDN -->
    <script src="https://use.fontawesome.com/2dc70da5bb.js"></script>

    <!--CDN DATATABLE-->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>

    <!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- CDN SELECT2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- MY JS -->
    <script src="js/AjaxPeticion.js"></script>

    <script src="js/AjaxDesarrollador.js"></script>



</body>

</html>