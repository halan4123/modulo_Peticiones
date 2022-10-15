<?php
include 'connectionController.php';

$conn = connect();

//==========================================================================================================================
//BUSCA LA INFORMACION DE LABORATORIOS
//==========================================================================================================================
if (isset($_POST['boleanoLaboratorioSend'])) {

    if (!isset($_POST['buscarLaboratorio'])) {

        //PARA QUE SOLO APAREZCAN 5 O EL NUMERO QUE DESEES POR DEFECTO COLOCAR LIMIT N.O
        $fetchData = mysqli_query($conn, "SELECT * FROM laboratorio ORDER BY NOMBRE");
    } else {
        $search = $_POST['buscarLaboratorio'];

        $fetchData = mysqli_query($conn, "SELECT * FROM laboratorio where NOMBRE like '%" . $search . "%' limit 5");
    }

    $data = array();

    while ($row = mysqli_fetch_array($fetchData)) {

        $data[] = array("id" => $row['ID_LABORATORIO'], "text" => $row['NOMBRE']);
    }
    echo json_encode($data);
}

//==========================================================================================================================
//BUSCA LA INFORMACION DEL SOPORTE -> INCLUSO A LOS OCULTOS
//==========================================================================================================================
if (isset($_POST['boleanoSoporteSend'])) {

    if (!isset($_POST['buscarSoporte'])) {

        $fetchData = mysqli_query($conn, "SELECT * FROM soporte ORDER BY NOMBRE");
    } else {
        $search = $_POST['buscarSoporte'];

        $fetchData = mysqli_query($conn, "SELECT * FROM soporte where NOMBRE like '%" . $search . "%' limit 5");
    }

    $data = array();

    while ($row = mysqli_fetch_array($fetchData)) {

        $data[] = array("id" => $row['ID_SOPORTE'], "text" => $row['NOMBRE']);
    }
    echo json_encode($data);
}

//==========================================================================================================================
//BUSCA LA INFORMACION DEL SOPORTE -> SOLO A LOS NO OCULTOS
//==========================================================================================================================
if (isset($_POST['boleanoSoporteNoOcultosSend'])) {

    if (!isset($_POST['buscarSoporte'])) {

        $fetchData = mysqli_query($conn, "SELECT * FROM soporte WHERE OCULTO = 0 ORDER BY NOMBRE");
    } else {
        $search = $_POST['buscarSoporte'];

        $fetchData = mysqli_query($conn, "SELECT * FROM soporte WHERE OCULTO = 0 AND NOMBRE like '%" . $search . "%' limit 5");
    }

    $data = array();

    while ($row = mysqli_fetch_array($fetchData)) {

        $data[] = array("id" => $row['ID_SOPORTE'], "text" => $row['NOMBRE']);
    }
    echo json_encode($data);
}

//==========================================================================================================================
//BUSCA LA INFORMACION DEL DESARROLLADOR
//==========================================================================================================================
if (isset($_POST['boleanoDesarrolladorSend'])) {

    if (!isset($_POST['buscarDesarrollador'])) {

        $fetchData = mysqli_query($conn, "SELECT * FROM desarrollador ORDER BY NOMBRE");
    } else {
        $search = $_POST['buscarDesarrollador'];

        $fetchData = mysqli_query($conn, "SELECT * FROM desarrollador where NOMBRE like '%" . $search . "%' limit 5");
    }

    $data = array();

    while ($row = mysqli_fetch_array($fetchData)) {

        $data[] = array("id" => $row['ID_DESARROLLADOR'], "text" => $row['NOMBRE']);
    }
    echo json_encode($data);
}

//==========================================================================================================================
//BUSCA LA INFORMACION DEL DESARROLLADOR -> SOLO A LOS NO OCULTOS
//==========================================================================================================================
if (isset($_POST['boleanoDesarrolladorNoOcultosSend'])) {

    if (!isset($_POST['buscarDesarrollador'])) {

        $fetchData = mysqli_query($conn, "SELECT * FROM desarrollador WHERE OCULTO = 0 ORDER BY NOMBRE");
    } else {
        $search = $_POST['buscarDesarrollador'];

        $fetchData = mysqli_query($conn, "SELECT * FROM desarrollador WHERE OCULTO = 0 AND NOMBRE like '%" . $search . "%' limit 5");
    }

    $data = array();

    while ($row = mysqli_fetch_array($fetchData)) {

        $data[] = array("id" => $row['ID_DESARROLLADOR'], "text" => $row['NOMBRE']);
    }
    echo json_encode($data);
}

//==========================================================================================================================
//BUSCA LA INFORMACION DEL NIVEL
//==========================================================================================================================
if (isset($_POST['boleanoNivelSend'])) {

    if (!isset($_POST['buscarNivel'])) {

        $fetchData = mysqli_query($conn, "SELECT * FROM nivel ORDER BY NIVEL");
    } else {
        $search = $_POST['buscarNivel'];

        $fetchData = mysqli_query($conn, "SELECT * FROM nivel where NIVEL like '%" . $search . "%' limit 5");
    }

    $data = array();

    while ($row = mysqli_fetch_array($fetchData)) {

        $data[] = array("id" => $row['ID_NIVEL'], "text" => $row['NIVEL']);
    }
    echo json_encode($data);
}

//==========================================================================================================================
//BUSCA LA INFORMACION DEL ESTATUS
//==========================================================================================================================
if (isset($_POST['boleanoEstatusSend'])) {

    if (!isset($_POST['buscarEstatus'])) {

        $fetchData = mysqli_query($conn, "SELECT * FROM estatus ORDER BY ESTATUS");
    } else {
        $search = $_POST['buscarEstatus'];

        $fetchData = mysqli_query($conn, "SELECT * FROM estatus where ESTATUS like '%" . $search . "%' limit 5");
    }

    $data = array();

    while ($row = mysqli_fetch_array($fetchData)) {

        $data[] = array("id" => $row['ID_ESTATUS'], "text" => $row['ESTATUS']);
    }
    echo json_encode($data);
}
