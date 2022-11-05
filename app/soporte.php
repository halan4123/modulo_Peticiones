<?php

include 'connectionController.php';

$conn = connect();

//==========================================================================================================================
//MUESTRA DE LA TABLA Y VALIDACIONES DE LA MISMA
//==========================================================================================================================
if (isset($_POST['displayDataSoporteSend'])) {

    $table = '
    <table id="tabla_soporte" class="display table table-responsive table-striped">
        <thead>
            <tr>
                <th class="color-pendiente-btn-info">#</th>
                <th class="color-pendiente-btn-info">NOMBRE(S)</th>     
                <th class="color-pendiente-btn-info">APELLIDO(S)</th>       
                <th class="color-pendiente-btn-info">MÓVIL</th>  
                <th class="color-pendiente-btn-info">CORREO</th>       
                <th class="color-pendiente-btn-info">ACCIONES</th>   
            </tr>
        </thead>
        <tbody>
    ';

    // $sql = "SELECT * FROM `soporte` WHERE `OCULTO` = 0";

    // $result = mysqli_query($conn, $sql); //EJECUTAMOS LA CONSULTA

    $stmt = $conn->prepare(
        "SELECT * FROM `soporte` WHERE `OCULTO` = 0"
    );

    $stmt->execute();

    $result = $stmt->get_result();

    $CONT = 1;

    while ($row = mysqli_fetch_assoc($result)) {

        //POR CADA CICLO OBTENEMOS LOS DATOS DE LA BD Y LOS GUARDAMOS EN VARIABLES 
        $ID_SOPORTE = $row['ID_SOPORTE'];
        $NOMBRE = $row['NOMBRE'];
        $APELLIDOS = $row['APELLIDOS'];
        $NUM_CELULAR = $row['NUM_CELULAR'];
        $CORREO = $row['CORREO'];

        $table .= '
            <tr>
                <td>' . $CONT . '</td>
                <td>' . $NOMBRE . '</td>
                <td>' . $APELLIDOS . '</td>
                <td>' . $NUM_CELULAR . '</td>
                <td>' . $CORREO . '</td>
                <td>
                <div class="re">
                    <button class="btn btn-warning accionesDesarrollador " onclick="getInfoSoporte(' . $ID_SOPORTE . ')">
                    <span class="bi bi-eye-fill"></span>
                    </button>

                    <button class="btn btn-info accionesDesarrollador" onclick="actualizarGetInfoSoporte(' . $ID_SOPORTE . ')">
                    <span class="bi bi-pencil-fill"></span>
                    </button>

                    <button class="btn btn-danger accionesDesarrollador" onclick="eliminarSoporte(' . $ID_SOPORTE . ')">
                    <span class="bi bi-trash-fill"></span>
                    </button>
                </div>
                   

                </td>
            </tr>
            ';

        $CONT += 1;
    }

    $stmt->close();

    //CONTATENAMOS LA ESTRUCUTURA FINAL DE LA TABLA, ES REQUERIDO SI NO SE HACE NO FUNCIONA EL DATATABLE
    $table .= ' 
                    </tbody>
                </table>
                ';

    //MOSTRAMOS LA TABLA, SI NO SE MUESTRA NO FUNCIONA
    echo $table;
}

//==========================================================================================================================
//AGREGAR SOPORTE
//==========================================================================================================================
if (isset($_POST['insertSoporteSend'])) {

    extract($_POST); //NOS DEVUELVE UN ARREGLO

    if (
        isset($_POST['nombreSoporteAddSend']) &&
        isset($_POST['apellidoSoporteAddSend']) &&
        isset($_POST['numeroSoperteAddSend']) &&
        isset($_POST['correoSoporteAddSend'])
    ) {
        $stmt = $conn->prepare(
            "INSERT INTO `soporte` 
            (`NOMBRE`, `APELLIDOS`, `NUM_CELULAR`, `CORREO`) VALUES 
            (?, ?, ?, ?)"
        );

        $stmt->bind_param("ssss", $nombreSoporteAddSend, $apellidoSoporteAddSend, $numeroSoperteAddSend, $correoSoporteAddSend);

        $stmt->execute();

        $stmt->close();
    }
}


//==========================================================================================================================
//ELIMINA SOPORTE -> OCULTAR SOPORTE
//==========================================================================================================================
if (isset($_POST['eliminarSoporteSend'])) {

    $id = $_POST['deleteSend'];

    $stmt = $conn->prepare(
        "UPDATE `soporte` SET `OCULTO` = '1' 
        WHERE `ID_SOPORTE` = ?"
    );

    $stmt->bind_param("i", $id);

    $stmt->execute();

    $stmt->close();
}

//==========================================================================================================================
//OBTIENE LA INFORMACION DEL SOPORTE
//==========================================================================================================================
if (isset($_POST['getInfoSoporteSend']) || isset($_POST['getInfoUpdateSoporteSend'])) {

    if (isset($_POST['idSend'])) {

        $id = $_POST['idSend'];

        $stmt = $conn->prepare(
            "SELECT * FROM `soporte` WHERE ID_SOPORTE = ?"
        );

        $stmt->bind_param("i", $id);

        $stmt->execute();

        $result = $stmt->get_result();

        $data = $result->fetch_assoc();

        $stmt->close();

        echo json_encode($data);
    }
}

//==========================================================================================================================
//ACTUALIZAR SOPORTE
//==========================================================================================================================
if (isset($_POST['actualizarSoporteSend'])) {

    $ID_SOPORTE = $_POST['idHiddenSend'];
    $NOMBRE = $_POST['nombreActualizarSend'];
    $APELLIDOS = $_POST['apellidoActualizarSend'];
    $NUM_CELULAR = $_POST['numeroActualizarSend'];
    $CORREO = $_POST['correoActualizarSend'];

    $stmt = $conn->prepare(
        "UPDATE `soporte` SET `NOMBRE` = ?,
        `APELLIDOS` = ?,
        `NUM_CELULAR` = ?,
        `CORREO` = ?
        WHERE `ID_SOPORTE` = ?"
    );

    $stmt->bind_param("ssssi", $NOMBRE, $APELLIDOS, $NUM_CELULAR, $CORREO, $ID_SOPORTE);

    $stmt->execute();

    $stmt->close();
}
