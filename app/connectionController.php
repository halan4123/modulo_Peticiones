<?php

define("HOST","localhost");
define("USER","root");
define("PSWR","");
define("DBNM","modulopeticiones");

//==========================================================================================================================
//FUNCION QUE CREA LA CONEXION A LA BASE DE DATOS EJEMPLO: $conn = connect();
//==========================================================================================================================
function connect(){
    
    $conn = new mysqli(HOST,USER,PSWR,DBNM);

    if($conn){

        return $conn;
    }
    return null;
}


?>