<?php
include 'connectionController.php';

$conn = connect();

date_default_timezone_set('America/Chihuahua');
$MES_ACTUAL = date('m');
$YEAR_ACTUAL = date('Y');
$MES_POR_DEFECTO = 1;

//==========================================================================================================================
//GRAFICA DE PETCIONES ACEPTADAS POR DESARROLLADOR -Re
//==========================================================================================================================

if (isset($_POST['desarrolladorDatosSend'])) {

    $stmt = $conn->prepare(
        "SELECT `NOMBRE` FROM `desarrollador` WHERE `OCULTO` = 0 ORDER BY NOMBRE ASC"
    );

    $stmt->execute();

    $result = $stmt->get_result();

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

        $FECHA_INICIO .= " 00:00:00.000";

        $FECHA_FINAL .= " 23:59:59.999";

        while ($CONTADOR < $CANTIDAD) {

            $PERSONA = $NOMBRES_DESARROLLADORES[$CONTADOR];

            $stmt = $conn->prepare(
                "SELECT COUNT(ID_PETICION) AS TOTAL 
                FROM peticion AS p LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR 
                WHERE d.nombre = ? and FECHA_LLEGADA BETWEEN ? and ?"
            );

            $stmt->bind_param("sss", $PERSONA, $FECHA_INICIO, $FECHA_FINAL);

            $stmt->execute();

            $result = $stmt->get_result();

            $data = $result->fetch_assoc();

            $stmt->close();

            $VALOR = $data['TOTAL'];

            array_push($DESARROLLOS, intval($VALOR));


            $CONTADOR++;
        }
    } else {

        while ($CONTADOR < $CANTIDAD) {

            $PERSONA = $NOMBRES_DESARROLLADORES[$CONTADOR];

            $stmt = $conn->prepare(
                "SELECT COUNT(ID_PETICION) AS TOTAL 
                FROM peticion AS p LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR 
                WHERE d.nombre = ? AND MONTH(FECHA_LLEGADA) = ? AND YEAR(FECHA_LLEGADA) = ?"
            );

            $stmt->bind_param("sii", $PERSONA, $MES_ACTUAL, $YEAR_ACTUAL);

            $stmt->execute();

            $result = $stmt->get_result();

            $data = $result->fetch_assoc();

            $stmt->close();

            $VALOR = $data['TOTAL'];

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
//GRAFICA DE PETCIONES REGISTRADAS POR SOPORTE -Re
//==========================================================================================================================

if (isset($_POST['soporteDatosSend'])) {

    $stmt = $conn->prepare(
        "SELECT `NOMBRE` FROM `soporte` WHERE `OCULTO` = 0 ORDER BY NOMBRE ASC"
    );

    $stmt->execute();

    $result = $stmt->get_result();

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

        $FECHA_INICIO .= " 00:00:00.000";

        $FECHA_FINAL .= " 23:59:59.999";

        while ($CONTADOR < $CANTIDAD) {

            $PERSONA = $NOMBRES_SOPORTES[$CONTADOR];

            $stmt = $conn->prepare(
                "SELECT COUNT(ID_PETICION) AS TOTAL 
                FROM peticion AS p 
                INNER JOIN soporte AS s ON p.ID_SOPORTE = s.ID_SOPORTE WHERE s.nombre = ?
                and FECHA_LLEGADA BETWEEN ? and ?"
            );

            $stmt->bind_param("sss", $PERSONA, $FECHA_INICIO, $FECHA_FINAL);

            $stmt->execute();

            $result = $stmt->get_result();

            $data = $result->fetch_assoc();

            $stmt->close();

            $VALOR = $data['TOTAL'];

            array_push($VALOR_SOPORTE, intval($VALOR));

            $CONTADOR++;
        }
    } else {

        while ($CONTADOR < $CANTIDAD) {

            $PERSONA = $NOMBRES_SOPORTES[$CONTADOR];

            $stmt = $conn->prepare(
                "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
                INNER JOIN soporte AS s ON p.ID_SOPORTE = s.ID_SOPORTE WHERE s.nombre = ? 
                AND MONTH(FECHA_LLEGADA) = ? AND YEAR(FECHA_LLEGADA) = ?"
            );

            $stmt->bind_param("sii", $PERSONA, $MES_ACTUAL, $YEAR_ACTUAL);

            $stmt->execute();

            $result = $stmt->get_result();

            $data = $result->fetch_assoc();

            $stmt->close();

            $VALOR = $data['TOTAL'];

            array_push($VALOR_SOPORTE, intval($VALOR));

            $CONTADOR++;
        }
    }

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

            $stmt = $conn->prepare(
                "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion WHERE MONTH(FECHA_LLEGADA) = ? 
                AND YEAR(FECHA_LLEGADA) = ?"
            );

            $stmt->bind_param("ii", $MES_POR_DEFECTO, $yearGot);

            $stmt->execute();

            $result = $stmt->get_result();

            $data = $result->fetch_assoc();

            $stmt->close();

            $VALOR = $data['TOTAL'];

            array_push($VALOR_MENSUAL, intval($VALOR));

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

            $stmt = $conn->prepare(
                "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
                INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
                WHERE e.estatus = 'Completado' AND MONTH(FECHA_LLEGADA) = ? 
                AND YEAR(FECHA_LLEGADA) = ?"
            );

            $stmt->bind_param("ii", $MES_POR_DEFECTO, $yearGot);

            $stmt->execute();

            $result = $stmt->get_result();

            $data = $result->fetch_assoc();

            $stmt->close();

            $VALOR = $data['TOTAL'];

            array_push($VALOR_MENSUAL_COMPLETADAS, intval($VALOR));

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

            $stmt = $conn->prepare(
                "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
                INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
                WHERE e.estatus = 'Rechazado' AND MONTH(FECHA_LLEGADA) = ? 
                AND YEAR(FECHA_LLEGADA) = ?"
            );

            $stmt->bind_param("ii", $MES_POR_DEFECTO, $yearGot);

            $stmt->execute();

            $result = $stmt->get_result();

            $data = $result->fetch_assoc();

            $stmt->close();

            $VALOR = $data['TOTAL'];

            array_push($VALOR_MENSUAL_RECHAZADAS, intval($VALOR));

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

            $stmt = $conn->prepare(
                "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion WHERE MONTH(FECHA_LLEGADA) = ? 
                 AND YEAR(FECHA_LLEGADA) = ?"
            );

            $stmt->bind_param("ii", $MES_POR_DEFECTO, $yearGot);

            $stmt->execute();

            $result = $stmt->get_result();

            $data = $result->fetch_assoc();

            $stmt->close();

            $VALOR = $data['TOTAL'];

            array_push($VALOR_MENSUAL, intval($VALOR));

            $MES_POR_DEFECTO++;
        }


        //DATOS COMPLETADOS
        $MES_POR_DEFECTO = 1;

        $VALOR_MENSUAL_COMPLETADAS = array();

        while ($MES_POR_DEFECTO <= 12) {

            $stmt = $conn->prepare(
                "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
                INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
                WHERE e.estatus = 'Completado' AND MONTH(FECHA_LLEGADA) = ? 
                AND YEAR(FECHA_LLEGADA) = ?"
            );

            $stmt->bind_param("ii", $MES_POR_DEFECTO, $yearGot);

            $stmt->execute();

            $result = $stmt->get_result();

            $data = $result->fetch_assoc();

            $stmt->close();

            $VALOR = $data['TOTAL'];

            array_push($VALOR_MENSUAL_COMPLETADAS, intval($VALOR));

            $MES_POR_DEFECTO++;
        }

        //DATOS RECHAZADOS
        $MES_POR_DEFECTO = 1;

        $VALOR_MENSUAL_RECHAZADAS = array();

        while ($MES_POR_DEFECTO <= 12) {

            $stmt = $conn->prepare(
                "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
                INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
                WHERE e.estatus = 'Rechazado' AND MONTH(FECHA_LLEGADA) = ? 
                AND YEAR(FECHA_LLEGADA) = ?"
            );

            $stmt->bind_param("ii", $MES_POR_DEFECTO, $yearGot);

            $stmt->execute();

            $result = $stmt->get_result();

            $data = $result->fetch_assoc();

            $stmt->close();

            $VALOR = $data['TOTAL'];

            array_push($VALOR_MENSUAL_RECHAZADAS, intval($VALOR));

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

    $FECHA_INICIO .= " 00:00:00.000";

    $FECHA_FINAL .= " 23:59:59.999";

    $DATOS_NUMERICOS = array();

    //OBTENIENDO LA CANTIDAD DE PENDIENTES
    $stmt = $conn->prepare(
        "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
        INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO 
        INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
        WHERE l.ID_LABORATORIO = ? and e.ESTATUS = 'Pendiente' and FECHA_LLEGADA BETWEEN ? and ?"
    );

    $stmt->bind_param("iss", $LAB, $FECHA_INICIO, $FECHA_FINAL);

    $stmt->execute();

    $result = $stmt->get_result();

    $data = $result->fetch_assoc();

    $stmt->close();

    $PENDIENTE = $data['TOTAL'];

    array_push($DATOS_NUMERICOS,  intval($PENDIENTE));

    //OBTENIENDO LA CANTIDAD DE DESARROLLO
    $stmt = $conn->prepare(
        "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
        INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO 
        INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
        WHERE l.ID_LABORATORIO = ? and e.ESTATUS = 'En Desarrollo' and FECHA_LLEGADA BETWEEN ? and ?"
    );

    $stmt->bind_param("iss", $LAB, $FECHA_INICIO, $FECHA_FINAL);

    $stmt->execute();

    $result = $stmt->get_result();

    $data = $result->fetch_assoc();

    $stmt->close();

    $DESARROLLO = $data['TOTAL'];

    array_push($DATOS_NUMERICOS,  intval($DESARROLLO));


    //OBTENIENDO LA CANTIDAD DE COMPLETADOS
    $stmt = $conn->prepare(
        "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
        INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO 
        INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
        WHERE l.ID_LABORATORIO = ? and e.ESTATUS = 'Completado' and FECHA_LLEGADA BETWEEN ? and ?"
    );

    $stmt->bind_param("iss", $LAB, $FECHA_INICIO, $FECHA_FINAL);

    $stmt->execute();

    $result = $stmt->get_result();

    $data = $result->fetch_assoc();

    $stmt->close();

    $COMPLETADO = $data['TOTAL'];

    array_push($DATOS_NUMERICOS,  intval($COMPLETADO));

    //OBTENIENDO LA CANTIDAD DE RECHAZADOS
    $stmt = $conn->prepare(
        "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
        INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO 
        INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
        WHERE l.ID_LABORATORIO = ? and e.ESTATUS = 'Rechazado' and FECHA_LLEGADA BETWEEN ? and ?"
    );

    $stmt->bind_param("iss", $LAB, $FECHA_INICIO, $FECHA_FINAL);

    $stmt->execute();

    $result = $stmt->get_result();

    $data = $result->fetch_assoc();

    $stmt->close();

    $RECHAZADO = $data['TOTAL'];

    array_push($DATOS_NUMERICOS,  intval($RECHAZADO));

    //OBTENIENDO LA CANTIDAD DE RECIBIDAS
    $stmt = $conn->prepare(
        "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
        INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO 
        INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
        WHERE l.ID_LABORATORIO = ? and FECHA_LLEGADA BETWEEN ? and ?"
    );

    $stmt->bind_param("iss", $LAB, $FECHA_INICIO, $FECHA_FINAL);

    $stmt->execute();

    $result = $stmt->get_result();

    $data = $result->fetch_assoc();

    $stmt->close();

    $RECIBIDAS = $data['TOTAL'];

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

        $stmt = $conn->prepare(
            "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
            INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO 
            WHERE l.ID_LABORATORIO = ? AND MONTH(FECHA_LLEGADA) = ? AND YEAR(FECHA_LLEGADA) = ?"
        );

        $stmt->bind_param("iii", $LAB, $MES_POR_DEFECTO, $yearGot);

        $stmt->execute();

        $result = $stmt->get_result();

        $data = $result->fetch_assoc();

        $stmt->close();

        $VALOR = $data['TOTAL'];

        array_push($VALOR_LAB_RECIBIDAS, intval($VALOR));

        $MES_POR_DEFECTO++;
    }

    $MES_POR_DEFECTO = 1;

    $VALOR_LAB_COMPLETADAS = array();

    //LAB PETICIONES COMPLETADAS
    while ($MES_POR_DEFECTO <= 12) {

        $stmt = $conn->prepare(
            "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
            INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO 
            WHERE e.estatus = 'Completado' AND l.ID_LABORATORIO = ? 
            AND MONTH(FECHA_LLEGADA) = ? AND YEAR(FECHA_LLEGADA) = ?"
        );

        $stmt->bind_param("iii", $LAB, $MES_POR_DEFECTO, $yearGot);

        $stmt->execute();

        $result = $stmt->get_result();

        $data = $result->fetch_assoc();

        $stmt->close();

        $VALOR = $data['TOTAL'];

        array_push($VALOR_LAB_COMPLETADAS, intval($VALOR));

        $MES_POR_DEFECTO++;
    }

    $MES_POR_DEFECTO = 1;

    $VALOR_LAB_RECHAZADAS = array();

    //LAB PETICIONES RECHAZADAS
    while ($MES_POR_DEFECTO <= 12) {

        $stmt = $conn->prepare(
            "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
            INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO 
            WHERE e.estatus = 'Rechazado' AND l.ID_LABORATORIO = ? 
            AND MONTH(FECHA_LLEGADA) = ? AND YEAR(FECHA_LLEGADA) = ?"
        );

        $stmt->bind_param("iii", $LAB, $MES_POR_DEFECTO, $yearGot);

        $stmt->execute();

        $result = $stmt->get_result();

        $data = $result->fetch_assoc();

        $stmt->close();

        $VALOR = $data['TOTAL'];

        array_push($VALOR_LAB_RECHAZADAS, intval($VALOR));

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

            $stmt = $conn->prepare(
                "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion 
                WHERE `ID_LABORATORIO`= ? AND MONTH(FECHA_LLEGADA) = ? 
                AND YEAR(FECHA_LLEGADA) = ?"
            );

            $stmt->bind_param("iii", $laboratorio, $MES_POR_DEFECTO, $yearGot);

            $stmt->execute();

            $result = $stmt->get_result();

            $data = $result->fetch_assoc();

            $stmt->close();

            $VALOR = $data['TOTAL'];

            array_push($VALOR_MENSUAL, intval($VALOR));

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

            $stmt = $conn->prepare(
                "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p
                INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
                WHERE e.estatus = 'Completado' and `ID_LABORATORIO`= ? 
                AND MONTH(FECHA_LLEGADA) = ? 
                AND YEAR(FECHA_LLEGADA) = ?"
            );

            $stmt->bind_param("iii", $laboratorio, $MES_POR_DEFECTO, $yearGot);

            $stmt->execute();

            $result = $stmt->get_result();

            $data = $result->fetch_assoc();

            $stmt->close();

            $VALOR = $data['TOTAL'];

            array_push($VALOR_MENSUAL, intval($VALOR));

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

            $stmt = $conn->prepare(
                "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p
                INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
                WHERE e.estatus = 'Rechazado' and `ID_LABORATORIO`= ? 
                AND MONTH(FECHA_LLEGADA) = ? 
                AND YEAR(FECHA_LLEGADA) = ?"
            );

            $stmt->bind_param("iii", $laboratorio, $MES_POR_DEFECTO, $yearGot);

            $stmt->execute();

            $result = $stmt->get_result();

            $data = $result->fetch_assoc();

            $stmt->close();

            $VALOR = $data['TOTAL'];

            array_push($VALOR_MENSUAL, intval($VALOR));

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

    $FECHA_INICIO .= " 00:00:00.000";

    $FECHA_FINAL .= " 23:59:59.999";

    $stmt = $conn->prepare(
        "SELECT `ESTATUS` FROM `estatus` WHERE 1 ORDER BY ESTATUS ASC"
    );

    $stmt->execute();

    $result = $stmt->get_result();

    $NOMBRES_ESTATUS = array();

    $DATOS_NUMERICOS = array();

    //OBTENCIÓN DE LOS NOMBRES DE LOS ESTATUS
    while ($row = mysqli_fetch_assoc($result)) {

        array_push($NOMBRES_ESTATUS, $row['ESTATUS']);
    }


    //OBTENIENDO LA CANTIDAD DE COMPLETADOS
    $stmt = $conn->prepare(
        "SELECT COUNT(ID_PETICION) AS TOTAL 
        FROM peticion AS p LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
        WHERE d.ID_DESARROLLADOR = ? and e.ESTATUS = 'Completado' and FECHA_LLEGADA BETWEEN ? and ?"
    );

    $stmt->bind_param("iss", $DESARROLLADOR, $FECHA_INICIO, $FECHA_FINAL);

    $stmt->execute();

    $result = $stmt->get_result();

    $data = $result->fetch_assoc();

    $stmt->close();

    $COMPLETADO = $data['TOTAL'];

    array_push($DATOS_NUMERICOS, intval($COMPLETADO));

    //OBTENIENDO LA CANTIDAD DE DESARROLLOS

    $stmt = $conn->prepare(
        "SELECT COUNT(ID_PETICION) AS TOTAL 
        FROM peticion AS p LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
        WHERE d.ID_DESARROLLADOR = ? and e.ESTATUS = 'En Desarrollo' and FECHA_LLEGADA BETWEEN ? and ?"
    );

    $stmt->bind_param("iss", $DESARROLLADOR, $FECHA_INICIO, $FECHA_FINAL);

    $stmt->execute();

    $result = $stmt->get_result();

    $data = $result->fetch_assoc();

    $stmt->close();

    $DESARROLLO = $data['TOTAL'];

    array_push($DATOS_NUMERICOS, intval($DESARROLLO));


    //OBTENIENDO LA CANTIDAD DE PENDIENTES
    $stmt = $conn->prepare(
        "SELECT COUNT(ID_PETICION) AS TOTAL 
        FROM peticion AS p LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
        WHERE d.ID_DESARROLLADOR = ? and e.ESTATUS = 'Pendiente' and FECHA_LLEGADA BETWEEN ? and ?"
    );

    $stmt->bind_param("iss", $DESARROLLADOR, $FECHA_INICIO, $FECHA_FINAL);

    $stmt->execute();

    $result = $stmt->get_result();

    $data = $result->fetch_assoc();

    $stmt->close();

    $PENDIENTE = $data['TOTAL'];

    array_push($DATOS_NUMERICOS, intval($PENDIENTE));


    //OBTENIENDO LA CANTIDAD DE RECHAZADOS
    $stmt = $conn->prepare(
        "SELECT COUNT(ID_PETICION) AS TOTAL 
        FROM peticion AS p LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
        WHERE d.ID_DESARROLLADOR = ? and e.ESTATUS = 'Rechazado' and FECHA_LLEGADA BETWEEN ? and ?"
    );

    $stmt->bind_param("iss", $DESARROLLADOR, $FECHA_INICIO, $FECHA_FINAL);

    $stmt->execute();

    $result = $stmt->get_result();

    $data = $result->fetch_assoc();

    $stmt->close();

    $RECHAZADO = $data['TOTAL'];

    array_push($DATOS_NUMERICOS, intval($RECHAZADO));


    //OBTENIENDO EL TOTAL SIN IMPORTAR EL ESTATUS
    $stmt = $conn->prepare(
        "SELECT COUNT(ID_PETICION) AS TOTAL 
        FROM peticion AS p LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
        WHERE d.ID_DESARROLLADOR = ? and FECHA_LLEGADA BETWEEN ? and ?"
    );

    $stmt->bind_param("iss", $DESARROLLADOR, $FECHA_INICIO, $FECHA_FINAL);

    $stmt->execute();

    $result = $stmt->get_result();

    $data = $result->fetch_assoc();

    $stmt->close();

    $TOTAL = $data['TOTAL'];

    $TOTAL = intval($TOTAL);


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

        $stmt = $conn->prepare(
            "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
            INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
            WHERE e.estatus = 'Completado'AND ID_DESARROLLADOR = ? 
            AND MONTH(FECHA_LLEGADA) = ? 
            AND YEAR(FECHA_LLEGADA) = ?"
        );

        $stmt->bind_param("iss", $DESARROLLADOR, $MES_POR_DEFECTO, $yearGot);

        $stmt->execute();

        $result = $stmt->get_result();

        $data = $result->fetch_assoc();

        $stmt->close();

        $VALOR = $data['TOTAL'];

        array_push($VALOR_MENSUAL_COMPLETADAS, intval($VALOR));

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

        $FECHA .= "%";

        $stmt = $conn->prepare(
            "SELECT COUNT(ID_PETICION) AS TOTAL FROM peticion AS p 
            INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
            WHERE FECHA_LLEGADA LIKE ? 
            AND e.estatus = 'Completado'AND ID_DESARROLLADOR = ?"
        );

        $stmt->bind_param("si", $FECHA, $desGot);

        $stmt->execute();

        $result = $stmt->get_result();

        $data = $result->fetch_assoc();

        $stmt->close();

        $VALOR = $data['TOTAL'];

        array_push($DIAS_DEL_MES_GRAFICA_VALORES, intval($VALOR));

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
//CODIGO PARA GRAFICA COMPARACION DESARROLLADORES -Re
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
            WHERE e.estatus = 'En Desarrollo' AND d.ID_DESARROLLADOR  = ? AND FECHA_LLEGADA 
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
