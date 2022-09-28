<?php

//CONSULTA PARA OBTENER EL ID DEL NIVEL REQUERIDO QUE SEA EL POR DEFECTO
$query = "SELECT ID_NIVEL FROM nivel WHERE NIVEL = 'Sin Definir'";

$result = $conn->query($query);  // or mysqli_query($con, $tourquery);

$ID_NIVEL = $result->fetch_array()[0] ?? ''; //OR $tourresult = $result->fetch_array()['roomprice'] ?? '';

//CONSULTA PARA OBTENER EL ID DEL ESTATUS REQUERIDO QUE SEA EL POR DEFECTO
$query = "SELECT ID_ESTATUS FROM estatus WHERE ESTATUS = 'pendiente'";

$result = $conn->query($query);

$ID_ESTATUS = $result->fetch_array()[0] ?? '';

?>