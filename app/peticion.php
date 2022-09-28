<?php

include 'connectionController.php';

$conn = connect();


//MUESTREO DE LA TABLA Y VALIDACIONES DE LA MISMA
if (isset($_POST['displayDataSend'])) {

    $table = '
    <table id="tabla_peticiones" class="display table table-responsive table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>ESTATUS</th>
                <th>NIVEL</th>
                <th>ASUNTO</th>
                <th>LABORATORIO</th>
                <th>PAQUETE</th>
                <th>SOLICITUD</th>
                <th>ESTIMADA</th>
                <th>COMPLETADO</th>
                <th>RESTANTE</th>
                <th>SOPORTE</th>
                <th>DESARROLLADOR</th>
                <th>ACCIONES</th>
            </tr>
        </thead>
        <tbody>
        ';

    //$sql = "SELECT * FROM `peticion` INNER JOIN laboratorio ON peticion.ID_LABORATORIO = laboratorio.ID_LABORATORIO;"; //CREAMOS LA CONSULTA 

    $sql = "SELECT p.*,
    l.nombre AS NOMLAB,
    l.paquete AS PAQUETE,
    n.ID_NIVEL AS N_ID, 
    n.nivel AS NOMNIVEL,
    n.icono AS NIVEL_ICONO,
    n.color_icono AS NIVEL_COLOR,
    e.ID_ESTATUS AS E_ID,
    e.estatus AS NOMESTATUS,
    e.icono AS ESTATUS_ICONO,
    e.color_icono AS ESTATUS_COLOR, 
    d.nombre AS NOMDES,
    s.nombre AS NOMSOP 
    FROM peticion AS p 
    INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO
    INNER JOIN nivel AS n ON p.ID_NIVEL = n.ID_NIVEL
    INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS
    LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR
    INNER JOIN soporte AS s ON p.ID_SOPORTE = s.ID_SOPORTE WHERE 1";

    if (isset($_POST['filtroEstatusSend']) || isset($_POST['filtroNivelSend']) || isset($_POST['filtroFechaInicioSend']) || isset($_POST['filtroFechaFinalSend'])) {

        if (isset($_POST['filtroNivelSend'])) {

            $nivel = $_POST['filtroNivelSend'];

            if ($nivel !== 'todo') {

                $sql .= " and n.ID_NIVEL = '$nivel'"; //DEPENDIENDO EL FILTRO CONCATENAMOS A LA CONSULTA ORIGINAL 

            }
        }
    

        if (isset($_POST['filtroEstatusSend'])) {

            $statusRe = $_POST['filtroEstatusSend'];

            if ($statusRe !== 'todo') {

                $sql .= " and e.ID_ESTATUS = '$statusRe'"; //DEPENDIENDO EL FILTRO CONCATENAMOS A LA CONSULTA ORIGINAL

            }
        }

        if (isset($_POST['filtroFechaInicioSend']) && isset($_POST['filtroFechaFinalSend'])) {
            $fechaInicio = $_POST['filtroFechaInicioSend'];
            $fechaFinal = $_POST['filtroFechaFinalSend'];
            $newDate_1 = date("Y-m-d", strtotime($fechaInicio));
            $newDate_2 = date("Y-m-d", strtotime($fechaFinal));
            if ($fechaInicio !== '' && $fechaFinal !== '') {
                $sql .= " and FECHA_LLEGADA BETWEEN '$newDate_1' and '$newDate_2'";
            }
        }
       
    }

    $sql .= " ORDER BY e.ESTATUS = 'Pendiente' DESC,
    p.FECHA_LLEGADA DESC,
    e.ESTATUS = 'Desarrollo' DESC,
    e.ESTATUS = 'Completado' DESC,
    e.ESTATUS = 'Rechazado' DESC";

    $result = mysqli_query($conn, $sql); //EJECUTAMOS LA CONSULTA

    $CONT = 1; //SE ESTABLECE UN CONTADOR PARA COLOCARLO EN LA COLUMNA #

    while ($row = mysqli_fetch_assoc($result)) {

        //POR CADA CICLO OBTENEMOS LOS DATOS DE LA BD Y LOS GUARDAMOS EN VARIABLES 
        $ID_PETICION = $row['ID_PETICION'];
        $ASUNTO = $row['ASUNTO'];
        $ID_LABORATORIO = $row['NOMLAB'];
        $PAQUETE = $row['PAQUETE'];
        $FECHA_LLEGADA = $row['FECHA_LLEGADA'];
        $FECHA_ENTREGA_ESTIMADA = $row['FECHA_ENTREGA_ESTIMADA'];
        $FECHA_COMPLETADO = $row['FECHA_COMPLETADO'];
        $ID_DESARROLLADOR = $row['NOMDES'];
        $ID_SOPORTE = $row['NOMSOP'];

        $ID_NIVEL = $row['NOMNIVEL'];
        $NIVEL_ICONO = $row['NIVEL_ICONO'];
        $NIVEL_COLOR = $row['NIVEL_COLOR'];

        $ID_ESTATUS = $row['NOMESTATUS'];
        $ESTATUS_ICONO = $row['ESTATUS_ICONO'];
        $ESTATUS_COLOR = $row['ESTATUS_COLOR'];

        $FECHA_ENTREGA_ESTIMADA_COPY = $FECHA_ENTREGA_ESTIMADA;
        $FECHA_COMPLETADO_COPY = $FECHA_COMPLETADO;

        $FECHA_LLEGADA = substr($FECHA_LLEGADA, 0, -9); //CORTAMOS LA FECHA DE LLEGADA PARA MOSTRAR SOLO LA FECHA Y NO LA HORA
        $FECHA_ENTREGA_ESTIMADA = substr($FECHA_ENTREGA_ESTIMADA, 0, -9);
        $FECHA_COMPLETADO = substr($FECHA_COMPLETADO, 0, -9);

        $FECHA_LLEGADA = date("d-m-Y", strtotime($FECHA_LLEGADA));
        $FECHA_ENTREGA_ESTIMADA = date("d-m-Y", strtotime($FECHA_ENTREGA_ESTIMADA));

        date_default_timezone_set('America/Chihuahua'); //ESTABLECEMOS ZONA HORARIA

        if ($FECHA_COMPLETADO_COPY == '0000-00-00 00:00:00') {
            $FECHA_COMPLETADO = 'INCOMPLETA';
        }

        if ($FECHA_ENTREGA_ESTIMADA_COPY == '0000-00-00 00:00:00') {

            $tiempo = 'Sin Definir';
        } else {

            $fechaActual = date('y-m-d'); //SE OBTIENE, CREA LA FECHA ACTUAL
            $datetime1 = date_create($fechaActual); //CONVERTIMOS A DATECREATE PARA PODER USAR DATE DIFF
            $datetime2 = date_create($FECHA_ENTREGA_ESTIMADA); //CONVERTIMOS A DATECREATE PARA PODER USAR DATE DIFF
            $interval = date_diff($datetime1, $datetime2); //OBTENEMOS LA DIFERENCIA
            $tiempo = $interval->format('%R%a días');
        }

        if ($FECHA_ENTREGA_ESTIMADA == '30-11--0001') {

            $FECHA_ENTREGA_ESTIMADA = 'Sin Definir';
        }

        //El tiempo restante cambia a completado, deja de aparecer sin definir o +5 -8 dias
        if ($ID_ESTATUS == 'Completado') {
            $tiempo = 'Completado';
        }

        //EL DESAROLLADOR PUEDE SER NULL POR EL LEFT JOIN
        if ($ID_DESARROLLADOR == NULL) {
            $ID_DESARROLLADOR = 'Sin Definir';
        }

        //DEPENDIENDO EL STATUS Y DEL NIVEL DE LA DB SE LE ASIGANARA UN ICONO Y UN COLOR
        $ID_ESTATUS = '<span style="color:' . $ESTATUS_COLOR . ';" class="tam ' . $ESTATUS_ICONO . '" aria-hidden="true"></span>
         <label hidden>' . $ID_ESTATUS . '</label>';

        $ID_NIVEL = '<span style="color:' . $NIVEL_COLOR . ';" class="tam ' . $NIVEL_ICONO . '" aria-hidden="true"></span>
         <label hidden>' . $ID_ESTATUS . '</label>';


        //CONTATENAMOS LAS FILAS OBTENIDAD POR VUELTA CON LA INFORMACIÓN DE LA BD
        $table .= '
            <tr>
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
                <td>' . $ID_SOPORTE . '</td>
                <td>' . $ID_DESARROLLADOR . '</td>

    
                <td>
                <div class="re">
                    <button class="btn btn-warning accionesPeticion" onclick="getInfo(' . $ID_PETICION . ')">
                    <span class="bi bi-eye-fill"></span>
                    </button>

                    <button class="btn btn-info accionesPeticion" onclick="actualizarGetInfo(' . $ID_PETICION . ')">
                    <span class="bi bi-pencil-fill"></span>
                    </button>

                    <button class="btn btn-danger accionesPeticion" onclick="eliminar(' . $ID_PETICION . ')">
                    <span class="bi bi-trash-fill"></span>
                    </button>
                </div>
                   

                </td>
            </tr>
            ';

        $CONT += 1;
    }

    //CONTATENAMOS LA ESTRUCUTURA FINAL DE LA TABLA, ES REQUERIDO SI NO SE HACE NO FUNCIONA EL DATATABLE
    $table .= ' 
                </tbody>
            </table>
            ';
    //MOSTRAMOS LA TABLA, SI NO SE MUESTRA NO FUNCIONA
    echo $table;
}

//INSERT DE PETICIÓN
if (isset($_POST['insertDataSend'])) {

    extract($_POST); //NOS DEVUELVE UN ARREGLO

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
        //CREAMOS LA CONSULTA
        $sql =
            "INSERT INTO `peticion` 
            (`ASUNTO`, 
            `ID_LABORATORIO`, 
            `FECHA_LLEGADA`, 
            `FECHA_ENTREGA_ESTIMADA`, 
            `FECHA_COMPLETADO`, 
            `ID_SOPORTE`, 
            `ID_NIVEL`, 
            `ID_ESTATUS`, 
            `DESCRIPCION`) 
            VALUES ('$asuntoSend', 
            '$laboratorioSend', 
            current_timestamp(), 
            '$fechaEntregaEstimadaSend', 
            '$fechaCompletadoSend',
            '$soporteSend', 
            '$nivelSend', 
            '$estatusSend', 
            '$descripcionSend')";

        //EJECUTAMOS LA CONSULTA
        $result = mysqli_query($conn, $sql);
    }
}

//DELETE DE PETICIÓN
if (isset($_POST['eliminarDataSend'])) {

    $id = $_POST['deleteSend'];

    $sql = "DELETE FROM `peticion` WHERE ID_PETICION = $id";
    $result = mysqli_query($conn, $sql);
}

//ACTUALIZAR DE PETICIÓN
if (isset($_POST['actualizarDataSend'])) {

    $ID_PETICION = $_POST['idHiddenSend'];
    $ASUNTO = $_POST['asuntoActualizarSend'];
    $ID_LABORATORIO = $_POST['laboratorioActualizarSend'];
    $FECHA_ENTREGA_ESTIMADA = $_POST['fechaEntregaActualizarSend'];
    $ID_DESARROLLADOR = $_POST['desarrolladorActualizarSend'];
    $ID_NIVEL = $_POST['nivelActualizarSend'];
    $ID_ESTATUS = $_POST['estatusActualizarSend'];
    $DESCRIPCION = $_POST['descripcionActualizarSend'];

    if ($ID_LABORATORIO == null) {

        $query = "SELECT ID_LABORATORIO FROM peticion WHERE ID_PETICION = $ID_PETICION";

        $result = $conn->query($query);

        $ID_LABORATORIO = $result->fetch_array()[0] ?? '';
    }

    if ($ID_DESARROLLADOR == null) {

        $query = "SELECT ID_DESARROLLADOR FROM peticion WHERE ID_PETICION = $ID_PETICION";

        $result = $conn->query($query);

        $ID_DESARROLLADOR = $result->fetch_array()[0] ?? '';
    }

    if ($ID_NIVEL == null) {

        $query = "SELECT ID_NIVEL FROM peticion WHERE ID_PETICION = $ID_PETICION";

        $result = $conn->query($query);

        $ID_NIVEL = $result->fetch_array()[0] ?? '';
    }

    if ($ID_ESTATUS == null) {

        $query = "SELECT ID_ESTATUS FROM peticion WHERE ID_PETICION = $ID_PETICION";

        $result = $conn->query($query);

        $ID_ESTATUS = $result->fetch_array()[0] ?? '';
    }

    //EL ESTATUS 2 ES COMPLETADO
    if ($ID_ESTATUS == 2) {

        //SI EL ESTATUS CAMBIA A COMPLETADO SE REGISTRARA LA FECHA ACTUAL DE COMPLETADO
        $sql = "UPDATE `peticion` SET `ASUNTO` = '$ASUNTO',
        `ID_LABORATORIO` = '$ID_LABORATORIO',
        `FECHA_ENTREGA_ESTIMADA` = '$FECHA_ENTREGA_ESTIMADA',
        `ID_DESARROLLADOR` = '$ID_DESARROLLADOR',
        `ID_NIVEL` = '$ID_NIVEL',
        `ID_ESTATUS` = '$ID_ESTATUS',
        `DESCRIPCION` = '$DESCRIPCION',
        `FECHA_COMPLETADO` = current_timestamp()
        WHERE `ID_PETICION` = $ID_PETICION";

        $result = mysqli_query($conn, $sql);
    } else {

        //SI NO CAMBIA A COMPLETADO SE HACE LA ACTUALIZACIÓN NORMAL
        $sql = "UPDATE `peticion` SET `ASUNTO` = '$ASUNTO',
        `ID_LABORATORIO` = '$ID_LABORATORIO',
        `FECHA_ENTREGA_ESTIMADA` = '$FECHA_ENTREGA_ESTIMADA',
        `ID_DESARROLLADOR` = '$ID_DESARROLLADOR',
        `ID_NIVEL` = '$ID_NIVEL',
        `ID_ESTATUS` = '$ID_ESTATUS',
        `DESCRIPCION` = '$DESCRIPCION'
        WHERE `ID_PETICION` = $ID_PETICION";

        $result = mysqli_query($conn, $sql);
    }
}

//GETINFO DE PETICIÓN getInfoUpdatePeticionSend
if (isset($_POST['getInfoDataSend']) || isset($_POST['getInfoUpdatePeticionSend'])) {

    if (isset($_POST['idSend'])) {

        $id = $_POST['idSend'];

        $sql = "SELECT p.*,
        l.nombre AS NOMLAB,
        l.paquete AS PAQUETE, 
        n.nivel AS NOMNIVEL, 
        e.estatus AS NOMESTATUS, 
        d.nombre AS NOMDES,
        s.nombre AS NOMSOP 
        FROM peticion AS p 
        INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO
        INNER JOIN nivel AS n ON p.ID_NIVEL = n.ID_NIVEL
        INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS
        LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR
        INNER JOIN soporte AS s ON p.ID_SOPORTE = s.ID_SOPORTE WHERE ID_PETICION = $id;";

        $result = mysqli_query($conn, $sql);

        $response = array();

        while ($row = mysqli_fetch_assoc($result)) {

            $response = $row;
        }

        echo json_encode($response);
    }
}
