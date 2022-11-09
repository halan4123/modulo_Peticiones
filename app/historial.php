<?php

include 'connectionController.php';

$conn = connect();

//==========================================================================================================================
//MUESTRA DE LA TABLA QUE SE MUESTRA CUANDO SE DA CLICK EN EL BOTON DE HISTORIAL DE UNA PETICION INDEPENDIETE
//==========================================================================================================================
if (isset($_POST['displayHistorialSend'])) {

    $ID = $_POST['idSend'];


    $table = '
                    <table id="tabla-historial" class="display table table-responsive">
                    <thead>
                        <tr>
                            <th class="color-tabla-historial">#</th>
                            <th class="color-tabla-historial">ID_USUARIO</th>
                            <th class="color-tabla-historial">ACCIÓN</th>
                            <th class="color-tabla-historial">ASUNTO</th>
                            <th class="color-tabla-historial">MODIFICACIÓN</th>
                            <th class="color-tabla-historial">LABORATORIO</th>
                            <th class="color-tabla-historial">FECHA ENTREGA ESTIMADA</th>
                            <th class="color-tabla-historial">SOPORTE</th>
                            <th class="color-tabla-historial">DESARROLLADOR</th>
                            <th class="color-tabla-historial">NIVEL</th>
                            <th class="color-tabla-historial">ESTATUS</th>
                            <th class="color-tabla-historial">ENVIADO</th>
                            <th class="color-tabla-historial">ELIMINADO</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                ';

    $sql = "SELECT p.*, l.nombre AS NOMLAB, 
        n.nivel AS NOMNIVEL, 
        e.estatus AS NOMESTATUS, 
        d.nombre AS NOMDES, 
        s.nombre AS NOMSOP 
        FROM historial AS p 
        INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO 
        INNER JOIN nivel AS n ON p.ID_NIVEL = n.ID_NIVEL 
        INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
        LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR 
        INNER JOIN soporte AS s ON p.ID_SOPORTE = s.ID_SOPORTE WHERE ID_PETICION = ? ORDER BY MODIFICACION DESC";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $ID);

    $stmt->execute();

    $result = $stmt->get_result();

    $CONT = 1;
    while ($row = mysqli_fetch_assoc($result)) {

        $ID_USUARIO = $row['ID_USUARIO'];
        $ACCION = $row['ACCION'];
        $ASUNTO = $row['ASUNTO'];
        $MODIFICACION = $row['MODIFICACION'];
        $LABORATORIO = $row['NOMLAB'];
        $FECHA_ENTREGA_ESTIMADA = $row['FECHA_ENTREGA_ESTIMADA'];
        $SOPORTE = $row['NOMSOP'];
        $DESARROLLADOR = $row['NOMDES'];
        $NIVEL = $row['NOMNIVEL'];
        $ESTATUS = $row['NOMESTATUS'];
        $ENVIADO = $row['ENVIADO'];
        $ELIMINADO = $row['ELIMINADO'];

        if ($ENVIADO == 0) {
            $ENVIADO = 'No';
        } else {
            $ENVIADO = 'Si';
        }

        if ($ELIMINADO == 0) {
            $ELIMINADO = 'No';
        } else {
            $ELIMINADO = 'Si';
        }

        if ($ID_USUARIO == NULL) {
            $ID_USUARIO = 'Sin Definir';
        }

        if ($DESARROLLADOR == NULL) {
            $DESARROLLADOR = 'Sin Definir';
        }


        $table .= ' <tr>
                        <td>' . $CONT . '</td>
                        <td>' . $ID_USUARIO . '</td>
                        <td>' . $ACCION . '</td>
                        <td>' . $ASUNTO . '</td>
                        <td>' . $MODIFICACION . '</td>
                        <td>' . $LABORATORIO . '</td>
                        <td>' . $FECHA_ENTREGA_ESTIMADA . '</td>
                        <td>' . $SOPORTE . '</td>
                        <td>' . $DESARROLLADOR . '</td>
                        <td>' . $NIVEL . '</td>
                        <td>' . $ESTATUS . '</td>
                        <td>' . $ENVIADO . '</td>
                        <td>' . $ELIMINADO . '</td>
                    </tr>
        ';

        $CONT++;
    }


    $table .= '
                    </tbody>
                </table>';

    echo $table;
}

//==========================================================================================================================
//MUESTRA DE LA TABLA QUE SE MUESTRA EN ADMID TODAS LAS MODIFICACIONES
//==========================================================================================================================
if (isset($_POST['displayHistorialModificacionSend'])) {

    $FECHA_INICIO = $_POST['filtroFechaInicioSend'];
    $FECHA_FINAL = $_POST['filtroFechaFinalSend'];
    $FECHA_INICIO .= " 00:00:00.000";
    $FECHA_FINAL .= " 23:59:59.999";

    $table = '
    <table id="tabla-historial-modificaciones" class="display table table-responsive">
        <thead>
            <tr>
                <th class="color-pendiente-btn-info">#</th>
                <th class="color-pendiente-btn-info">ID_USUARIO</th>
                <th class="color-pendiente-btn-info">ACCIÓN</th>
                <th class="color-pendiente-btn-info">ASUNTO</th>
                <th class="color-pendiente-btn-info">MODIFICACIÓN</th>
                <th class="color-pendiente-btn-info">LABORATORIO</th>
                <th class="color-pendiente-btn-info">FECHA ENTREGA ESTIMADA</th>
                <th class="color-pendiente-btn-info">SOPORTE</th>
                <th class="color-pendiente-btn-info">DESARROLLADOR</th>
                <th class="color-pendiente-btn-info">NIVEL</th>
                <th class="color-pendiente-btn-info">ESTATUS</th>
                <th class="color-pendiente-btn-info">ENVIADO</th>
                <th class="color-pendiente-btn-info">ELIMINADO</th>
            </tr>
        </thead>
    <tbody>
    ';

    $sql = "SELECT p.*, l.nombre AS NOMLAB, 
    n.nivel AS NOMNIVEL, 
    e.estatus AS NOMESTATUS, 
    d.nombre AS NOMDES, 
    s.nombre AS NOMSOP 
    FROM historial AS p 
    INNER JOIN laboratorio AS l ON p.ID_LABORATORIO = l.ID_LABORATORIO 
    INNER JOIN nivel AS n ON p.ID_NIVEL = n.ID_NIVEL 
    INNER JOIN estatus AS e ON p.ID_ESTATUS = e.ID_ESTATUS 
    LEFT JOIN desarrollador AS d ON p.ID_DESARROLLADOR = d.ID_DESARROLLADOR 
    INNER JOIN soporte AS s ON p.ID_SOPORTE = s.ID_SOPORTE WHERE 1 and MODIFICACION BETWEEN ? and ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ss", $FECHA_INICIO, $FECHA_FINAL);

    $stmt->execute();

    $result = $stmt->get_result();

    $CONT = 1;

    while ($row = mysqli_fetch_assoc($result)) {

        $ID_USUARIO = $row['ID_USUARIO'];
        $ACCION = $row['ACCION'];
        $ASUNTO = $row['ASUNTO'];
        $MODIFICACION = $row['MODIFICACION'];
        $LABORATORIO = $row['NOMLAB'];
        $FECHA_ENTREGA_ESTIMADA = $row['FECHA_ENTREGA_ESTIMADA'];
        $SOPORTE = $row['NOMSOP'];
        $DESARROLLADOR = $row['NOMDES'];
        $NIVEL = $row['NOMNIVEL'];
        $ESTATUS = $row['NOMESTATUS'];
        $ENVIADO = $row['ENVIADO'];
        $ELIMINADO = $row['ELIMINADO'];

        if ($ENVIADO == 0) {
            $ENVIADO = 'No';
        } else {
            $ENVIADO = 'Si';
        }

        if ($ELIMINADO == 0) {
            $ELIMINADO = 'No';
        } else {
            $ELIMINADO = 'Si';
        }

        if ($ID_USUARIO == NULL) {
            $ID_USUARIO = 'Sin Definir';
        }

        if ($DESARROLLADOR == NULL) {
            $DESARROLLADOR = 'Sin Definir';
        }

        if ($ACCION == "UPDATE") {
            $ACCION = '<span class="label label-primary">UPDATE</span>';
        } else {
            $ACCION = '<span class="label label-danger">DELETE</span>';
        }

        if ($ESTATUS == "Pendiente") {
            $ESTATUS = '<span class="label label-warning">Pendiente</span>';
        } else if ($ESTATUS == "Completado") {
            $ESTATUS = '<span class="label label-success">Completado</span>';
        } else if ($ESTATUS == "En Desarrollo") {
            $ESTATUS = '<span class="label label-info">En Desarrollo</span>';
        } else {
            $ESTATUS = '<span class="label label-danger">Rechazado</span>';
        }


        $table .= ' <tr>
                        <td>' . $CONT . '</td>
                        <td>' . $ID_USUARIO . '</td>
                        <td>' . $ACCION . '</td>
                        <td>' . $ASUNTO . '</td>
                        <td>' . $MODIFICACION . '</td>
                        <td>' . $LABORATORIO . '</td>
                        <td>' . $FECHA_ENTREGA_ESTIMADA . '</td>
                        <td>' . $SOPORTE . '</td>
                        <td>' . $DESARROLLADOR . '</td>
                        <td>' . $NIVEL . '</td>
                        <td>' . $ESTATUS . '</td>
                        <td>' . $ENVIADO . '</td>
                        <td>' . $ELIMINADO . '</td>
                    </tr>
        ';

        $CONT++;
    }


    $table .= '
                    </tbody>
                </table>';

    echo $table;
}
