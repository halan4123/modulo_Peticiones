<?php

//SE OBTIENE LOS DATOS QUE IRAN EN EL FILTRO DESARROLLADORES EN LAS GRAFICAS
$stmt = $conn->prepare("SELECT ID_DESARROLLADOR, NOMBRE FROM `desarrollador`");
$stmt->execute();

$result = $stmt->get_result();

$stmt->close();

$data = $result->fetch_all(MYSQLI_ASSOC);


?>
