<?php
include 'connectionController.php';

$conn = connect();

date_default_timezone_set('America/Chihuahua');
$MES_ACTUAL = date('m');
$YEAR_ACTUAL = date('Y');
$MES_POR_DEFECTO = 1;

//==========================================================================================================================
//GRAFICA DE PETCIONES ACEPTADAS POR DESARROLLADOR
//==========================================================================================================================

if (isset($_POST['desarrolladorDatosSend'])) {


    $sql = "SELECT `NOMBRE` FROM `desarrollador` WHERE `OCULTO` = 0 ORDER BY NOMBRE ASC";

    $result = mysqli_query($conn, $sql);

    $NOMBRES_DESARROLLADORES = array();

    //OBTENCIÓN DE LOS NOMBRES DE LOS DESARROLLADORES
    while ($row = mysqli_fetch_assoc($result)) {

        array_push($NOMBRES_DESARROLLADORES, $row['NOMBRE']);
    }

    $CONTADOR = 0;

    $CANTIDAD = count($NOMBRES_DESARROLLADORES);

    $DESARROLLOS = array();

    //OBTENCIÓN DE LOS DATOS DE CADA DESARROLLADOR
    if ($_POST['fechaInicioSend'] != '' && $_POST['fechaFinalSend'] != '') {

        $FECHA_INICIO = $_POST['fechaInicioSend'];

        $FECHA_FINAL = $_POST['fechaFinalSend'];

        while ($CONTADOR < $CANTIDAD) {

            $PERSONA = $NOMBRES_DESARROLLADORES[$CONTADOR];

            $query = "SELECT d.nombre AS NOMDES, COUNT(ID_PETICION) AS TOTAL 
             FROM peticion AS p LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR 
             WHERE d.nombre = '$PERSONA' and FECHA_LLEGADA BETWEEN '$FECHA_INICIO' and '$FECHA_FINAL'";

            $result2 = $conn->query($query);

            $VALOR = $result2->fetch_array()['TOTAL'] ?? 0;

            array_push($DESARROLLOS, intval($VALOR));

            $CONTADOR++;
        }
    } else {

        while ($CONTADOR < $CANTIDAD) {

            $PERSONA = $NOMBRES_DESARROLLADORES[$CONTADOR];

            $query = "SELECT d.nombre AS NOMDES, COUNT(ID_PETICION) AS TOTAL 
            FROM peticion AS p LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR 
            WHERE d.nombre = '$PERSONA' AND MONTH(FECHA_LLEGADA) = $MES_ACTUAL AND YEAR(FECHA_LLEGADA) = $YEAR_ACTUAL";

            $result2 = $conn->query($query);

            $VALOR = $result2->fetch_array()['TOTAL'] ?? 0;

            array_push($DESARROLLOS, intval($VALOR));

            $CONTADOR++;
        }
    }

    // Ahora las imprimimos como JSON para pasarlas a AJAX, pero las agrupamos
    $respuesta = [
        "nombre" => $NOMBRES_DESARROLLADORES,
        "datos" => $DESARROLLOS,
    ];

    echo json_encode($respuesta);
}

//==========================================================================================================================
//GRAFICA DE PETCIONES REGISTRADAS POR SOPORTE
//==========================================================================================================================

if (isset($_POST['soporteDatosSend'])) {

    $sql = "SELECT `NOMBRE` FROM `soporte` WHERE `OCULTO` = 0 ORDER BY NOMBRE ASC";

    $result = mysqli_query($conn, $sql);

    $NOMBRES_SOPORTES = array();

    while ($row = mysqli_fetch_assoc($result)) {

        array_push($NOMBRES_SOPORTES, $row['NOMBRE']);
    }

    $CONTADOR = 0;

    $CANTIDAD = count($NOMBRES_SOPORTES);

    $VALOR_SOPORTE = array();

    //OBTENCIÓN DE LOS DATOS DE CADA DESARROLLADOR
    if ($_POST['fechaInicioSend'] != '' && $_POST['fechaFinalSend'] != '') {

        $FECHA_INICIO = $_POST['fechaInicioSend'];

        $FECHA_FINAL = $_POST['fechaFinalSend'];

        while ($CONTADOR < $CANTIDAD) {

            $PERSONA = $NOMBRES_SOPORTES[$CONTADOR];

            $query = "SELECT s.nombre AS NOMSOP, COUNT(ID_PETICION) AS TOTAL 
            FROM peticion AS p 
            INNER JOIN soporte AS s ON p.ID_SOPORTE = s.ID_SOPORTE WHERE s.nombre = '$PERSONA'
            and FECHA_LLEGADA BETWEEN '$FECHA_INICIO' and '$FECHA_FINAL'";

            $result = $conn->query($query);

            $VALOR = $result->fetch_array()['TOTAL'] ?? 0;

            array_push($VALOR_SOPORTE, intval($VALOR));

            $CONTADOR++;
        }
    } else {

        while ($CONTADOR < $CANTIDAD) {

            $PERSONA = $NOMBRES_SOPORTES[$CONTADOR];

            $query = "SELECT s.nombre AS NOMSOP, COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
            INNER JOIN soporte AS s ON p.ID_SOPORTE = s.ID_SOPORTE WHERE s.nombre = '$PERSONA' AND MONTH(FECHA_LLEGADA) = $MES_ACTUAL AND YEAR(FECHA_LLEGADA) = $YEAR_ACTUAL";

            $result = $conn->query($query);

            $VALOR = $result->fetch_array()['TOTAL'] ?? 0;

            array_push($VALOR_SOPORTE, intval($VALOR));

            $CONTADOR++;
        }
    }

    //$datosVentas = [30, 10];

    // Ahora las imprimimos como JSON para pasarlas a AJAX, pero las agrupamos
    $respuesta = [
        "nombre" => $NOMBRES_SOPORTES,
        "datos" => $VALOR_SOPORTE,
    ];

    echo json_encode($respuesta);
}

//==========================================================================================================================
//GRAFICA DE PETCIONES ANUAL RECIBIDAS POR MES
//==========================================================================================================================

if (isset($_POST['anualDatosSend'])) {

    $yearGot = $_POST['yearSend']; //string

    $MES_POR_DEFECTO = 1;

    $VALOR_MENSUAL = array();

    if ($yearGot != '') {
        while ($MES_POR_DEFECTO <= 12) {

            $sql = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion WHERE MONTH(FECHA_LLEGADA) = $MES_POR_DEFECTO 
                AND YEAR(FECHA_LLEGADA) = $yearGot";

            $result = mysqli_query($conn, $sql);

            $VALOR = $result->fetch_array()['TOTAL'] ?? 0;

            $VALOR = intval($VALOR);

            array_push($VALOR_MENSUAL, $VALOR);

            $MES_POR_DEFECTO++;
        }
    } else {
        while ($MES_POR_DEFECTO <= 12) {

            $sql = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion WHERE MONTH(FECHA_LLEGADA) = $MES_POR_DEFECTO 
                AND YEAR(FECHA_LLEGADA) = $YEAR_ACTUAL";

            $result = mysqli_query($conn, $sql);

            $VALOR = $result->fetch_array()['TOTAL'] ?? 0;

            $VALOR = intval($VALOR);

            array_push($VALOR_MENSUAL, $VALOR);

            $MES_POR_DEFECTO++;
        }
    }






    $respuesta = [
        "datos" => $VALOR_MENSUAL,
    ];

    echo json_encode($respuesta);
}

//==========================================================================================================================
//GRAFICA DE PETCIONES ANUALES COMPLETADAS POR MES
//==========================================================================================================================

if (isset($_POST['anualDatosCompletadasSend'])) {

    $yearGot = $_POST['yearSend'];

    $MES_POR_DEFECTO = 1;

    $VALOR_MENSUAL_COMPLETADAS = array();

    if ($yearGot != '') {
        while ($MES_POR_DEFECTO <= 12) {

            $sql = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
            INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
            WHERE e.estatus = 'Completado' AND MONTH(FECHA_LLEGADA) = $MES_POR_DEFECTO 
            AND YEAR(FECHA_LLEGADA) = $yearGot";

            $result = mysqli_query($conn, $sql);

            $VALOR = $result->fetch_array()['TOTAL'] ?? 0;

            $VALOR = intval($VALOR);

            array_push($VALOR_MENSUAL_COMPLETADAS, $VALOR);

            $MES_POR_DEFECTO++;
        }
    } else {
        while ($MES_POR_DEFECTO <= 12) {

            $sql = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
            INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
            WHERE e.estatus = 'Completado' AND MONTH(FECHA_LLEGADA) = $MES_POR_DEFECTO 
            AND YEAR(FECHA_LLEGADA) = $YEAR_ACTUAL";

            $result = mysqli_query($conn, $sql);

            $VALOR = $result->fetch_array()['TOTAL'] ?? 0;

            $VALOR = intval($VALOR);

            array_push($VALOR_MENSUAL_COMPLETADAS, $VALOR);

            $MES_POR_DEFECTO++;
        }
    }



    $respuesta = [
        "datos" => $VALOR_MENSUAL_COMPLETADAS,
    ];

    echo json_encode($respuesta);
}

//==========================================================================================================================
//GRAFICA DE PETCIONES ANUALES RECHAZADAS POR MES
//==========================================================================================================================

if (isset($_POST['anualDatosRechazadasSend'])) {

    $yearGot = $_POST['yearSend'];

    $MES_POR_DEFECTO = 1;

    $VALOR_MENSUAL_RECHAZADAS = array();

    if ($yearGot != '') {
        while ($MES_POR_DEFECTO <= 12) {

            $sql = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
            INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
            WHERE e.estatus = 'Rechazado' AND MONTH(FECHA_LLEGADA) = $MES_POR_DEFECTO 
            AND YEAR(FECHA_LLEGADA) = $yearGot";

            $result = mysqli_query($conn, $sql);

            $VALOR = $result->fetch_array()['TOTAL'] ?? 0;

            $VALOR = intval($VALOR);

            array_push($VALOR_MENSUAL_RECHAZADAS, $VALOR);

            $MES_POR_DEFECTO++;
        }
    } else {
        while ($MES_POR_DEFECTO <= 12) {

            $sql = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
            INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
            WHERE e.estatus = 'Rechazado' AND MONTH(FECHA_LLEGADA) = $MES_POR_DEFECTO 
            AND YEAR(FECHA_LLEGADA) = $YEAR_ACTUAL";

            $result = mysqli_query($conn, $sql);

            $VALOR = $result->fetch_array()['TOTAL'] ?? 0;

            $VALOR = intval($VALOR);

            array_push($VALOR_MENSUAL_RECHAZADAS, $VALOR);

            $MES_POR_DEFECTO++;
        }
    }



    $respuesta = [
        "datos" => $VALOR_MENSUAL_RECHAZADAS,
    ];

    echo json_encode($respuesta);
}

//==========================================================================================================================
//GRAFICA DE PETCIONES ANUALES MIX / RECIBIDAS / COMPLETADAS / RECHAZADAS
//==========================================================================================================================

if (isset($_POST['anualMixSend'])) {

    $yearGot = $_POST['yearSend'];

    if ($yearGot != '') {
        //DATOS REGISTRADOS
        $MES_POR_DEFECTO = 1;

        $VALOR_MENSUAL = array();

        while ($MES_POR_DEFECTO <= 12) {

            $sql = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion WHERE MONTH(FECHA_LLEGADA) = $MES_POR_DEFECTO 
            AND YEAR(FECHA_LLEGADA) = $yearGot";

            $result = mysqli_query($conn, $sql);

            $VALOR = $result->fetch_array()['TOTAL'] ?? 0;

            $VALOR = intval($VALOR);

            array_push($VALOR_MENSUAL, $VALOR);

            $MES_POR_DEFECTO++;
        }


        //DATOS COMPLETADOS
        $MES_POR_DEFECTO = 1;

        $VALOR_MENSUAL_COMPLETADAS = array();

        while ($MES_POR_DEFECTO <= 12) {

            $sql = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
        INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
        WHERE e.estatus = 'Completado' AND MONTH(FECHA_LLEGADA) = $MES_POR_DEFECTO 
        AND YEAR(FECHA_LLEGADA) = $yearGot";

            $result = mysqli_query($conn, $sql);

            $VALOR = $result->fetch_array()['TOTAL'] ?? 0;

            $VALOR = intval($VALOR);

            array_push($VALOR_MENSUAL_COMPLETADAS, $VALOR);

            $MES_POR_DEFECTO++;
        }

        //DATOS RECHAZADOS
        $MES_POR_DEFECTO = 1;

        $VALOR_MENSUAL_RECHAZADAS = array();

        while ($MES_POR_DEFECTO <= 12) {

            $sql = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
        INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
        WHERE e.estatus = 'Rechazado' AND MONTH(FECHA_LLEGADA) = $MES_POR_DEFECTO 
        AND YEAR(FECHA_LLEGADA) = $yearGot";

            $result = mysqli_query($conn, $sql);

            $VALOR = $result->fetch_array()['TOTAL'] ?? 0;

            $VALOR = intval($VALOR);

            array_push($VALOR_MENSUAL_RECHAZADAS, $VALOR);

            $MES_POR_DEFECTO++;
        }
    } else {
        //DATOS REGISTRADOS
        $MES_POR_DEFECTO = 1;

        $VALOR_MENSUAL = array();

        while ($MES_POR_DEFECTO <= 12) {

            $sql = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion WHERE MONTH(FECHA_LLEGADA) = $MES_POR_DEFECTO 
            AND YEAR(FECHA_LLEGADA) = $YEAR_ACTUAL";

            $result = mysqli_query($conn, $sql);

            $VALOR = $result->fetch_array()['TOTAL'] ?? 0;

            $VALOR = intval($VALOR);

            array_push($VALOR_MENSUAL, $VALOR);

            $MES_POR_DEFECTO++;
        }


        //DATOS COMPLETADOS
        $MES_POR_DEFECTO = 1;

        $VALOR_MENSUAL_COMPLETADAS = array();

        while ($MES_POR_DEFECTO <= 12) {

            $sql = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
        INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
        WHERE e.estatus = 'Completado' AND MONTH(FECHA_LLEGADA) = $MES_POR_DEFECTO 
        AND YEAR(FECHA_LLEGADA) = $YEAR_ACTUAL";

            $result = mysqli_query($conn, $sql);

            $VALOR = $result->fetch_array()['TOTAL'] ?? 0;

            $VALOR = intval($VALOR);

            array_push($VALOR_MENSUAL_COMPLETADAS, $VALOR);

            $MES_POR_DEFECTO++;
        }

        //DATOS RECHAZADOS
        $MES_POR_DEFECTO = 1;

        $VALOR_MENSUAL_RECHAZADAS = array();

        while ($MES_POR_DEFECTO <= 12) {

            $sql = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
        INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
        WHERE e.estatus = 'Rechazado' AND MONTH(FECHA_LLEGADA) = $MES_POR_DEFECTO 
        AND YEAR(FECHA_LLEGADA) = $YEAR_ACTUAL";

            $result = mysqli_query($conn, $sql);

            $VALOR = $result->fetch_array()['TOTAL'] ?? 0;

            $VALOR = intval($VALOR);

            array_push($VALOR_MENSUAL_RECHAZADAS, $VALOR);

            $MES_POR_DEFECTO++;
        }
    }



    $respuesta = [
        "datosRegistrados" => $VALOR_MENSUAL,
        "datosCompletados" => $VALOR_MENSUAL_COMPLETADAS,
        "datosRechazados" => $VALOR_MENSUAL_RECHAZADAS,
    ];

    echo json_encode($respuesta);
}

//==========================================================================================================================
//GRAFICA DE PETCIONES POR LABORATORIO POR RANGO DE FECHAS
//==========================================================================================================================

if (isset($_POST['laboratorioDatosFechasSend'])) {


    $LAB = $_POST['laboratorioSend'];
    $FECHA_INICIO = $_POST['fechaInicioSend'];
    $FECHA_FINAL = $_POST['fechaFinalSend'];

    $DATOS_NUMERICOS = array();

    //OBTENIENDO LA CANTIDAD DE PENDIENTES
    $query = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
    INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO 
    INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
    WHERE l.ID_LABORATORIO = $LAB and e.ESTATUS = 'Pendiente' and FECHA_LLEGADA BETWEEN '$FECHA_INICIO' and '$FECHA_FINAL'";

    $result = $conn->query($query);

    $PENDIENTE = $result->fetch_array()['TOTAL'] ?? 0;

    array_push($DATOS_NUMERICOS, $PENDIENTE);

    //OBTENIENDO LA CANTIDAD DE DESARROLLO
    $query = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
    INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO 
    INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
    WHERE l.ID_LABORATORIO = $LAB and e.ESTATUS = 'Desarrollo' and FECHA_LLEGADA BETWEEN '$FECHA_INICIO' and '$FECHA_FINAL'";

    $result = $conn->query($query);

    $DESARROLLO = $result->fetch_array()['TOTAL'] ?? 0;

    array_push($DATOS_NUMERICOS, $DESARROLLO);


    //OBTENIENDO LA CANTIDAD DE COMPLETADOS
    $query = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
    INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO 
    INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
    WHERE l.ID_LABORATORIO = $LAB and e.ESTATUS = 'Completado' and FECHA_LLEGADA BETWEEN '$FECHA_INICIO' and '$FECHA_FINAL'";

    $result = $conn->query($query);

    $COMPLETADO = $result->fetch_array()['TOTAL'] ?? 0;

    array_push($DATOS_NUMERICOS, $COMPLETADO);

    //OBTENIENDO LA CANTIDAD DE RECHAZADOS
    $query = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
    INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO 
    INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
    WHERE l.ID_LABORATORIO = $LAB and e.ESTATUS = 'Rechazado' and FECHA_LLEGADA BETWEEN '$FECHA_INICIO' and '$FECHA_FINAL'";

    $result = $conn->query($query);

    $RECHAZADO = $result->fetch_array()['TOTAL'] ?? 0;

    array_push($DATOS_NUMERICOS, $RECHAZADO);

    //OBTENIENDO LA CANTIDAD DE RECIBIDAS
    $query = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
    INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO 
    INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
    WHERE l.ID_LABORATORIO = $LAB and FECHA_LLEGADA BETWEEN '$FECHA_INICIO' and '$FECHA_FINAL'";

    $result = $conn->query($query);

    $RECIBIDAS = $result->fetch_array()['TOTAL'] ?? 0;

    //array_push($DATOS_NUMERICOS, $RECIBIDAS);

    $respuesta = [
        "datos" => $DATOS_NUMERICOS,
        "datosPendientes" => $PENDIENTE,
        "datosDesarrollo" => $DESARROLLO,
        "datosCompletados" => $COMPLETADO,
        "datosRechazados" => $RECHAZADO,
        "datosTotal" => $RECIBIDAS,
    ];

    echo json_encode($respuesta);
}

//==========================================================================================================================
//GRAFICA DE PETCIONES POR LABORATORIO ANUALES RECIBIDAS POR MES
//==========================================================================================================================

if (isset($_POST['laboratorioDatosSend'])) {

    $LAB = $_POST['laboratorioSend'];
    $yearGot = $_POST['yearSend'];

    $MES_POR_DEFECTO = 1;

    $VALOR_LAB_RECIBIDAS = array();

    //LAB PETICIONES RECIBIDAS
    while ($MES_POR_DEFECTO <= 12) {

        $sql = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO 
        WHERE l.ID_LABORATORIO = $LAB AND MONTH(FECHA_LLEGADA) = $MES_POR_DEFECTO AND YEAR(FECHA_LLEGADA) = $yearGot";

        $result = mysqli_query($conn, $sql);

        $VALOR = $result->fetch_array()['TOTAL'] ?? 0;

        $VALOR = intval($VALOR);

        array_push($VALOR_LAB_RECIBIDAS, $VALOR);

        $MES_POR_DEFECTO++;
    }

    $MES_POR_DEFECTO = 1;

    $VALOR_LAB_COMPLETADAS = array();

    //LAB PETICIONES COMPLETADAS
    while ($MES_POR_DEFECTO <= 12) {

        $sql = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
        INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO 
        WHERE e.estatus = 'Completado' AND l.ID_LABORATORIO = $LAB 
        AND MONTH(FECHA_LLEGADA) = $MES_POR_DEFECTO AND YEAR(FECHA_LLEGADA) = $yearGot";

        $result = mysqli_query($conn, $sql);

        $VALOR = $result->fetch_array()['TOTAL'] ?? 0;

        $VALOR = intval($VALOR);

        array_push($VALOR_LAB_COMPLETADAS, $VALOR);

        $MES_POR_DEFECTO++;
    }

    $MES_POR_DEFECTO = 1;

    $VALOR_LAB_RECHAZADAS = array();

    //LAB PETICIONES RECHAZADAS
    while ($MES_POR_DEFECTO <= 12) {

        $sql = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
        INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO 
        WHERE e.estatus = 'Rechazado' AND l.ID_LABORATORIO = $LAB 
        AND MONTH(FECHA_LLEGADA) = $MES_POR_DEFECTO AND YEAR(FECHA_LLEGADA) = $yearGot";

        $result = mysqli_query($conn, $sql);

        $VALOR = $result->fetch_array()['TOTAL'] ?? 0;

        $VALOR = intval($VALOR);

        array_push($VALOR_LAB_RECHAZADAS, $VALOR);

        $MES_POR_DEFECTO++;
    }


    $respuesta = [
        "datos" => $VALOR_LAB_RECIBIDAS,
        "datosCompletados" => $VALOR_LAB_COMPLETADAS,
        "datosRechazados" => $VALOR_LAB_RECHAZADAS
    ];

    echo json_encode($respuesta);
}

//==========================================================================================================================
//GRAFICA DE PETCIONES POR LABORATORIO ANUALES RECIBIDAS
//==========================================================================================================================

if (isset($_POST['laboratorioMixSend'])) {

    //RECIBIDAS
    if (isset($_POST['laboRecibidasSend'])) {


        $yearGot = $_POST['yearSend']; //string

        $laboratorio = $_POST['laboratorioSend'];

        $MES_POR_DEFECTO = 1;

        $VALOR_MENSUAL = array();

        while ($MES_POR_DEFECTO <= 12) {

            $sql = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion 
            WHERE `ID_LABORATORIO`= $laboratorio AND MONTH(FECHA_LLEGADA) = $MES_POR_DEFECTO 
            AND YEAR(FECHA_LLEGADA) = $yearGot";

            $result = mysqli_query($conn, $sql);

            $VALOR = $result->fetch_array()['TOTAL'] ?? 0;

            $VALOR = intval($VALOR);

            array_push($VALOR_MENSUAL, $VALOR);

            $MES_POR_DEFECTO++;
        }

        $respuesta = [
            "datos" => $VALOR_MENSUAL,
        ];

        echo json_encode($respuesta);
    }

    //COMPLETAS
    if (isset($_POST['laboratorioCompletadasSend'])) {


        $yearGot = $_POST['yearSend']; //string

        $laboratorio = $_POST['laboratorioSend'];

        $MES_POR_DEFECTO = 1;

        $VALOR_MENSUAL = array();

        while ($MES_POR_DEFECTO <= 12) {

            $sql = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p
            INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
            WHERE e.estatus = 'Completado' and `ID_LABORATORIO`= $laboratorio 
            AND MONTH(FECHA_LLEGADA) = $MES_POR_DEFECTO 
            AND YEAR(FECHA_LLEGADA) = $yearGot";

            $result = mysqli_query($conn, $sql);

            $VALOR = $result->fetch_array()['TOTAL'] ?? 0;

            $VALOR = intval($VALOR);

            array_push($VALOR_MENSUAL, $VALOR);

            $MES_POR_DEFECTO++;
        }

        $respuesta = [
            "datos" => $VALOR_MENSUAL,
        ];

        echo json_encode($respuesta);
    }

    //RECHAZADAS
    if (isset($_POST['laboratorioRechazadoSend'])) {


        $yearGot = $_POST['yearSend']; //string

        $laboratorio = $_POST['laboratorioSend'];

        $MES_POR_DEFECTO = 1;

        $VALOR_MENSUAL = array();

        while ($MES_POR_DEFECTO <= 12) {

            $sql = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p
            INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
            WHERE e.estatus = 'Rechazado' and `ID_LABORATORIO`= $laboratorio 
            AND MONTH(FECHA_LLEGADA) = $MES_POR_DEFECTO 
            AND YEAR(FECHA_LLEGADA) = $yearGot";

            $result = mysqli_query($conn, $sql);

            $VALOR = $result->fetch_array()['TOTAL'] ?? 0;

            $VALOR = intval($VALOR);

            array_push($VALOR_MENSUAL, $VALOR);

            $MES_POR_DEFECTO++;
        }

        $respuesta = [
            "datos" => $VALOR_MENSUAL,
        ];

        echo json_encode($respuesta);
    }
}

//==========================================================================================================================
//CODIGO PARA GRAFICA POR DESARROLLADOR
//==========================================================================================================================
if (isset($_POST['graficaDesarrolladorSend'])) {

    $DESARROLLADOR = $_POST['desarrolladorSend'];
    $FECHA_INICIO = $_POST['fechaInicioSend'];
    $FECHA_FINAL = $_POST['fechaFinalSend'];

    $sql = "SELECT `ESTATUS` FROM `estatus` WHERE 1 ORDER BY ESTATUS ASC";

    $result = mysqli_query($conn, $sql);

    $NOMBRES_ESTATUS = array();

    $DATOS_NUMERICOS = array();

    //OBTENCIÓN DE LOS NOMBRES DE LOS ESTATUS
    while ($row = mysqli_fetch_assoc($result)) {

        array_push($NOMBRES_ESTATUS, $row['ESTATUS']);
    }


    //OBTENIENDO LA CANTIDAD DE COMPLETADOS
    $query = "SELECT COUNT(ID_PETICION) AS TOTAL 
    FROM peticion AS p LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
    WHERE d.ID_DESARROLLADOR = $DESARROLLADOR and e.ESTATUS = 'Completado' and FECHA_LLEGADA BETWEEN '$FECHA_INICIO' and '$FECHA_FINAL'";

    $result = $conn->query($query);

    $COMPLETADO = $result->fetch_array()['TOTAL'] ?? 0;

    array_push($DATOS_NUMERICOS, $COMPLETADO);

    //OBTENIENDO LA CANTIDAD DE DESARROLLOS
    $query = "SELECT COUNT(ID_PETICION) AS TOTAL 
    FROM peticion AS p LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
    WHERE d.ID_DESARROLLADOR = $DESARROLLADOR and e.ESTATUS = 'Desarrollo' and FECHA_LLEGADA BETWEEN '$FECHA_INICIO' and '$FECHA_FINAL'";

    $result = $conn->query($query);

    $DESARROLLO = $result->fetch_array()['TOTAL'] ?? 0;

    array_push($DATOS_NUMERICOS, $DESARROLLO);


    //OBTENIENDO LA CANTIDAD DE PENDIENTES
    $query = "SELECT COUNT(ID_PETICION) AS TOTAL 
    FROM peticion AS p LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
    WHERE d.ID_DESARROLLADOR = $DESARROLLADOR and e.ESTATUS = 'Pendiente' and FECHA_LLEGADA BETWEEN '$FECHA_INICIO' and '$FECHA_FINAL'";

    $result = $conn->query($query);

    $PENDIENTE = $result->fetch_array()['TOTAL'] ?? 0;

    array_push($DATOS_NUMERICOS, $PENDIENTE);


    //OBTENIENDO LA CANTIDAD DE RECHAZADOS
    $query = "SELECT COUNT(ID_PETICION) AS TOTAL 
    FROM peticion AS p LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
    WHERE d.ID_DESARROLLADOR = $DESARROLLADOR and e.ESTATUS = 'Rechazado' and FECHA_LLEGADA BETWEEN '$FECHA_INICIO' and '$FECHA_FINAL'";

    $result = $conn->query($query);

    $RECHAZADO = $result->fetch_array()['TOTAL'] ?? 0;

    array_push($DATOS_NUMERICOS, $RECHAZADO);

    //OBTENIENDO EL TOTAL SIN IMPORTAR EL ESTATUS
    $query = "SELECT COUNT(ID_PETICION) AS TOTAL 
    FROM peticion AS p LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
    WHERE d.ID_DESARROLLADOR = $DESARROLLADOR and FECHA_LLEGADA BETWEEN '$FECHA_INICIO' and '$FECHA_FINAL'";

    $result = $conn->query($query);

    $TOTAL = $result->fetch_array()['TOTAL'] ?? 0;

    $respuesta = [
        "datos" => $NOMBRES_ESTATUS,
        "datosNumericos" => $DATOS_NUMERICOS,
        "datosCompletados" => $COMPLETADO,
        "datosPendientes" => $PENDIENTE,
        "datosRechazados" => $RECHAZADO,
        "datosDesarrollo" => $DESARROLLO,
        "datosTotal" => $TOTAL,
    ];

    echo json_encode($respuesta);
}

//==========================================================================================================================
//CODIGO PARA GRAFICA POR AÑO DESARROLLADOR
//==========================================================================================================================
if (isset($_POST['graficaPorYearSend'])) {

    $yearGot = $_POST['yearSend'];

    $DESARROLLADOR = $_POST['desarrolladorSend'];

    $MES_POR_DEFECTO = 1;

    $VALOR_MENSUAL_COMPLETADAS = array();

    while ($MES_POR_DEFECTO <= 12) {

        $sql = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
        INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
        WHERE e.estatus = 'Completado'AND ID_DESARROLLADOR = $DESARROLLADOR 
        AND MONTH(FECHA_LLEGADA) = $MES_POR_DEFECTO 
        AND YEAR(FECHA_LLEGADA) = $yearGot";

        $result = mysqli_query($conn, $sql);

        $VALOR = $result->fetch_array()['TOTAL'] ?? 0;

        $VALOR = intval($VALOR);

        array_push($VALOR_MENSUAL_COMPLETADAS, $VALOR);

        $MES_POR_DEFECTO++;
    }

    $respuesta = [
        "datos" => $VALOR_MENSUAL_COMPLETADAS,
    ];

    echo json_encode($respuesta);
}

//==========================================================================================================================
//CODIGO PARA GRAFICA POR DIA POR MES
//==========================================================================================================================
if (isset($_POST['desarrolladorDiasMesSend'])) {

    $yearGot = $_POST['yearSend'];
    $mesGot = $_POST['mesSend'];
    $desGot = $_POST['laboratorioSend'];

    $DIAS_DEL_MES = cal_days_in_month(CAL_GREGORIAN, intval($mesGot), intval($yearGot));

    $DIA_INICIO = 1;

    $DIAS_DEL_MES_GRAFICA = array();

    while ($DIA_INICIO <= $DIAS_DEL_MES) {

        array_push($DIAS_DEL_MES_GRAFICA, $DIA_INICIO);

        $DIA_INICIO++;
    }

    $DIA_INICIO = 1;

    $CONT = 1;

    $DIAS_DEL_MES_GRAFICA_VALORES = array();

    while ($CONT <= $DIAS_DEL_MES) {

        if ($DIA_INICIO <= 9) {
            $DIA_INICIO = "0" . $DIA_INICIO;
        }

        $FECHA = "$yearGot-$mesGot-$DIA_INICIO";

        $sql = "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
        INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
        WHERE FECHA_LLEGADA LIKE '$FECHA%' 
        AND e.estatus = 'Completado'AND ID_DESARROLLADOR = $desGot";

        $result = mysqli_query($conn, $sql);

        $VALOR = $result->fetch_array()['TOTAL'] ?? 0;

        array_push($DIAS_DEL_MES_GRAFICA_VALORES, $VALOR);

        $CONT++;
        $DIA_INICIO++;
    }


    $respuesta = [
        "dias" => $DIAS_DEL_MES_GRAFICA,
        "valores" => $DIAS_DEL_MES_GRAFICA_VALORES,
    ];

    echo json_encode($respuesta);
}

//==========================================================================================================================
//CODIGO PARA GRAFICA COMPARACION DESARROLLADORES
//==========================================================================================================================
if (isset($_POST['desComoaracionSend'])) {

    $FECHA_INICIO = $_POST['fechaInicioSend'];

    $FECHA_FINAL = $_POST['fechaFinalSend'];

    $FECHA_INICIO .= " 00:00:00.000";

    $FECHA_FINAL .= " 23:59:59.999";

    $VALORES_ARRAY_DES = $_POST['valores_array_send'];

    $NOM_DES = array();

    $CONT = 0;

    //==========================================================================================================================
    //SE OBTIENE LOS NOMBRES DE LOS DESARROLLADORES POR EL (LOS) ID RECIBIDOS
    //==========================================================================================================================
    while ($CONT <= count($VALORES_ARRAY_DES) - 1) {

        $ID_DES = $VALORES_ARRAY_DES[$CONT];

        $stmt = $conn->prepare(
            "SELECT NOMBRE FROM desarrollador WHERE ID_DESARROLLADOR = ?"
        );

        $stmt->bind_param("i", $ID_DES);

        $stmt->execute();

        $result = $stmt->get_result();

        $data = $result->fetch_assoc();

        $stmt->close();

        $VALOR = $data['NOMBRE'];

        array_push($NOM_DES, $VALOR);

        $CONT++;
    }

    //==========================================================================================================================
    //SE OBTIENE LOS NUMEROS DE PETICIONES COMPLETAS PARA CADA DESARROLLADOR
    //==========================================================================================================================
    $VAL_DES_COMPLETE = array();

    $CONT = 0;

    while ($CONT <= count($VALORES_ARRAY_DES) - 1) {


        $ID_DES = $VALORES_ARRAY_DES[$CONT];

        $stmt = $conn->prepare(
            "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p
            LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR 
            INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
            WHERE e.estatus = 'Completado' AND d.ID_DESARROLLADOR  = ? 
            AND FECHA_LLEGADA BETWEEN ? and ?"
        );

        $stmt->bind_param("iss", $ID_DES, $FECHA_INICIO, $FECHA_FINAL);

        $stmt->execute();

        $result = $stmt->get_result();

        $data = $result->fetch_assoc();

        $stmt->close();

        $VALOR = $data['TOTAL'];

        array_push($VAL_DES_COMPLETE, $VALOR);

        $CONT++;
    }

    //==========================================================================================================================
    //SE OBTIENE LOS NUMEROS DE PETICIONES RECHAZADAS PARA CADA DESARROLLADOR
    //==========================================================================================================================
    $VAL_DES_RECHAZADAS = array();

    $CONT = 0;

    while ($CONT <= count($VALORES_ARRAY_DES) - 1) {

        $ID_DES = $VALORES_ARRAY_DES[$CONT];

        $stmt = $conn->prepare(
            "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p
            LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR 
            INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
            WHERE e.estatus = 'Rechazado' AND d.ID_DESARROLLADOR  = ? 
            AND FECHA_LLEGADA BETWEEN ? and ?"
        );

        $stmt->bind_param("iss", $ID_DES, $FECHA_INICIO, $FECHA_FINAL);

        $stmt->execute();

        $result = $stmt->get_result();

        $data = $result->fetch_assoc();

        $stmt->close();

        $VALOR = $data['TOTAL'];

        array_push($VAL_DES_RECHAZADAS, $VALOR);

        $CONT++;
    }


    //==========================================================================================================================
    //SE OBTIENE LOS NUMEROS DE PETICIONES PENDIENTES PARA CADA DESARROLLADOR
    //==========================================================================================================================
    $VAL_DES_PENDIENTES = array();

    $CONT = 0;

    while ($CONT <= count($VALORES_ARRAY_DES) - 1) {

        $ID_DES = $VALORES_ARRAY_DES[$CONT];

        $stmt = $conn->prepare(
            "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p
            LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR 
            INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
            WHERE e.estatus = 'Pendiente' AND d.ID_DESARROLLADOR  = ? AND FECHA_LLEGADA 
            BETWEEN ? AND ?"
        );

        $stmt->bind_param("iss", $ID_DES, $FECHA_INICIO, $FECHA_FINAL);

        $stmt->execute();

        $result = $stmt->get_result();

        $data = $result->fetch_assoc();

        $stmt->close();

        $VALOR = $data['TOTAL'];

        array_push($VAL_DES_PENDIENTES, $VALOR);

        $CONT++;
    }

    //==========================================================================================================================
    //SE OBTIENE LOS NUMEROS DE PETICIONES EN DESARROLLO PARA CADA DESARROLLADOR
    //==========================================================================================================================
    $VAL_DES_DESARROLLO = array();

    $CONT = 0;

    while ($CONT <= count($VALORES_ARRAY_DES) - 1) {

        $ID_DES = $VALORES_ARRAY_DES[$CONT];

        $stmt = $conn->prepare(
            "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p
            LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR 
            INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
            WHERE e.estatus = 'Desarrollo' AND d.ID_DESARROLLADOR  = ? AND FECHA_LLEGADA 
            BETWEEN ? and ?"
        );

        $stmt->bind_param("iss", $ID_DES, $FECHA_INICIO, $FECHA_FINAL);

        $stmt->execute();

        $result = $stmt->get_result();

        $data = $result->fetch_assoc();

        $stmt->close();

        $VALOR = $data['TOTAL'];

        array_push($VAL_DES_DESARROLLO, $VALOR);

        $CONT++;
    }


    //==========================================================================================================================
    //SE OBTIENE LOS NUMEROS DE PETICIONES TOTALES PARA CADA DESARROLLADOR
    //==========================================================================================================================
    $VAL_DES_TOTAL = array();

    $CONT = 0;

    while ($CONT <= count($VALORES_ARRAY_DES) - 1) {

        $ID_DES = $VALORES_ARRAY_DES[$CONT];

        $stmt = $conn->prepare(
            "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p
            LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR 
            WHERE d.ID_DESARROLLADOR  = ? AND FECHA_LLEGADA BETWEEN ? and ?"
        );

        $stmt->bind_param("iss", $ID_DES, $FECHA_INICIO, $FECHA_FINAL);

        $stmt->execute();

        $result = $stmt->get_result();

        $data = $result->fetch_assoc();

        $stmt->close();

        $VALOR = $data['TOTAL'];

        array_push($VAL_DES_TOTAL, $VALOR);

        $CONT++;
    }

    //==========================================================================================================================
    //EXPORTACIÓN
    //==========================================================================================================================

    $respuesta = [
        "nombres" => $NOM_DES,
        "valoresCompletos" => $VAL_DES_COMPLETE,
        "valoresRechazados" => $VAL_DES_RECHAZADAS,
        "valoresPendientes" => $VAL_DES_PENDIENTES,
        "valoresDesarrollo" => $VAL_DES_DESARROLLO,
        "valoresTotal" => $VAL_DES_TOTAL,
    ];

    echo json_encode($respuesta);
}
