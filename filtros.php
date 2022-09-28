<?php

$query = "select * from `estatus`";
$prepared_query = $conn->prepare($query);
$prepared_query->execute();

$results = $prepared_query->get_result();
$soportes = $results->fetch_all(MYSQLI_ASSOC);

$query = "select * from `nivel`";
$prepared_query2 = $conn->prepare($query);
$prepared_query2->execute();

$results2 = $prepared_query2->get_result();
$niveles = $results2->fetch_all(MYSQLI_ASSOC);



?>
