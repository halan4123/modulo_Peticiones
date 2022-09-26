<?php
include 'connectionController.php';

$conn = connect();

if (isset($_POST['boleanoLaboratorioSend'])) {

    if (!isset($_POST['buscarLaboratorio'])) {

        $fetchData = mysqli_query($conn,"SELECT * FROM laboratorio ORDER BY NOMBRE");
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

if (isset($_POST['boleanoSoporteSend'])) {

    if (!isset($_POST['buscarSoporte'])) {

        $fetchData = mysqli_query($conn,"SELECT * FROM soporte ORDER BY NOMBRE");
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

if (isset($_POST['boleanoDesarrolladorSend'])) {

    if (!isset($_POST['buscarDesarrollador'])) {

        $fetchData = mysqli_query($conn,"SELECT * FROM desarrollador ORDER BY NOMBRE");
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

if (isset($_POST['boleanoNivelSend'])) {

    if (!isset($_POST['buscarNivel'])) {

        $fetchData = mysqli_query($conn,"SELECT * FROM nivel ORDER BY NIVEL");
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

if (isset($_POST['boleanoEstatusSend'])) {

    if (!isset($_POST['buscarEstatus'])) {

        $fetchData = mysqli_query($conn,"SELECT * FROM estatus ORDER BY ESTATUS");
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


