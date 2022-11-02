<?php
include 'connectionController.php';

$conn = connect();

//==========================================================================================================================
//BUSCA LA INFORMACION DE LABORATORIOS
//==========================================================================================================================
if (isset($_POST['boleanoLaboratorioSend'])) {

    if (!isset($_POST['buscarLaboratorio'])) {

        //PARA QUE SOLO APAREZCAN 5 O EL NUMERO QUE DESEES POR DEFECTO COLOCAR LIMIT N.O
        $stmt = $conn->prepare(
            "SELECT * FROM laboratorio ORDER BY NOMBRE"
        );

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();
    } else {

        $search = "%{$_POST['buscarLaboratorio']}%";

        $stmt = $conn->prepare(
            "SELECT * FROM laboratorio where NOMBRE like ? limit 5"
        );

        $stmt->bind_param("s", $search);

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();
    }

    $data = array();

    while ($row = mysqli_fetch_array($result)) {

        $data[] = array("id" => $row['ID_LABORATORIO'], "text" => $row['NOMBRE']);
    }

    echo json_encode($data);
}

//==========================================================================================================================
//BUSCA LA INFORMACION DEL SOPORTE -> INCLUSO A LOS OCULTOS
//==========================================================================================================================
if (isset($_POST['boleanoSoporteSend'])) {

    if (!isset($_POST['buscarSoporte'])) {

        $stmt = $conn->prepare(
            "SELECT * FROM soporte ORDER BY NOMBRE"
        );

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();
    } else {

        $search = "%{$_POST['buscarSoporte']}%";

        $stmt = $conn->prepare(
            "SELECT * FROM soporte where NOMBRE like ? limit 5"
        );

        $stmt->bind_param("s", $search);

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();
    }

    $data = array();

    while ($row = mysqli_fetch_array($result)) {

        $data[] = array("id" => $row['ID_SOPORTE'], "text" => $row['NOMBRE']);
    }
    echo json_encode($data);
}

//==========================================================================================================================
//BUSCA LA INFORMACION DEL SOPORTE -> SOLO A LOS NO OCULTOS
//==========================================================================================================================
if (isset($_POST['boleanoSoporteNoOcultosSend'])) {


    if (!isset($_POST['buscarSoporte'])) {

        $stmt = $conn->prepare(
            "SELECT * FROM soporte WHERE OCULTO = 0 ORDER BY NOMBRE"
        );

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();
    } else {

        $search = "%{$_POST['buscarSoporte']}%";

        $stmt = $conn->prepare(
            "SELECT * FROM soporte WHERE OCULTO = 0 AND NOMBRE LIKE ? LIMIT 5"
        );

        $stmt->bind_param("s", $search);

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();
    }

    $data = array();

    while ($row = mysqli_fetch_array($result)) {

        $data[] = array("id" => $row['ID_SOPORTE'], "text" => $row['NOMBRE']);
    }
    echo json_encode($data);
}

//==========================================================================================================================
//BUSCA LA INFORMACION DEL DESARROLLADOR
//==========================================================================================================================
if (isset($_POST['boleanoDesarrolladorSend'])) {

    if (!isset($_POST['buscarDesarrollador'])) {

        $stmt = $conn->prepare(
            "SELECT * FROM desarrollador ORDER BY NOMBRE"
        );

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();
    } else {

        $search = "%{$_POST['buscarDesarrollador']}%";

        $stmt = $conn->prepare(
            "SELECT * FROM desarrollador WHERE NOMBRE LIKE ? LIMIT 5"
        );

        $stmt->bind_param("s", $search);

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();
    }

    $data = array();

    while ($row = mysqli_fetch_array($result)) {

        $data[] = array("id" => $row['ID_DESARROLLADOR'], "text" => $row['NOMBRE']);
    }
    echo json_encode($data);
}

//==========================================================================================================================
//BUSCA LA INFORMACION DEL DESARROLLADOR -> SOLO A LOS NO OCULTOS
//==========================================================================================================================
if (isset($_POST['boleanoDesarrolladorNoOcultosSend'])) {

    if (!isset($_POST['buscarDesarrollador'])) {

        $stmt = $conn->prepare(
            "SELECT * FROM desarrollador WHERE OCULTO = 0 ORDER BY NOMBRE"
        );

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();
    } else {

        $search = "%{$_POST['buscarDesarrollador']}%";

        $stmt = $conn->prepare(
            "SELECT * FROM desarrollador WHERE OCULTO = 0 AND NOMBRE LIKE ? LIMIT 5"
        );

        $stmt->bind_param("s", $search);

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();
    }

    $data = array();

    while ($row = mysqli_fetch_array($result)) {

        $data[] = array("id" => $row['ID_DESARROLLADOR'], "text" => $row['NOMBRE']);
    }
    echo json_encode($data);
}

//==========================================================================================================================
//BUSCA LA INFORMACION DEL NIVEL
//==========================================================================================================================
if (isset($_POST['boleanoNivelSend'])) {

    if (!isset($_POST['buscarNivel'])) {

        $stmt = $conn->prepare(
            "SELECT * FROM nivel ORDER BY NIVEL"
        );

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();
    } else {

        $search = "%{$_POST['buscarNivel']}%";

        $stmt = $conn->prepare(
            "SELECT * FROM nivel WHERE NIVEL LIKE ? LIMIT 5"
        );

        $stmt->bind_param("s", $search);

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();
    }

    $data = array();

    while ($row = mysqli_fetch_array($result)) {

        $data[] = array("id" => $row['ID_NIVEL'], "text" => $row['NIVEL']);
    }
    echo json_encode($data);
}

//==========================================================================================================================
//BUSCA LA INFORMACION DEL ESTATUS
//==========================================================================================================================
if (isset($_POST['boleanoEstatusSend'])) {

    if (!isset($_POST['buscarEstatus'])) {

        $stmt = $conn->prepare(
            "SELECT * FROM estatus ORDER BY ESTATUS"
        );

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();
    } else {

        $search = "%{$_POST['buscarEstatus']}%";

        $stmt = $conn->prepare(
            "SELECT * FROM estatus WHERE ESTATUS LIKE ? LIMIT 5"
        );

        $stmt->bind_param("s", $search);

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();
    }

    $data = array();

    while ($row = mysqli_fetch_array($result)) {

        $data[] = array("id" => $row['ID_ESTATUS'], "text" => $row['ESTATUS']);
    }
    echo json_encode($data);
}

