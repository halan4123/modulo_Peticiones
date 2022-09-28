<?php 

include 'connectionController.php';

$conn = connect();

//MUESTREO DE LA TABLA Y VALIDACIONES DE LA MISMA
if (isset($_POST['displayDataSoporteSend'])) {

    $table = '
    <table id="tabla_soporte" class="display table table-responsive table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>NOMBRES(S)</th>     
                <th>APELLIDOS(S)</th>       
                <th>MÓVIL</th>  
                <th>CORREO</th>       
                <th>ACCIONES</th>   
            </tr>
        </thead>
        <tbody>
    ';

    $sql = "SELECT * FROM `soporte` WHERE 1";

    $result = mysqli_query($conn, $sql); //EJECUTAMOS LA CONSULTA

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

    //CONTATENAMOS LA ESTRUCUTURA FINAL DE LA TABLA, ES REQUERIDO SI NO SE HACE NO FUNCIONA EL DATATABLE
    $table .= ' 
                    </tbody>
                </table>
                ';
                
    //MOSTRAMOS LA TABLA, SI NO SE MUESTRA NO FUNCIONA
    echo $table;

}

//AGREGAR SOPORTE
if (isset($_POST['insertSoporteSend'])) {

    extract($_POST); //NOS DEVUELVE UN ARREGLO

    if (
        isset($_POST['nombreSoporteAddSend']) &&
        isset($_POST['apellidoSoporteAddSend']) &&
        isset($_POST['numeroSoperteAddSend']) && 
        isset($_POST['correoSoporteAddSend']) 
    ) {
        //CREAMOS LA CONSULTA
        $sql = "INSERT INTO `soporte` 
        (`NOMBRE`, `APELLIDOS`, `NUM_CELULAR`, `CORREO`) VALUES 
        ('$nombreSoporteAddSend', '$apellidoSoporteAddSend', '$numeroSoperteAddSend', '$correoSoporteAddSend')";

        //EJECUTAMOS LA CONSULTA
        $result = mysqli_query($conn, $sql);
    }
}

//DELETE SOPORTE
if (isset($_POST['eliminarSoporteSend'])) {

    $id = $_POST['deleteSend'];

    $sql = "DELETE FROM `soporte` WHERE ID_SOPORTE = $id";
    $result = mysqli_query($conn, $sql);
}

//GET INFO SOPORTE 
if (isset($_POST['getInfoSoporteSend']) || isset($_POST['getInfoUpdateSoporteSend'])) {

    if (isset($_POST['idSend'])) {

        $id = $_POST['idSend'];

        $sql = "SELECT * FROM `soporte` WHERE ID_SOPORTE = $id";

        $result = mysqli_query($conn, $sql);

        $response = array();

        while ($row = mysqli_fetch_assoc($result)) {

            $response = $row;
        }

        echo json_encode($response);
    }
}

//ACTUALIZAR SOPORTE
if (isset($_POST['actualizarSoporteSend'])) {

    $ID_SOPORTE = $_POST['idHiddenSend'];
    $NOMBRE = $_POST['nombreActualizarSend'];
    $APELLIDOS = $_POST['apellidoActualizarSend'];
    $NUM_CELULAR = $_POST['numeroActualizarSend'];
    $CORREO = $_POST['correoActualizarSend'];

    $sql = "UPDATE `soporte` SET `NOMBRE` = '$NOMBRE',
    `APELLIDOS` = '$APELLIDOS',
    `NUM_CELULAR` = '$NUM_CELULAR',
    `CORREO` = '$CORREO'
    WHERE `ID_SOPORTE` = $ID_SOPORTE";

    $result = mysqli_query($conn, $sql);
}