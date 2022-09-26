<?php
include 'connectionController.php';

$conn = connect();

//MUESTREO DE LA TABLA Y VALIDACIONES DE LA MISMA
if (isset($_POST['displayDataDesarrolladorSend'])) {

    $table = '
    <table id="tabla_desarrolladores" class="display table table-responsive table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre(s)</th>     
                <th>Apellido(s)</th>            
                <th>Acciones</th>   
            </tr>
        </thead>
        <tbody>
        ';

    $sql = "SELECT * FROM `desarrollador` WHERE 1";

    $result = mysqli_query($conn, $sql); //EJECUTAMOS LA CONSULTA

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
                    <span class="fa fa-eye"></span>
                    </button>

                    <button class="btn btn-info accionesDesarrollador" onclick="actualizarGetInfoDesarrollador(' . $ID_DESARROLLADOR . ')">
                    <span class="fa fa-pencil"></span>
                    </button>

                    <button class="btn btn-danger accionesDesarrollador" onclick="eliminarDesarrollador(' . $ID_DESARROLLADOR . ')">
                    <span class="glyphicon glyphicon-remove"></span>
                    </button>
                </div>
                   

                </td>
            </tr>
            ';

            $CONT +=1;
    }

    //CONTATENAMOS LA ESTRUCUTURA FINAL DE LA TABLA, ES REQUERIDO SI NO SE HACE NO FUNCIONA EL DATATABLE
    $table .= ' 
                    </tbody>
                </table>
                ';
    //MOSTRAMOS LA TABLA, SI NO SE MUESTRA NO FUNCIONA
    echo $table;
}

//AGREGAR DESARROLLADOR
if (isset($_POST['insertDesarrolladorSend'])) {

    extract($_POST); //NOS DEVUELVE UN ARREGLO

    if (
        isset($_POST['nombreDesarrolladorAddSend']) &&
        isset($_POST['apellidoDesarrolladorAddSend'])
    ) {
        //CREAMOS LA CONSULTA
        $sql = "INSERT INTO `desarrollador` 
        (`NOMBRE`, `APELLIDOS`) VALUES 
        ('$nombreDesarrolladorAddSend', '$apellidoDesarrolladorAddSend')";

        //EJECUTAMOS LA CONSULTA
        $result = mysqli_query($conn, $sql);
    }
}

//ELIMINAR DESARROLLADOR 
if (isset($_POST['eliminarDesarrolladorSend'])) {

    $id = $_POST['deleteSend'];

    $sql = "DELETE FROM `desarrollador` WHERE ID_DESARROLLADOR = $id";
    $result = mysqli_query($conn, $sql);
}

//GET INFO DESARROLLADOR 
if (isset($_POST['getInfoDesarrolladorSend'])) {

    if (isset($_POST['idSend'])) {

        $id = $_POST['idSend'];

        $sql = "SELECT * FROM `desarrollador` WHERE ID_DESARROLLADOR = $id";

        $result = mysqli_query($conn, $sql);

        $response = array();

        while ($row = mysqli_fetch_assoc($result)) {

            $response = $row;
        }

        echo json_encode($response);

    }
}
