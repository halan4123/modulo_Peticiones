<?php

include 'connectionController.php';

$conn = connect();

if (isset($_POST['badgesAjaxSend'])) {

    //SE OBTIENE EL NUMERO DE PETICIONES PENDIETES
    $stmt = $conn->prepare("SELECT COUNT(*) AS TOTAL FROM peticion WHERE ID_ESTATUS = 1 AND ELIMINADO = 0 AND ENVIADO = 0");

    $stmt->execute();

    $result = $stmt->get_result();

    $stmt->close();

    $result = $result->fetch_array()['TOTAL'] ?? 0;

    $TotalPendientes = $result;

    //SE OBTIENE EL NUMERO DE PETICIONES EN DESARROLLO
    $stmt = $conn->prepare("SELECT COUNT(*) AS TOTAL FROM peticion WHERE ID_ESTATUS = 4 AND ELIMINADO = 0 AND ENVIADO = 0");

    $stmt->execute();

    $result = $stmt->get_result();

    $stmt->close();

    $result = $result->fetch_array()['TOTAL'] ?? 0;

    $TotalDesarrollo = $result;

    //SE OBTIENE EL NUMERO DE PETICIONES SIN ENVIAR
    $stmt = $conn->prepare("SELECT COUNT(*) AS TOTAL FROM peticion WHERE (ID_ESTATUS = 2 OR ID_ESTATUS = 3) AND ELIMINADO = 0 AND ENVIADO = 0");

    $stmt->execute();

    $result = $stmt->get_result();

    $stmt->close();

    $result = $result->fetch_array()['TOTAL'] ?? 0;

    $TotalSinEnviar = $result;


    $respuesta = [
        "pendientes" => $TotalPendientes,
        "desarrollo" => $TotalDesarrollo,
        "sinenviar" => $TotalSinEnviar,
    ];

    echo json_encode($respuesta);
}
