<?php
include 'connectionController.php';

$conn = connect();

if (isset($_POST['pruebaSend'])) {


    $sql = "SELECT `NOMBRE` FROM `desarrollador` WHERE 1 ORDER BY NOMBRE ASC";

    $result = mysqli_query($conn, $sql);

    $NOMBRES_DESARROLLADORES = array();

    while ($row = mysqli_fetch_assoc($result)) {

        array_push($NOMBRES_DESARROLLADORES, $row['NOMBRE']);
    }

    $CONTADOR = 0;

    $CANTIDAD = count($NOMBRES_DESARROLLADORES);

    $DESARROLLOS = array();

    while ($CONTADOR < $CANTIDAD) {

        $PERSONA = $NOMBRES_DESARROLLADORES[$CONTADOR];

        $query = "SELECT d.nombre AS NOMDES, COUNT(ID_PETICION) AS TOTAL FROM peticion AS p LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR 
        WHERE d.nombre = '$PERSONA'";

        $result2 = $conn->query($query);
    
        $VALOR = $result2->fetch_array()['TOTAL'] ?? '';
        
        array_push($DESARROLLOS, intval($VALOR));

        $CONTADOR++;
    }

    // var_dump($DESARROLLOS);

    // var_dump($NOMBRES_DESARROLLADORES);

    $datosVentas = [30, 10, 15, 12];

    // Ahora las imprimimos como JSON para pasarlas a AJAX, pero las agrupamos
    $respuesta = [
        "nombre" => $NOMBRES_DESARROLLADORES,
        "datos" => $DESARROLLOS,
    ];

    echo json_encode($respuesta);


}
