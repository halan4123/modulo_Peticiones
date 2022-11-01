<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';



include 'connectionController.php';

$conn = connect();

$display = 0;

//==========================================================================================================================
//MUESTRA DE LA TABLA Y VALIDACIONES DE LA MISMA
//==========================================================================================================================
if (isset($_POST['displayDataSend'])) {

    date_default_timezone_set('America/Chihuahua'); //ESTABLECEMOS ZONA HORARIA

    //SE ESCOJE LA TABLA DEPENDIENDO EL ESTADO DE ENVIO
    if (isset($_POST['displayDataFullSend'])) {

        $table = '
        <table id="tabla_peticiones" class="display table table-responsive">
            <thead>
                <tr>
                    <th class="color-buscador-tabla">#</th>
                    <th class="color-buscador-tabla">ESTATUS</th>
                    <th class="color-buscador-tabla">NIVEL</th>
                    <th class="color-buscador-tabla">ASUNTO</th>
                    <th class="color-buscador-tabla">LABORATORIO</th>
                    <th class="color-buscador-tabla">PAQUETE</th>
                    <th class="color-buscador-tabla">FECHA DE SOLICITUD</th>
                    <th class="color-buscador-tabla">ENTREGA ESTIMADA</th>
                    <th class="color-buscador-tabla">FECHA DE COMPLETADO</th>
                    <th class="color-buscador-tabla">TIEMPO RESTANTE</th>
                    <th class="color-buscador-tabla">SOPORTE</th>
                    <th class="color-buscador-tabla">DESARROLLADOR</th>
                    <th class="color-buscador-tabla">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
            ';

        $display = 1;
    } elseif (isset($_POST['displayDataPendienteSend'])) {

        $table = '
        <table id="tabla_peticiones_pendientes" class="display table table-responsive">
            <thead>
                <tr >
                    <th class="color-pendiente-tabla">#</th>
                    <th class="color-pendiente-tabla">ESTATUS</th>
                    <th class="color-pendiente-tabla">NIVEL</th>
                    <th class="color-pendiente-tabla">ASUNTO</th>
                    <th class="color-pendiente-tabla">LABORATORIO</th>
                    <th class="color-pendiente-tabla">PAQUETE</th>
                    <th class="color-pendiente-tabla">FECHA DE SOLICITUD</th>
                    <th class="color-pendiente-tabla">ENTREGA ESTIMADA</th>
                    <th class="color-pendiente-tabla">FECHA DE COMPLETADO</th>
                    <th class="color-pendiente-tabla">TIEMPO RESTANTE</th>
                    <th class="color-pendiente-tabla">SOPORTE</th>
                    <th class="color-pendiente-tabla">DESARROLLADOR</th>
                    <th class="color-pendiente-tabla">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
            ';
        $display = 2;
    } elseif (isset($_POST['displayDataDesarrolloSend'])) {

        $table = '
        <table id="tabla_peticiones_desarrollo" class="display table table-responsive">
            <thead>
                <tr>
                    <th class="color-desarrollo-tabla">#</th>
                    <th class="color-desarrollo-tabla">ESTATUS</th>
                    <th class="color-desarrollo-tabla">NIVEL</th>
                    <th class="color-desarrollo-tabla">ASUNTO</th>
                    <th class="color-desarrollo-tabla">LABORATORIO</th>
                    <th class="color-desarrollo-tabla">PAQUETE</th>
                    <th class="color-desarrollo-tabla">FECHA DE SOLICITUD</th>
                    <th class="color-desarrollo-tabla">ENTREGA ESTIMADA</th>
                    <th class="color-desarrollo-tabla">FECHA DE COMPLETADO</th>
                    <th class="color-desarrollo-tabla">TIEMPO RESTANTE</th>
                    <th class="color-desarrollo-tabla">SOPORTE</th>
                    <th class="color-desarrollo-tabla">DESARROLLADOR</th>
                    <th class="color-desarrollo-tabla">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
            ';
        $display = 3;
    } elseif (isset($_POST['displayDataCompletaSend'])) {

        $table = '
        <table id="tabla_peticiones_coompletadas" class="display table table-responsive">
            <thead>
                <tr>
                    <th class="color-enviar-tabla">#</th>
                    <th class="color-enviar-tabla">ESTATUS</th>
                    <th class="color-enviar-tabla">NIVEL</th>
                    <th class="color-enviar-tabla">ASUNTO</th>
                    <th class="color-enviar-tabla">LABORATORIO</th>
                    <th class="color-enviar-tabla">PAQUETE</th>
                    <th class="color-enviar-tabla">FECHA DE SOLICITUD</th>
                    <th class="color-enviar-tabla">ENTREGA ESTIMADA</th>
                    <th class="color-enviar-tabla">FECHA DE COMPLETADO</th>
                    <th class="color-enviar-tabla">TIEMPO RESTANTE</th>
                    <th class="color-enviar-tabla">SOPORTE</th>
                    <th class="color-enviar-tabla">DESARROLLADOR</th>
                    <th class="color-enviar-tabla">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
            ';
        $display = 4;
    }

    //CONSULTA SQL
    $sql = "SELECT p.*,
    l.nombre AS NOMLAB,
    l.paquete AS PAQUETE,
    l.ID_LABORATORIO AS L_ID,
    n.ID_NIVEL AS N_ID, 
    n.nivel AS NOMNIVEL,
    n.icono AS NIVEL_ICONO,
    n.color_icono AS NIVEL_COLOR,
    e.ID_ESTATUS AS E_ID,
    e.estatus AS NOMESTATUS,
    e.icono AS ESTATUS_ICONO,
    e.color_icono AS ESTATUS_COLOR, 
    d.nombre AS NOMDES,
    s.nombre AS NOMSOP,
    s.NUM_CELULAR AS NUMERO_SOPORTE 
    FROM peticion AS p 
    INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO
    INNER JOIN nivel AS n ON p.ID_NIVEL = n.ID_NIVEL
    INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS
    LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR
    INNER JOIN soporte AS s ON p.ID_SOPORTE = s.ID_SOPORTE WHERE 1";


    //FILTROS & CONCATENACION A CONSULTA SQL
    if (isset($_POST['displayDataFullSend'])) {

        if (isset($_POST['filtroLaboratorioSend']) || isset($_POST['filtroDesarrolladorSend']) || isset($_POST['filtroSoporteSend']) || isset($_POST['filtroNivelSend']) || isset($_POST['filtroEstatusSend']) || isset($_POST['filtroFechaInicioSend']) || isset($_POST['filtroFechaFinalSend'])) {

            //FILTRO LABORATORIO
            if (isset($_POST['filtroLaboratorioSend'])) {

                $LAB = $_POST['filtroLaboratorioSend'];

                if ($LAB !== "") {

                    $sql .= " and l.ID_LABORATORIO = '$LAB'";
                }
            }

            //FILTRO DESARROLLADOR
            if (isset($_POST['filtroDesarrolladorSend'])) {

                $DESA = $_POST['filtroDesarrolladorSend'];

                if ($DESA !== "") {

                    $sql .= " and d.ID_DESARROLLADOR = '$DESA'";
                }
            }

            //FILTRO NIVEL
            if (isset($_POST['filtroNivelSend'])) {

                $nivel = $_POST['filtroNivelSend'];

                if ($nivel !== "") {

                    $sql .= " and n.ID_NIVEL = '$nivel'";
                }
            }

            //FILTRO LABORATORIO
            if (isset($_POST['filtroEstatusSend'])) {

                $statusRe = $_POST['filtroEstatusSend'];

                if ($statusRe !== "") {

                    $sql .= " and e.ID_ESTATUS = '$statusRe'";
                }
            }

            //FILTRO SOPORTE
            if (isset($_POST['filtroSoporteSend'])) {

                $soporte = $_POST['filtroSoporteSend'];

                if ($soporte !== "") {

                    $sql .= " and s.ID_SOPORTE = '$soporte'";
                }
            }

            //FILTRO FECHA DE INICIO Y FECHA FINAL
            if (isset($_POST['filtroFechaInicioSend']) && isset($_POST['filtroFechaFinalSend'])) {

                $fechaInicio = $_POST['filtroFechaInicioSend'];
                $fechaFinal = $_POST['filtroFechaFinalSend'];
                // $newDate_1 = date("Y-m-d", strtotime($fechaInicio));
                // $newDate_2 = date("Y-m-d", strtotime($fechaFinal));
                //$newDate_2 = date("Y-m-d", strtotime($fechaFinal . "+ 1 days"));

                if ($fechaInicio == $fechaFinal) {

                    //echo 'Son iguales';
                    $sql .= " and FECHA_LLEGADA LIKE '$fechaInicio%'";
                } else {

                    if ($fechaInicio !== '' && $fechaFinal !== '') {

                        //echo $fechaInicio . ' ' .  $fechaFinal;

                        $sql .= " and FECHA_LLEGADA BETWEEN '$fechaInicio 00:00:00.000' and '$fechaFinal 23:59:59.999'";
                    }
                }
            }
        }
    } elseif (isset($_POST['displayDataPendienteSend'])) {


        $sql .= " and e.ESTATUS = 'Pendiente' and ENVIADO = 0 and ELIMINADO = 0";
    } elseif (isset($_POST['displayDataDesarrolloSend'])) {


        $sql .= " and e.ESTATUS = 'En Desarrollo' and ENVIADO = 0 and ELIMINADO = 0";
    } elseif (isset($_POST['displayDataCompletaSend'])) {

        //WHERE 1 and ENVIADO = 0 AND ( e.ESTATUS = 'Completado' OR e.ESTATUS = 'Rechazado')
        //and e.ESTATUS = 'Completado' and ENVIADO = 0
        $sql .= " and ENVIADO = 0 AND ( e.ESTATUS = 'Completado' OR e.ESTATUS = 'Rechazado')";
    }

    //ORDENAMIENTO QUE SEGUIRAN TODAS LAS TABLAS
    $sql .= " ORDER BY e.ESTATUS = 'Pendiente' DESC,
    p.FECHA_LLEGADA DESC,
    e.ESTATUS = 'En Desarrollo' DESC,
    e.ESTATUS = 'Completado' DESC,
    e.ESTATUS = 'Rechazado' DESC";

    $stmt = $conn->prepare($sql);

    $stmt->execute();

    $result = $stmt->get_result();

    //SE ESTABLECE UN CONTADOR PARA COLOCARLO EN LA COLUMNA #
    $CONT = 1;

    //POR CADA CICLO OBTENEMOS LOS DATOS DE LA BD Y LOS GUARDAMOS EN VARIABLES 
    while ($row = mysqli_fetch_assoc($result)) {

        $ID_PETICION = $row['ID_PETICION'];
        $ASUNTO = $row['ASUNTO'];
        $ID_LABORATORIO = $row['NOMLAB'];
        $PAQUETE = $row['PAQUETE'];
        $FECHA_LLEGADA = $row['FECHA_LLEGADA'];
        $FECHA_ENTREGA_ESTIMADA = $row['FECHA_ENTREGA_ESTIMADA'];
        $FECHA_COMPLETADO = $row['FECHA_COMPLETADO'];
        $ENVIADODB = $row['ENVIADO'];
        $ELIMINADODB = $row['ELIMINADO'];
        $ID_DESARROLLADOR = $row['NOMDES'];
        $ID_SOPORTE = $row['NOMSOP'];
        $NUMERO_SOPORTE = $row['NUMERO_SOPORTE'];

        $ID_NIVEL = $row['NOMNIVEL'];
        $NIVEL_ICONO = $row['NIVEL_ICONO'];
        $NIVEL_COLOR = $row['NIVEL_COLOR'];

        $ID_ESTATUS = $row['NOMESTATUS'];
        $ESTATUS_ICONO = $row['ESTATUS_ICONO'];
        $ESTATUS_COLOR = $row['ESTATUS_COLOR'];
        $ID_ESTATUS_COPY = $ID_ESTATUS;

        $FECHA_ENTREGA_ESTIMADA_COPY = $FECHA_ENTREGA_ESTIMADA;
        $FECHA_COMPLETADO_COPY = $FECHA_COMPLETADO;

        //CORTAMOS FECHAS PARA MOSTRAR SOLO LA FECHA Y NO LA HORA
        $FECHA_LLEGADA = substr($FECHA_LLEGADA, 0, -9);
        $FECHA_ENTREGA_ESTIMADA = substr($FECHA_ENTREGA_ESTIMADA, 0, -9);
        $FECHA_COMPLETADO = substr($FECHA_COMPLETADO, 0, -9);

        $FECHA_LLEGADA = date("d-m-Y", strtotime($FECHA_LLEGADA));
        $FECHA_ENTREGA_ESTIMADA = date("d-m-Y", strtotime($FECHA_ENTREGA_ESTIMADA));

        //ESTABLECEMOS ZONA HORARIA
        date_default_timezone_set('America/Chihuahua');

        //ASIGNACION DE LABEL -> INCOMPLETA
        if ($FECHA_COMPLETADO_COPY == '0000-00-00 00:00:00') {
            $FECHA_COMPLETADO = '<span class="label label-danger">Incompleta</span>';
        }

        //ASIGNACION DE LABEL -> SIN DEFINIR / TIEMPO RESTANTE -> +3 DIAS
        if ($FECHA_ENTREGA_ESTIMADA_COPY == '0000-00-00 00:00:00') {
            $tiempo = '<span class="label label-warning">Sin Definir</span>';
        } else {
            //SE OBTIENE, CREA LA FECHA ACTUAL
            $fechaActual = date('y-m-d');
            //CONVERTIMOS A DATECREATE PARA PODER USAR DATE DIFF
            $datetime1 = date_create($fechaActual);
            //CONVERTIMOS A DATECREATE PARA PODER USAR DATE DIFF
            $datetime2 = date_create($FECHA_ENTREGA_ESTIMADA);
            //OBTENEMOS LA DIFERENCIA
            $interval = date_diff($datetime1, $datetime2);
            //ASIGNAMOS EL FORMATO
            $tiempo = $interval->format('%R%a días');
        }

        //ASIGNACION DE LABEL -> SIN DEFINIR
        if ($FECHA_ENTREGA_ESTIMADA == '30-11--0001') {
            $FECHA_ENTREGA_ESTIMADA = '<span class="label label-warning">Sin Definir</span>';
        }

        //==========================================================================================================================
        //EL TIEMPO RESTANTE CAMBIA A COMPLETEADO, DEJA DE APARECER SIN DEFINIR O +5 -8 DIAS POR -> LABEL -> COMPLETADO
        //==========================================================================================================================
        if ($ID_ESTATUS == 'Completado') {
            $tiempo = '<span class="label label-success">Completado</span>
            ';
        }

        //==========================================================================================================================
        //EL DESAROLLADOR PUEDE SER NULL POR EL LEFT JOIN/LABEL -> SIN DEFINIR
        //==========================================================================================================================
        if ($ID_DESARROLLADOR == NULL) {
            $ID_DESARROLLADOR = 'Sin Definir';
        }

        //==========================================================================================================================
        //DEPENDIENDO EL STATUS Y DEL NIVEL DE LA DB SE LE ASIGANARA UN ICONO Y UN COLOR
        //==========================================================================================================================
        $ID_ESTATUS = '<span style="color:' . $ESTATUS_COLOR . ';" class="tam ' . $ESTATUS_ICONO . '" aria-hidden="true"></span>
         <label hidden>' . $ID_ESTATUS . '</label>';

        $ID_NIVEL = '<span style="color:' . $NIVEL_COLOR . ';" class="tam ' . $NIVEL_ICONO . '" aria-hidden="true"></span>
         <label hidden>' . $ID_ESTATUS . '</label>';


        //==========================================================================================================================
        //COLOR DE LA FILA SI ESTA ELIMINADA LA PETICIÓN
        //==========================================================================================================================
        if ($ELIMINADODB == 1) {
            $table .= '<tr style=" background-color: rgba(255, 23, 0, 0.2); ">';
        } else {
            $table .= '<tr>';
        }

        //==========================================================================================================================
        //CONTATENAMOS LAS FILAS OBTENIDAD POR VUELTA CON LA INFORMACIÓN DE LA BD
        //==========================================================================================================================
        $table .= '

                <td>' . $CONT . '</td>
                <td>' . $ID_ESTATUS . '</td>
                <td>' . $ID_NIVEL . '</td>
                <td>' . $ASUNTO . '</td>
                <td>' . $ID_LABORATORIO . '</td>
                <td>' . $PAQUETE . '</td>
                <td>' . $FECHA_LLEGADA . '</td>
                <td>' . $FECHA_ENTREGA_ESTIMADA . '</td>
                <td>' . $FECHA_COMPLETADO . '</td>
                <td>' . $tiempo . '</td>
                <td>' . $ID_SOPORTE . '</td>';

        if ($ID_DESARROLLADOR == 'Sin Definir') {
            $table .= '<td> <span class="label label-warning">' . $ID_DESARROLLADOR . '</span></td>
           <td>
           <div class="re">';
        } else {
            $table .= '
            <td>' . $ID_DESARROLLADOR . '</td>
                            <td>
                            <div class="re">';
        }




        //==========================================================================================================================
        //BOTON DE WHATSAPP
        //==========================================================================================================================
        if ($ELIMINADODB == 0) {

            if (($ID_ESTATUS_COPY == 'Completado' && $ENVIADODB == 1) || ($ID_ESTATUS_COPY == 'Completado' && $ENVIADODB == 0)) {
                $table .= '<button onclick="wp(' . $ID_PETICION  . ",'"  . $ASUNTO . "'" . "," . $NUMERO_SOPORTE . ",'"  . $ID_LABORATORIO . "'" . ",'"  . $ID_DESARROLLADOR . "'" . ",'"  . $FECHA_LLEGADA . "'" . ",'"  . $ID_SOPORTE . "'"  . ')" class="btn btn-success accionesPeticion" >
                <span class="bi bi-whatsapp"></span>
                </button>';
            } elseif ($ID_ESTATUS_COPY == 'Rechazado' && $ENVIADODB == 1 || ($ID_ESTATUS_COPY == 'Rechazado' && $ENVIADODB == 0)) {
                $table .= '<button onclick="wpRechazado(' . $ID_PETICION  . ",'"  . $ASUNTO . "'" . "," . $NUMERO_SOPORTE . ",'"  . $ID_LABORATORIO . "'" . ",'"  . $ID_DESARROLLADOR . "'" . ",'"  . $FECHA_LLEGADA . "'" . ",'"  . $ID_SOPORTE . "'"  . ')" class="btn btn-success accionesPeticion" >
                <span class="bi bi-whatsapp"></span>
                </button>';
            }
        }



        //==========================================================================================================================
        //BOTONES DE VER, ACTUALIZAR Y ELIMINAR
        //==========================================================================================================================
        if ($ELIMINADODB == 1) {

            //BOTONES DE ACCIONES
            $table .=
                '<button class="btn btn-warning accionesPeticion" onclick="getInfo(' . $ID_PETICION . ')">
                <span class="bi bi-eye-fill"></span>
                </button>

            </div>
               

            </td>
        </tr>
        ';
        } elseif ($ID_ESTATUS_COPY == 'Completado' || $ID_ESTATUS_COPY == 'Rechazado') {

            //BOTONES DE ACCIONES
            $table .=
                '<button class="btn btn-warning accionesPeticion" onclick="getInfo(' . $ID_PETICION . ')">
                <span class="bi bi-eye-fill"></span>
                </button>


            </div>
               

            </td>
        </tr>
        ';
        } else {
            $table .=
                '<button class="btn btn-warning accionesPeticion" onclick="getInfo(' . $ID_PETICION . ')">
                <span class="bi bi-eye-fill"></span>
                </button>

                <button class="btn btn-info accionesPeticion" onclick="actualizarGetInfo(' . $ID_PETICION . ","  . $display . ')">
                <span class="bi bi-pencil-fill"></span>
                </button>

                <button class="btn btn-danger accionesPeticion" onclick="eliminar(' . $ID_PETICION . ')">
                <span class="bi bi-trash-fill"></span>
                </button>
            </div>


            </td>
        </tr>
        ';
        }

        //CONTADOR QUE HACE REFERENCIA AL # EN LA TABLA
        $CONT += 1;
    }

    //CIERRE DE LA CONSULTA
    $stmt->close();

    //CONTATENAMOS LA ESTRUCUTURA FINAL DE LA TABLA, ES REQUERIDO SI NO SE HACE NO FUNCIONA EL DATATABLE
    $table .= ' 
                </tbody>
            </table>
            ';
    //MOSTRAMOS LA TABLA, SI NO SE MUESTRA NO FUNCIONA
    echo $table;
}

//==========================================================================================================================
//AGREGA PETICION
//==========================================================================================================================
if (isset($_POST['insertDataSend'])) {

    extract($_POST); //NOS DEVUELVE UN ARREGLO

    $DESARROLLADOR = $_POST['desarrolladorSend'];

    if ($DESARROLLADOR == "") {

        if (
            isset($_POST['asuntoSend']) &&
            isset($_POST['laboratorioSend']) &&
            isset($_POST['fechaEntregaEstimadaSend']) &&
            isset($_POST['fechaCompletadoSend']) &&
            isset($_POST['soporteSend']) &&
            isset($_POST['nivelSend']) &&
            isset($_POST['estatusSend']) &&
            isset($_POST['descripcionSend'])
        ) {

            $stmt = $conn->prepare(
                "INSERT INTO `peticion` 
                (`ASUNTO`, `ID_LABORATORIO`, `FECHA_LLEGADA`, `FECHA_ENTREGA_ESTIMADA`, `FECHA_COMPLETADO`, `ID_SOPORTE`, `ID_NIVEL`, `ID_ESTATUS`, `DESCRIPCION`) 
                VALUES (?, ?, current_timestamp(), ?, ?, ?, ?, ?, ?)"
            );

            $stmt->bind_param(
                "ssssssss",
                $asuntoSend,
                $laboratorioSend,
                $fechaEntregaEstimadaSend,
                $fechaCompletadoSend,
                $soporteSend,
                $nivelSend,
                $estatusSend,
                $descripcionSend
            );

            $stmt->execute();

            $stmt->close();
        }
    } else {

        if (
            isset($_POST['asuntoSend']) &&
            isset($_POST['laboratorioSend']) &&
            isset($_POST['fechaEntregaEstimadaSend']) &&
            isset($_POST['fechaCompletadoSend']) &&
            isset($_POST['soporteSend']) &&
            isset($_POST['nivelSend']) &&
            isset($_POST['estatusSend']) &&
            isset($_POST['descripcionSend']) &&
            isset($_POST['desarrolladorSend'])
        ) {

            $stmt = $conn->prepare(
                "INSERT INTO `peticion` 
                (`ASUNTO`, `ID_LABORATORIO`, `FECHA_LLEGADA`, `FECHA_ENTREGA_ESTIMADA`, `FECHA_COMPLETADO`, `ID_SOPORTE`, `ID_NIVEL`, `ID_ESTATUS`, `DESCRIPCION`, `ID_DESARROLLADOR`) 
                VALUES (?, ?, current_timestamp(), ?, ?, ?, ?, ?, ?, ?)"
            );

            $stmt->bind_param(
                "sssssssss",
                $asuntoSend,
                $laboratorioSend,
                $fechaEntregaEstimadaSend,
                $fechaCompletadoSend,
                $soporteSend,
                $nivelSend,
                $estatusSend,
                $descripcionSend,
                $desarrolladorSend
            );

            $stmt->execute();

            $stmt->close();
        }
    }
}

//==========================================================================================================================
//ELIMINA PETICION
//==========================================================================================================================
if (isset($_POST['eliminarDataSend'])) {

    $id = $_POST['deleteSend'];

    // $stmt = $conn->prepare(
    //     "DELETE FROM `peticion` WHERE ID_PETICION = ?"
    // );

    // $stmt->bind_param("i", $id);

    // $stmt->execute();

    // $stmt->close();

    $stmt = $conn->prepare(
        "UPDATE `peticion` SET `ELIMINADO` = '1' WHERE ID_PETICION = ?"
    );

    $stmt->bind_param("i", $id);

    $stmt->execute();

    $stmt->close();
}

//==========================================================================================================================
//ACTUALIZA PETICION
//==========================================================================================================================
if (isset($_POST['actualizarDataSend'])) {

    $ID_PETICION = $_POST['idHiddenSend'];
    $ASUNTO = $_POST['asuntoActualizarSend'];
    $ID_LABORATORIO = $_POST['laboratorioActualizarSend'];
    $FECHA_ENTREGA_ESTIMADA = $_POST['fechaEntregaActualizarSend'];
    $ID_DESARROLLADOR = $_POST['desarrolladorActualizarSend'];
    $ID_NIVEL = $_POST['nivelActualizarSend'];
    $ID_ESTATUS = $_POST['estatusActualizarSend'];
    $DESCRIPCION = $_POST['descripcionActualizarSend'];
    $ENVIADO = $_POST['enviadoSend'];


    //OBTENEMOS DATOS NECESARIOS
    if (isset($ID_ESTATUS)) {

        //OBTENEMOS EL NOMBRE DEL ESTATUS -> COMPLETADO, PENDIENTE, RECHAZADO, DESARROLLO 

        $stmt = $conn->prepare("SELECT ESTATUS FROM estatus WHERE ID_ESTATUS = ?");

        $stmt->bind_param("i", $ID_ESTATUS);

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();

        $data = $result->fetch_assoc();

        $ID_ESTATUS_TEXT = $data['ESTATUS'];

        $ID_ESTATUS_TEXT = strtolower($ID_ESTATUS_TEXT);

        //OBTENEMOS LA FECHA DE COMPLETADO 

        $stmt = $conn->prepare("SELECT FECHA_COMPLETADO FROM PETICION WHERE ID_PETICION = ?");

        $stmt->bind_param("i", $ID_PETICION);

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();

        $data = $result->fetch_assoc();

        $FECHA_COMPLETADO_TEXT = $data['FECHA_COMPLETADO'];

        $FECHA_COMPLETADO_TEXT = strtolower($FECHA_COMPLETADO_TEXT);
    }

    //COMPROBAMOS SI EL DESARROLLADOR ES NULO, VOLVEMOS A ACTUALIZARLO COMO NULO
    if ($ID_DESARROLLADOR == 'null' || $ID_DESARROLLADOR == '0') {

        $ID_DESARROLLADOR = NULL;
    }

    if ($FECHA_COMPLETADO_TEXT == '0000-00-00 00:00:00' && $ID_ESTATUS_TEXT == 'completado') {


        if ($ID_ESTATUS_TEXT == 'completado' && $ENVIADO == "false") {

            $stmt = $conn->prepare(
                "UPDATE `peticion` SET `ASUNTO` = ?,
                `ID_LABORATORIO` = ?,
                `FECHA_ENTREGA_ESTIMADA` = ?,
                `ID_DESARROLLADOR` = ?,
                `ID_NIVEL` = ?,
                `ID_ESTATUS` = ?,
                `DESCRIPCION` = ?,
                `FECHA_COMPLETADO` = current_timestamp()
                WHERE `ID_PETICION` = ?"
            );

            $stmt->bind_param("sssssssi", $ASUNTO, $ID_LABORATORIO, $FECHA_ENTREGA_ESTIMADA, $ID_DESARROLLADOR, $ID_NIVEL, $ID_ESTATUS, $DESCRIPCION, $ID_PETICION);

            $stmt->execute();

            $stmt->close();
        } elseif ($ID_ESTATUS_TEXT == 'completado' && $ENVIADO == "true") {

            //SE ACTUALIZA LA PETICION

            $stmt = $conn->prepare(
                "UPDATE `peticion` SET `ASUNTO` = ?,
                `ID_LABORATORIO` = ?,
                `FECHA_ENTREGA_ESTIMADA` = ?,
                `ID_DESARROLLADOR` = ?,
                `ID_NIVEL` = ?,
                `ID_ESTATUS` = ?,
                `DESCRIPCION` = ?,
                `FECHA_COMPLETADO` = current_timestamp(),
                `ENVIADO` = 1
                WHERE `ID_PETICION` = ?"
            );

            $stmt->bind_param("sssssssi", $ASUNTO, $ID_LABORATORIO, $FECHA_ENTREGA_ESTIMADA, $ID_DESARROLLADOR, $ID_NIVEL, $ID_ESTATUS, $DESCRIPCION, $ID_PETICION);

            $stmt->execute();

            $stmt->close();

            //OBTENEMOS LOS DATOS ACTUALIZADOS PARA ENVIARLOS POR CORREO

            $stmt = $conn->prepare(
                "SELECT p.*,
                l.nombre AS NOMLAB,
                d.nombre AS NOMDES,
                s.nombre AS NOMSOP,
                s.correo AS CORREOSOP
                FROM peticion AS p 
                INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO
                LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR
                INNER JOIN soporte AS s ON p.ID_SOPORTE = s.ID_SOPORTE WHERE `ID_PETICION` = ?"
            );

            $stmt->bind_param("i", $ID);

            $stmt->execute();

            $result = $stmt->get_result();

            $stmt->close();

            $data = $result->fetch_assoc();

            if ($data['ID_ESTATUS'] == 2) {
                $ESTATUS = 'COMPLETADA satisfactoriamente.';
            } else {
                $ESTATUS = 'RECHAZADA';
            }

            $ID = $data['ID_PETICION'];
            $LAB = $data['NOMLAB'];
            $DES = $data['NOMDES'];
            $SOP = $data['NOMSOP'];
            $CORREO = $data['CORREOSOP'];
            $ASUNTO = $data['ASUNTO'];
            $SOLICITUD = $data['FECHA_LLEGADA'];


            //Create an instance; passing `true` enables exceptions
            // $mail = new PHPMailer(true);

            // try {
            //     //Server settings
            //     $mail->SMTPDebug = 0; //Enable verbose debug output
            //     $mail->isSMTP(); //Send using SMTP
            //     $mail->Host       = 'smtp.gmail.com'; //Set the SMTP server to send through
            //     $mail->SMTPAuth   = true; //Enable SMTP authentication
            //     $mail->Username   = 'anzu4147@gmail.com'; //SMTP username
            //     $mail->Password   = 'szirzcskstybhfqv'; //SMTP password
            //     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
            //     $mail->Port       = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //     //Recipients
            //     $mail->setFrom('anzu4147@gmail.com', 'Modulo De Peticiones');
            //     $mail->addAddress($CORREO, $SOP);     //Add a recipient

            //     //Content
            //     $mail->isHTML(true); //Set email format to HTML
            //     $mail->Subject = "La peticion de $LAB ha sido $ESTATUS";
            //     $mail->Body    = "La petición de $LAB ha sido $ESTATUS por favor <b>AVISAR</b> al laboratorio <br>
            //     <b>ID DE LA PETICIÓN: </b>$ID <br>
            //     <b>ASUNTO: </b>$ASUNTO <br>
            //     <b>DESARROLLADOR: </b>$DES <br>
            //     <b>SOPORTE: </b>$SOP <br>
            //     <b>FECHA DE SOLICITUD: </b>$SOLICITUD <br>
            //     ";


            //     $mail->send();
            // } catch (Exception $e) {
            // }


        }
    } elseif ($ID_ESTATUS_TEXT == 'completado' && $ENVIADO == "true") {

        $stmt = $conn->prepare(
            "UPDATE `peticion` SET `ASUNTO` = ?,
            `ID_LABORATORIO` = ?,
            `FECHA_ENTREGA_ESTIMADA` = ?,
            `ID_DESARROLLADOR` = ?,
            `ID_NIVEL` = ?,
            `ID_ESTATUS` = ?,
            `DESCRIPCION` = ?,
            `ENVIADO` = 1
            WHERE `ID_PETICION` = ?"
        );

        $stmt->bind_param("sssssssi", $ASUNTO, $ID_LABORATORIO, $FECHA_ENTREGA_ESTIMADA, $ID_DESARROLLADOR, $ID_NIVEL, $ID_ESTATUS, $DESCRIPCION, $ID_PETICION);

        $stmt->execute();

        $stmt->close();


        echo 'ESTATUS COMPLETADO Y ENVIADO TRUE YA CON FECHA DE MODIFICACION';
    } else {


        //==========================================================================================================================
        //ESTA ES UNA ACTUALIZACIÓN NORMAL.
        //==========================================================================================================================
        $stmt = $conn->prepare(
            "UPDATE `peticion` SET `ASUNTO` = ?,
            `ID_LABORATORIO` = ?,
            `FECHA_ENTREGA_ESTIMADA` = ?,
            `ID_DESARROLLADOR` = ?,
            `ID_NIVEL` = ?,
            `ID_ESTATUS` = ?,
            `DESCRIPCION` = ?,
            `ENVIADO` = 0
            WHERE `ID_PETICION` = ?"
        );

        $stmt->bind_param("sssssssi", $ASUNTO, $ID_LABORATORIO, $FECHA_ENTREGA_ESTIMADA, $ID_DESARROLLADOR, $ID_NIVEL, $ID_ESTATUS, $DESCRIPCION, $ID_PETICION);

        $stmt->execute();

        $stmt->close();
    }
}

//==========================================================================================================================
//ACTUALIZAR DESDE EL BOTON DE WP, SOLO ACTUALIZA EL CAMPO ENVIO
//==========================================================================================================================
if (isset($_POST['actualizarDesdeWpSend'])) {

    $ID = $_POST['idSendWp'];

    $stmt = $conn->prepare("UPDATE `peticion` SET `ENVIADO` = 1 WHERE `ID_PETICION` = ?");

    $stmt->bind_param("i", $ID);

    $stmt->execute();

    $stmt->close();

    //OBTENEMOS LA INFORMACIÓN PARA ENVIARLA EN EL CORREO
    $stmt = $conn->prepare("SELECT p.*,
    l.nombre AS NOMLAB,
    d.nombre AS NOMDES,
    s.nombre AS NOMSOP,
    s.correo AS CORREOSOP
    FROM peticion AS p 
    INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO
    LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR
    INNER JOIN soporte AS s ON p.ID_SOPORTE = s.ID_SOPORTE WHERE `ID_PETICION` = ?");

    $stmt->bind_param("i", $ID);

    $stmt->execute();

    $result = $stmt->get_result();

    $stmt->close();

    $data = $result->fetch_assoc();

    if ($data['ID_ESTATUS'] == 2) {
        $ESTATUS = 'COMPLETADA satisfactoriamente.';
    } else {
        $ESTATUS = 'RECHAZADA';
    }

    $ID = $data['ID_PETICION'];
    $LAB = $data['NOMLAB'];
    $DES = $data['NOMDES'];
    $SOP = $data['NOMSOP'];
    $CORREO = $data['CORREOSOP'];
    $ASUNTO = $data['ASUNTO'];
    $SOLICITUD = $data['FECHA_LLEGADA'];


    //Create an instance; passing `true` enables exceptions
    // $mail = new PHPMailer(true);

    // try {
    //     //Server settings
    //     $mail->SMTPDebug = 0; //Enable verbose debug output
    //     $mail->isSMTP(); //Send using SMTP
    //     $mail->Host       = 'smtp.gmail.com'; //Set the SMTP server to send through
    //     $mail->SMTPAuth   = true; //Enable SMTP authentication
    //     $mail->Username   = 'anzu4147@gmail.com'; //SMTP username
    //     $mail->Password   = 'szirzcskstybhfqv'; //SMTP password
    //     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
    //     $mail->Port       = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //     //Recipients
    //     $mail->setFrom('anzu4147@gmail.com', 'Modulo De Peticiones');
    //     $mail->addAddress($CORREO, $SOP);     //Add a recipient

    //     //Content
    //     $mail->isHTML(true); //Set email format to HTML
    //     $mail->Subject = "La peticion de $LAB ha sido $ESTATUS";
    //     $mail->Body    = "La petición de $LAB ha sido $ESTATUS por favor <b>AVISAR</b> al laboratorio <br>
    //     <b>ID DE LA PETICIÓN: </b>$ID <br>
    //     <b>ASUNTO: </b>$ASUNTO <br>
    //     <b>DESARROLLADOR: </b>$DES <br>
    //     <b>SOPORTE: </b>$SOP <br>
    //     <b>FECHA DE SOLICITUD: </b>$SOLICITUD <br>
    //     ";


    //     $mail->send();
    // } catch (Exception $e) {
    // }
}

//==========================================================================================================================
//OBTIENE LA INFORMACION DE LA PETICION
//==========================================================================================================================
if (isset($_POST['getInfoDataSend']) || isset($_POST['getInfoUpdatePeticionSend'])) {

    if (isset($_POST['idSend'])) {

        $id = $_POST['idSend'];

        $stmt = $conn->prepare(
            "SELECT p.*,
            l.nombre AS NOMLAB,
            l.paquete AS PAQUETE, 
            n.nivel AS NOMNIVEL, 
            e.estatus AS NOMESTATUS, 
            d.nombre AS NOMDES,
            s.nombre AS NOMSOP,
            s.NUM_CELULAR AS NUMERO_SOPORTE  
            FROM peticion AS p 
            INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO
            INNER JOIN nivel AS n ON p.ID_NIVEL = n.ID_NIVEL
            INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS
            LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR
            INNER JOIN soporte AS s ON p.ID_SOPORTE = s.ID_SOPORTE WHERE ID_PETICION = ?"
        );

        $stmt->bind_param("i", $id);

        $stmt->execute();

        $result = $stmt->get_result();

        $data = $result->fetch_assoc();

        $stmt->close();

        echo json_encode($data);
    }
}
