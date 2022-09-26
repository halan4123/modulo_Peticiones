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
    n.nivel AS NOMNIVEL, 
    e.estatus AS NOMESTATUS, 
    d.nombre AS NOMDES,
    s.nombre AS NOMSOP 
    FROM peticion AS p 
    INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO
    INNER JOIN nivel AS n ON p.ID_NIVEL = n.ID_NIVEL
    INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS
    INNER JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR
    INNER JOIN soporte AS s ON p.ID_SOPORTE = s.ID_SOPORTE"; //     CREAMOS LA CONSULTA

    $result = mysqli_query($conn, $sql); //EJECUTAMOS LA CONSULTA

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
        $ID_ESTATUS = $row['NOMESTATUS'];

        $ID_NIVEL = preg_replace("/[[:space:]]/", "", trim($ID_NIVEL)); //Buscamos los espacios en blanco, los remplazamos por espacios nulos y limpiamos espacios al inicio y al final.
        $ID_NIVEL = strtolower($ID_NIVEL); //Convertimos el string a minusculas para que entre a los if de iconos por nivel.

        $ID_ESTATUS = strtolower($ID_ESTATUS);

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

        //DEPENDIENDO EL STATUS SE LE ASIGANARA UN ICONO
        if ($ID_ESTATUS == 'completado') {
            $ID_ESTATUS = '<span style="color: green;" class="fa fa-check-circle fa-2x" aria-hidden="true"></span>
            <label hidden>' . $ID_ESTATUS . '</label>';
        } else if ($ID_ESTATUS == 'rechazado') {
            $ID_ESTATUS = '<span style="color: red;" class="fa fa-times-circle fa-2x" aria-hidden="true"></span>
            <label hidden>' . $ID_ESTATUS . '</label>';
        } else if ($ID_ESTATUS == 'pendiente') {
            $ID_ESTATUS = '<span style="color: orange;" class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></span>
            <label hidden>' . $ID_ESTATUS . '</label>';
        } else if ($ID_ESTATUS == 'desarrollo') {
            $ID_ESTATUS = '<span style="color: #2995B8;" class="fa fa-desktop fa-2x" aria-hidden="true"></span>
            <label hidden>' . $ID_ESTATUS . '</label>';
        }

        //DEPENDIENDO EL NIVEL SE LE ASIGANARA UN ICONO
        if ($ID_NIVEL == 'nivel1') {
            $ID_NIVEL = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#4078B9" class="bi bi-1-circle-fill" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM9.283 4.002V12H7.971V5.338h-.065L6.072 6.656V5.385l1.899-1.383h1.312Z" />
            </svg>
            <label hidden>' . $ID_NIVEL . '</label>
            <label hidden>nivel 1</label>';
        } else if ($ID_NIVEL == 'nivel2') {
            $ID_NIVEL = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#7740B9" class="bi bi-2-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM6.646 6.24c0-.691.493-1.306 1.336-1.306.756 0 1.313.492 1.313 1.236 0 .697-.469 1.23-.902 1.705l-2.971 3.293V12h5.344v-1.107H7.268v-.077l1.974-2.22.096-.107c.688-.763 1.287-1.428 1.287-2.43 0-1.266-1.031-2.215-2.613-2.215-1.758 0-2.637 1.19-2.637 2.402v.065h1.271v-.07Z" />
            </svg>
            <label hidden>' . $ID_NIVEL . '</label>';
        } else if ($ID_NIVEL == 'nivel3') {
            $ID_NIVEL = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#AE8A48" class="bi bi-3-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0Zm-8.082.414c.92 0 1.535.54 1.541 1.318.012.791-.615 1.36-1.588 1.354-.861-.006-1.482-.469-1.54-1.066H5.104c.047 1.177 1.05 2.144 2.754 2.144 1.653 0 2.954-.937 2.93-2.396-.023-1.278-1.031-1.846-1.734-1.916v-.07c.597-.1 1.505-.739 1.482-1.876-.03-1.177-1.043-2.074-2.637-2.062-1.675.006-2.59.984-2.625 2.12h1.248c.036-.556.557-1.054 1.348-1.054.785 0 1.348.486 1.348 1.195.006.715-.563 1.237-1.342 1.237h-.838v1.072h.879Z" />
            </svg>
            <label hidden>' . $ID_NIVEL . '</label>';
        } else if ($ID_NIVEL == 'nivel4') {
            $ID_NIVEL = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#97989E" class="bi bi-4-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM7.519 5.057c-.886 1.418-1.772 2.838-2.542 4.265v1.12H8.85V12h1.26v-1.559h1.007V9.334H10.11V4.002H8.176c-.218.352-.438.703-.657 1.055ZM6.225 9.281v.053H8.85V5.063h-.065c-.867 1.33-1.787 2.806-2.56 4.218Z" />
            </svg>
            <label hidden>' . $ID_NIVEL . '</label>';
        } else if ($ID_NIVEL == 'sindefinir') {
            $ID_NIVEL = 'Sin Definir';
            // '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="black" class="bi bi-circle-fill" viewBox="0 0 16 16">
            // <circle cx="8" cy="8" r="8"/>
            // </svg>
            '<label hidden>' . $ID_NIVEL . '</label>';
        }


        //CONTATENAMOS LAS FILAS OBTENIDAD POR VUELTA CON LA INFORMACIÓN DE LA BD
        $table .= '
            <tr>
                <td>' . $ID_PETICION . '</td>
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
                    <button class="btn btn-warning bwh" onclick="getInfo(' . $ID_PETICION . ')">
                    <span class="fa fa-eye"></span>
                    </button>

                    <button class="btn btn-info bwh" onclick="actualizarGetInfo(' . $ID_PETICION . ')">
                    <span class="fa fa-pencil"></span>
                    </button>

                    <button class="btn btn-danger bwh" onclick="eliminar(' . $ID_PETICION . ')">
                    <span class="glyphicon glyphicon-remove"></span>
                    </button>
                </div>
                   

                </td>
            </tr>
            ';
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
        isset($_POST['desarrolladorSend']) &&
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
            `ID_DESARROLLADOR`, 
            `ID_NIVEL`, 
            `ID_ESTATUS`, 
            `DESCRIPCION`) 
            VALUES ('$asuntoSend', 
            '$laboratorioSend', 
            current_timestamp(), 
            '$fechaEntregaEstimadaSend', 
            '$fechaCompletadoSend',
            '$soporteSend', 
            '$desarrolladorSend', 
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

//GETINFO DE PETICIÓN
if (isset($_POST['getInfoDataSend'])) {

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
        INNER JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR
        INNER JOIN soporte AS s ON p.ID_SOPORTE = s.ID_SOPORTE WHERE ID_PETICION = $id;";

        $result = mysqli_query($conn, $sql);

        $response = array();

        while ($row = mysqli_fetch_assoc($result)) {

            $response = $row;
        }

        echo json_encode($response);
    }
}
