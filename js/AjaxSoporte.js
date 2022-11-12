/**
* SE CARGA CON UN ONFOCUS, ESTA COLOCADO EN LA PESTAÑA DE SOPORTE
*/

//MUESTRA LA TABLA DE LA PESTAÑA DE BUSCADOR DE SOPORTE
function displayDataSoporte() {


    const displayDataSoporte = true;

    $.ajax({
        url: "app/soporte.php",
        type: "POST",
        data: {
            displayDataSoporteSend: displayDataSoporte,
        },
        success: function (data, status) {

            $('#displayDataTableSoporte').html(data);
            $('#tabla_soporte').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },

            });
        }

    });

}

//AGREGA SOPORTE
function agregarSoporte() {

    const insertSoporte = true;

    const nombreSoporteAdd = $('#nombreSoporteAdd').val();
    const apellidoSoporteAdd = $('#apellidoSoporteAdd').val();
    const numeroSoperteAdd = $('#numeroSoperteAdd').val();
    const correoSoporteAdd = $('#correoSoporteAdd').val();

    if (nombreSoporteAdd == '' || apellidoSoporteAdd == '' || numeroSoperteAdd == '' || correoSoporteAdd == '' || isValidEmail(correoSoporteAdd) == false) {

        swal({
            title: "Comprueba los campos",
            icon: "error",
            button: "Cerrar",
        })
            .then(() => {

                $('#modalAgregarSoporte').modal("show")

            });


    } else {
        $.ajax({

            url: "app/soporte.php",
            type: "POST",
            data: { //INFORMACION QUE RECIBE PHP Send
                insertSoporteSend: insertSoporte,
                nombreSoporteAddSend: nombreSoporteAdd,
                apellidoSoporteAddSend: apellidoSoporteAdd,
                numeroSoperteAddSend: numeroSoperteAdd,
                correoSoporteAddSend: correoSoporteAdd,

            },
            success: function (data, status) {
                //SWEET ALERT
                swal({
                    title: "Soporte Agregado",
                    icon: "success",
                    button: "Cerrar",
                });

                limpiarSoporte();

                displayDataSoporte();

            }


        });
    }




}

//ELIMINA SOPORTE
function eliminarSoporte(id) {

    const eliminarSoporte = true;

    swal({
        title: "¿Estas seguro?",
        text: "Una vez eliminado, no podras recuperar a este soporte",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {

                $.ajax({

                    url: "app/soporte.php",
                    type: "POST",
                    data: {
                        eliminarSoporteSend: eliminarSoporte,
                        deleteSend: id
                    },
                    success: function (data, status) {

                        swal("Soporte Eliminado", {
                            icon: "success",

                        });

                        displayDataSoporte();//MOSTRAMOS LA TABLA ACTUALIZADA


                    }

                });



            } else {
                swal("El Soporte esta a salvo");
            }
        });



}

//OBTIENE LA INFORMACION PARA COLOCARLO EN EL MODAL DE VER
function getInfoSoporte(id) {

    const getInfoSoporte = true;

    $.post("app/soporte.php", {
        getInfoSoporteSend: getInfoSoporte,
        idSend: id
    }, function (data, status) {

        const soporte = JSON.parse(data);

        $('#idSoporteSee').val(soporte.ID_SOPORTE);
        $('#nombreSoporteSee').val(soporte.NOMBRE);
        $('#apellidoSoporteSee').val(soporte.APELLIDOS);
        $('#numeroSoperteSee').val(soporte.NUM_CELULAR);
        $('#correoSoporteSee').val(soporte.CORREO);
    });


    $('#modalInfoSoporte').modal("show");


}

//OBTIENE LA INFORMACION PARA COLOCARLO EN EL MODAL DE ACTUALIZAR
function actualizarGetInfoSoporte(id) {

    const getInfoUpdateSoporte = true;

    $.post("app/soporte.php", {
        getInfoUpdateSoporteSend: getInfoUpdateSoporte,
        idSend: id
    }, function (data, status) {

        const soporte = JSON.parse(data);

        $('#idHiddenSoporte').val(soporte.ID_SOPORTE);
        $('#nombreSoporteUpdate').val(soporte.NOMBRE);
        $('#apellidoSoporteUpdate').val(soporte.APELLIDOS);
        $('#numeroSoperteUpdaate').val(soporte.NUM_CELULAR);
        $('#correoSoporteUpdate').val(soporte.CORREO);
    });

    $('#modalEditarSoporte').modal("show");

}

//ACTUALIZA SOPORTE
function actualizarSoporte() {

    const actualizarSoporte = true;

    const idHidden = $('#idHiddenSoporte').val();
    const nombreActualizar = $('#nombreSoporteUpdate').val();
    const apellidoActualizar = $('#apellidoSoporteUpdate').val();
    const numeroActualizar = $('#numeroSoperteUpdaate').val();
    const correoActualizar = $('#correoSoporteUpdate').val();

    if (isValidEmail(correoActualizar) == false) {
        swal({
            title: "Coloca un correo valido",
            icon: "error",
            button: "Cerrar",
        })
            .then(() => {

                $('#modalEditarSoporte').modal("show")

            });
    } else {
        $.post("app/soporte.php", {

            nombreActualizarSend: nombreActualizar,
            idHiddenSend: idHidden,
            apellidoActualizarSend: apellidoActualizar,
            numeroActualizarSend: numeroActualizar,
            correoActualizarSend: correoActualizar,
            actualizarSoporteSend: actualizarSoporte

        }, function (data, status) {

            //SWEET ALERT
            swal({
                title: "Soporte Actualizado",
                icon: "success",
                button: "Cerrar",
            });

            displayDataSoporte();

        });
    }



}

//LIMPIA INPUT DE AGREGAR SOPORTE
function limpiarSoporte() {

    $('#nombreSoporteAdd').val('');
    $('#apellidoSoporteAdd').val('');
    $('#numeroSoperteAdd').val('');
    $('#correoSoporteAdd').val('');


}

//FUNCION PARA SABER SI ES UN CORREO VALIDO
function isValidEmail(email) {
    //Si falla cambiar por let
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}