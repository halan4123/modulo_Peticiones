<?php

//SE OBTIENE LOS DATOS QUE IRAN EN EL FILTRO DESARROLLADORES EN LAS GRAFICAS
$stmt = $conn->prepare("SELECT ID_DESARROLLADOR, NOMBRE FROM `desarrollador`");

$stmt->execute();

$result = $stmt->get_result();

$stmt->close();

$data = $result->fetch_all(MYSQLI_ASSOC);

//SE OBTIENE EL NUMERO DE PETICIONES PENDIETES
$stmt = $conn->prepare("SELECT COUNT(*) AS TOTAL FROM peticion WHERE ID_ESTATUS = 1 AND ELIMINADO = 0 AND ENVIADO = 0");

$stmt->execute();

$result = $stmt->get_result();

$stmt->close();

$result = $result -> fetch_array()['TOTAL'] ?? 0;

$TotalPendientes = $result;

//SE OBTIENE EL NUMERO DE PETICIONES EN DESARROLLO
$stmt = $conn->prepare("SELECT COUNT(*) AS TOTAL FROM peticion WHERE ID_ESTATUS = 4 AND ELIMINADO = 0 AND ENVIADO = 0");

$stmt->execute();

$result = $stmt->get_result();

$stmt->close();

$result = $result -> fetch_array()['TOTAL'] ?? 0;

$TotalDesarrollo = $result;

//SE OBTIENE EL NUMERO DE PETICIONES SIN ENVIAR
$stmt = $conn->prepare("SELECT COUNT(*) AS TOTAL FROM peticion WHERE (ID_ESTATUS = 2 OR ID_ESTATUS = 3) AND ELIMINADO = 0 AND ENVIADO = 0");

$stmt->execute();

$result = $stmt->get_result();

$stmt->close();

$result = $result -> fetch_array()['TOTAL'] ?? 0;

$TotalSinEnviar = $result;
