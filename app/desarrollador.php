<?php
include 'connectionController.php';

$conn = connect();

//==========================================================================================================================
//MUESTRA DE LA TABLA Y VALIDACIONES DE LA MISMA
//==========================================================================================================================
if (isset($_POST['displayDataDesarrolladorSend'])) {

    $table = '
    <table id="tabla_desarrolladores" class="display table table-responsive table-striped">
        <thead>
            <tr>
                <th class="color-tabla-desarrollador">#</th>
                <th class="color-tabla-desarrollador">NOMBRE(S)</th>     
                <th class="color-tabla-desarrollador">APELLIDO(S)</th>            
                <th class="color-tabla-desarrollador">ACCIONES</th>   
            </tr>
        </thead>
        <tbody>
        ';

 
    $stmt = $conn->prepare(
        "SELECT * FROM `desarrollador` WHERE `OCULTO` = 0"
    );

    $stmt->execute();

    $result = $stmt->get_result();

    $CONT = 1;

    while ($row = mysqli_fetch_assoc($result)) {

        //POR CADA CICLO OBTENEMOS LOS DATOS DE LA BD Y LOS GUARDAMOS EN VARIABLES 
        $ID_DESARROLLADOR = $row['ID_DESARROLLADOR'];
        $NOMBRE = $row['NOMBRE'];
        $APELLIDOS = $row['APELLIDOS'];

        $table .= '
            <tr>
                <td>' . $CONT . '</td>
                <td>' . $NOMBRE . '</td>
                <td>' . $APELLIDOS . '</td>
                <td>
                <div class="re">
                    <button class="btn btn-warning accionesDesarrollador " onclick="getInfoDesarrollador(' . $ID_DESARROLLADOR . ')">
                    <span class="bi bi-eye-fill"></span>
                    </button>

                    <button class="btn btn-info accionesDesarrollador" onclick="actualizarGetInfoDesarrollador(' . $ID_DESARROLLADOR . ')">
                    <span class="bi bi-pencil-fill"></span>
                    </button>

                    <button class="btn btn-danger accionesDesarrollador" onclick="eliminarDesarrollador(' . $ID_DESARROLLADOR . ')">
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
//AGREGAR DESARROLLADOR
//==========================================================================================================================
if (isset($_POST['insertDesarrolladorSend'])) {

    extract($_POST); //NOS DEVUELVE UN ARREGLO

    if (
        isset($_POST['nombreDesarrolladorAddSend']) &&
        isset($_POST['apellidoDesarrolladorAddSend'])
    ) {

        $stmt = $conn->prepare(
            "INSERT INTO `desarrollador` 
            (`NOMBRE`, `APELLIDOS`) VALUES 
            (?,?)"
        );

        $stmt->bind_param("ss", $nombreDesarrolladorAddSend, $apellidoDesarrolladorAddSend);

        $stmt->execute();

        $stmt->close();
    }
}

//==========================================================================================================================
//ELIMINAR DESARROLLADOR -> OCULTAR DESARROLLADOR
//==========================================================================================================================
if (isset($_POST['eliminarDesarrolladorSend'])) {

    $id = $_POST['deleteSend'];

    $stmt = $conn->prepare(
        "UPDATE `desarrollador` SET `OCULTO` = '1' 
        WHERE `ID_DESARROLLADOR` = ?"
    );

    $stmt->bind_param("i", $id);

    $stmt->execute();

    $stmt->close();
}

//==========================================================================================================================
//OBTIENE LA INFORMACION DEL DESARROLLADOR
//==========================================================================================================================
if (isset($_POST['getInfoDesarrolladorSend']) || isset($_POST['getInfoUpdateDesarrolladorSend'])) {

    if (isset($_POST['idSend'])) {

        $id = $_POST['idSend'];

        $stmt = $conn->prepare(
            "SELECT * FROM `desarrollador` WHERE ID_DESARROLLADOR = ?"
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
//ACTUALIZAR DESARROLLADOR 
//==========================================================================================================================
if (isset($_POST['actualizarDesarrolladorSend'])) {

    $ID_DESARROLLADOR = $_POST['idHiddenSend'];
    $NOMBRE = $_POST['nombreActualizarSend'];
    $APELLIDOS = $_POST['apellidoActualizarSend'];

    $stmt = $conn->prepare(
        "UPDATE `desarrollador` SET `NOMBRE` = ?,
        `APELLIDOS` = ?
        WHERE `ID_DESARROLLADOR` = ?"
    );

    $stmt->bind_param("ssi", $NOMBRE, $APELLIDOS, $ID_DESARROLLADOR);

    $stmt->execute();

    $stmt->close();
}
