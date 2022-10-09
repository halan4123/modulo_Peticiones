$(document).ready(function () {

    //displayDataSoporte(); //DESPLIEGA LA FUNCIÓN


});

function displayDataSoporte() {


    let displayDataSoporte = true;

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

function agregarSoporte() {

    let insertSoporte = true;

    let nombreSoporteAdd = $('#nombreSoporteAdd').val();
    let apellidoSoporteAdd = $('#apellidoSoporteAdd').val();
    let numeroSoperteAdd = $('#numeroSoperteAdd').val();
    let correoSoporteAdd = $('#correoSoporteAdd').val();


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

function eliminarSoporte(id) {

    let eliminarSoporte = true;

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

function getInfoSoporte(id) {

    let getInfoSoporte = true;

    $.post("app/soporte.php", {
        getInfoSoporteSend: getInfoSoporte,
        idSend: id
    }, function (data, status) {

        let soporte = JSON.parse(data);

        $('#idSoporteSee').val(soporte.ID_SOPORTE);
        $('#nombreSoporteSee').val(soporte.NOMBRE);
        $('#apellidoSoporteSee').val(soporte.APELLIDOS);
        $('#numeroSoperteSee').val(soporte.NUM_CELULAR);
        $('#correoSoporteSee').val(soporte.CORREO);
    });


    $('#modalInfoSoporte').modal("show");


}

function actualizarGetInfoSoporte(id) {

    let getInfoUpdateSoporte = true;

    $.post("app/soporte.php", {
        getInfoUpdateSoporteSend: getInfoUpdateSoporte,
        idSend: id
    }, function (data, status) {

        let soporte = JSON.parse(data);

        $('#idHiddenSoporte').val(soporte.ID_SOPORTE);
        $('#nombreSoporteUpdate').val(soporte.NOMBRE);
        $('#apellidoSoporteUpdate').val(soporte.APELLIDOS);
        $('#numeroSoperteUpdaate').val(soporte.NUM_CELULAR);
        $('#correoSoporteUpdate').val(soporte.CORREO);
    });

    $('#modalEditarSoporte').modal("show");

}


function actualizarSoporte() {

    let actualizarSoporte = true;

    let idHidden = $('#idHiddenSoporte').val();
    let nombreActualizar = $('#nombreSoporteUpdate').val();
    let apellidoActualizar = $('#apellidoSoporteUpdate').val();
    let numeroActualizar = $('#numeroSoperteUpdaate').val();
    let correoActualizar = $('#correoSoporteUpdate').val();

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

function limpiarSoporte() {

    $('#nombreSoporteAdd').val('');
    $('#apellidoSoporteAdd').val('');
    $('#numeroSoperteAdd').val('');
    $('#correoSoporteAdd').val('');


}