<?php

//SE OBTIENE LOS DATOS QUE IRAN EN EL FILTRO DE ESTATUS
$query = "select * from `estatus`";
$prepared_query = $conn->prepare($query);
$prepared_query->execute();

$results = $prepared_query->get_result();
$soportes = $results->fetch_all(MYSQLI_ASSOC);

//SE OBTIENE LOS DATOS QUE IRAN EN EL FILTRO DE NIVEL
$query = "select * from `nivel`";
$prepared_query2 = $conn->prepare($query);
$prepared_query2->execute();

$results2 = $prepared_query2->get_result();
$niveles = $results2->fetch_all(MYSQLI_ASSOC);

//SE OBTIENE LOS DATOS QUE IRAN EN EL FILTRO DE LABORATORIO
$query = "select * from `laboratorio`";
$prepared_query3 = $conn->prepare($query);
$prepared_query3->execute();

$results3 = $prepared_query3->get_result();
$laboratorios = $results3->fetch_all(MYSQLI_ASSOC);



?>
