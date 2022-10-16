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
        "datosTotal" => $TOTAL,
    ];

    echo json_encode($respuesta);
}
