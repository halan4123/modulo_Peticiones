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


    $sql = "SELECT `NOMBRE` FROM `desarrollador` WHERE 1 ORDER BY NOMBRE ASC";

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

    $sql = "SELECT `NOMBRE` FROM `soporte` WHERE 1 ORDER BY NOMBRE ASC";

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

    $respuesta = [
        "datos" => $VALOR_MENSUAL,
    ];

    echo json_encode($respuesta);
}

//==========================================================================================================================
//GRAFICA DE PETCIONES ANUALES COMPLETADAS POR MES
//==========================================================================================================================

if (isset($_POST['anualDatosCompletadasSend'])) {

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

    $respuesta = [
        "datos" => $VALOR_MENSUAL_COMPLETADAS,
    ];

    echo json_encode($respuesta);

    
}