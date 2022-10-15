<?php

//RECIBIENDO DATOS DE LA IMAGEN
$datos_imagen = $_FILES['image'];

//DIRECTORIO DONDE SE GUARDARA LA IMAGEN
$directorio = '../upload/';

//GENERAR UN NOMBRE AL ARCHIVO
$clave = substr(md5(rand()), 0, 16);
$extension = pathinfo($datos_imagen['name'], PATHINFO_EXTENSION);
$nombre_archivo = $clave . "." . $extension;

//MOVER ARCHIVO
move_uploaded_file($datos_imagen['tmp_name'], $directorio . $nombre_archivo);

$retorno['success'] = true;

$retorno['file'] = "upload/" . $nombre_archivo;

echo json_encode($retorno);
