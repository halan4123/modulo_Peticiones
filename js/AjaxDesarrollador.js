/**
* SE CARGA CON UN ONFOCUS, ESTA COLOCADO EN LA PESTAÑA DE DESARROLLADORES
*/

//MUESTRA LA TABLA DE LA PESTAÑA DE BUSCADOR DE DESARROLLADORES
function displayDataDesarrollador() {

    const displayDataDesarrollador = true;

    $.ajax({
        url: "app/desarrollador.php",
        type: "POST",
        data: {
            displayDataDesarrolladorSend: displayDataDesarrollador,
        },
        success: function (data, status) {
            $('#displayDataTableDesarrollador').html(data);
            $('#tabla_desarrolladores').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },

            });
        }

    });

}

//AGREGA DESARROLLADOR
function agregarDesarrollador() {

    const insertDesarrollador = true;

    const nombreDesarrolladorAdd = $('#nombreDesarrolladorAdd').val();
    const apellidoDesarrolladorAdd = $('#apellidoDesarrolladorAdd').val();


    if (
        nombreDesarrolladorAdd.length === 0 || apellidoDesarrolladorAdd.length === 0
    ) {

        swal({
            title: "Completa todos los campos",
            icon: "error",
            button: "Cerrar",
        })
            .then(() => {

                $('#modalAgregarDesarrollador').modal("show")

            });

    } else {

        $.ajax({

            url: "app/desarrollador.php",
            type: "POST",
            data: { //INFORMACION QUE RECIBE PHP Send
                insertDesarrolladorSend: insertDesarrollador,
                nombreDesarrolladorAddSend: nombreDesarrolladorAdd,
                apellidoDesarrolladorAddSend: apellidoDesarrolladorAdd,

            },
            success: function (data, status) {
                //SWEET ALERT
                swal({
                    title: "Desarrollador Agregado",
                    icon: "success",
                    button: "Cerrar",
                });

                limpiarInput();
                displayDataDesarrollador();

            }


        });
    }



}

//ELIMINA DESARROLLADOR
function eliminarDesarrollador(id) {

    swal({
        title: "¿Estas seguro?",
        text: "Una vez eliminado, no podras recuperar a este desarrollador",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {

                const eliminarDesarrollador = true;

                $.ajax({

                    url: "app/desarrollador.php",
                    type: "POST",
                    data: {
                        eliminarDesarrolladorSend: eliminarDesarrollador,
                        deleteSend: id
                    },
                    success: function (data, status) {

                        swal("Desarrollador Eliminado", {
                            icon: "success",

                        });

                        displayDataDesarrollador();//MOSTRAMOS LA TABLA ACTUALIZADA

                    }

                });

            } else {
                swal("El desarrollador esta a salvo");
            }
        });



}

//OBTIENE LA INFORMACION PARA COLOCARLO EN EL MODAL DE VER
function getInfoDesarrollador(id) {

    const getInfoDesarrollador = true;

    $.post("app/desarrollador.php", {
        getInfoDesarrolladorSend: getInfoDesarrollador,
        idSend: id
    }, function (data, status) {

        const desarrollador = JSON.parse(data);

        $('#idDesarrolladorSee').val(desarrollador.ID_DESARROLLADOR);
        $('#nombreDesarrolladorSee').val(desarrollador.NOMBRE);
        $('#apellidoDesarrolladorSee').val(desarrollador.APELLIDOS);
    });

    $('#modalInfoDesarrollador').modal("show");

}

//OBTIENE LA INFORMACION PARA COLOCARLO EN EL MODAL DE ACTUALIZAR
function actualizarGetInfoDesarrollador(id) {

    const getInfoUpdateDesarrollador = true;

    $.post("app/desarrollador.php", {
        getInfoUpdateDesarrolladorSend: getInfoUpdateDesarrollador,
        idSend: id
    }, function (data, status) {

        const desarrollador = JSON.parse(data);

        $('#idHiddenDesarrollador').val(desarrollador.ID_DESARROLLADOR);
        $('#nombreDesarrolladorUpdate').val(desarrollador.NOMBRE);
        $('#apellidoDesarrolladorUpdate').val(desarrollador.APELLIDOS);
    });

    $('#modalEditarDesarrollador').modal("show");

}

//ACTUALIZA DESARROLLADOR
function actualizarDesarrollador() {

    const actualizarDesarrollador = true;

    const idHidden = $('#idHiddenDesarrollador').val();
    const nombreActualizar = $('#nombreDesarrolladorUpdate').val();
    const apellidoActualizar = $('#apellidoDesarrolladorUpdate').val();

    $.post("app/desarrollador.php", {

        nombreActualizarSend: nombreActualizar,
        idHiddenSend: idHidden,
        apellidoActualizarSend: apellidoActualizar,
        actualizarDesarrolladorSend: actualizarDesarrollador

    }, function (data, status) {

        //SWEET ALERT
        swal({
            title: "Desarrollador Actualizado",
            icon: "success",
            button: "Cerrar",
        });

        displayDataDesarrollador();

    });

}

//LIMPIA LOS INPUT DE AGREGAR DESARROLLADOR
function limpiarInput() {
    $('#nombreDesarrolladorAdd').val('');
    $('#apellidoDesarrolladorAdd').val('');
}