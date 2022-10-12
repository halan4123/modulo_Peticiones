<?php

include 'app/connectionController.php';

$conn = connect();

//SE OBTIENE DESDE GET DESDE LA PESTAÑA DE BUSCADOR DE PETICIONES
$fechaInicio = $_GET['fechaInicio'];
$fechaFinal = $_GET['fechaFinal'];

//GENERACION DE LA CONSULTA
$peticiones = "SELECT p.*,
l.nombre AS NOMLAB,
l.paquete AS PAQUETE,
l.ID_LABORATORIO AS L_ID,
n.ID_NIVEL AS N_ID, 
n.nivel AS NOMNIVEL,
n.icono AS NIVEL_ICONO,
n.color_icono AS NIVEL_COLOR,
e.ID_ESTATUS AS E_ID,
e.estatus AS NOMESTATUS,
e.icono AS ESTATUS_ICONO,
e.color_icono AS ESTATUS_COLOR, 
d.nombre AS NOMDES,
s.nombre AS NOMSOP 
FROM peticion AS p 
INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO
INNER JOIN nivel AS n ON p.ID_NIVEL = n.ID_NIVEL
INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS
LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR
INNER JOIN soporte AS s ON p.ID_SOPORTE = s.ID_SOPORTE WHERE FECHA_LLEGADA BETWEEN '$fechaInicio' and '$fechaFinal'";

//NECESARIO PARA CREAR EL EXCEL
header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
header("Content-Disposition: attachment; filename=peticiones.xls");

?>

<table border="1">

    <!-- <caption>Datos Solicitados</caption> -->

    <tr>
        <th>#</th>
        <th>ESTATUS</th>
        <th>NIVEL</th>
        <th>ASUNTO</th>
        <th>LABORATORIO</th>
        <th>PAQUETE</th>
        <th>FECHA DE SOLICITUD</th>
        <th>FECHA DE ENTREGA ESTIMADA</th>
        <th>FECHA DE COMPLETADO</th>
        <th>SOPORTE</th>
        <th>DESARROLLADOR</th>
        <th>ENVIADO</th>
    </tr>

    <?php $res = mysqli_query($conn, $peticiones);

    while ($row = mysqli_fetch_assoc($res)) { ?>

        <tr>
            <td><?php echo $row["ID_PETICION"]; ?></td>
            <td><?php echo $row["NOMESTATUS"]; ?></td>
            <td><?php echo $row["NOMNIVEL"]; ?></td>
            <td><?php echo $row["ASUNTO"]; ?></td>
            <td><?php echo $row["NOMLAB"]; ?></td>
            <td><?php echo $row["PAQUETE"]; ?></td>
            <td><?php echo $row["FECHA_LLEGADA"]; ?></td>
            <td><?php echo $row["FECHA_ENTREGA_ESTIMADA"]; ?></td>
            <td><?php echo $row["FECHA_COMPLETADO"]; ?></td>
            <td><?php echo $row["NOMSOP"]; ?></td>
            <td><?php echo $row["NOMDES"]; ?></td>
            <td><?php echo $row["ENVIADO"]; ?></td>
        </tr>


    <?php  }

    mysqli_free_result($res); ?>


</table>