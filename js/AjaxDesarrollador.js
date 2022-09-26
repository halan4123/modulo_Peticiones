$(document).ready(function () {

    // displayData(); //DESPLIEGA LA FUNCIÓN
    displayDataDesarrollador();


});

function displayDataDesarrollador() {

    let displayDataDesarrollador = true;

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


function agregarDesarrollador() {

    let insertDesarrollador = true;

    let nombreDesarrolladorAdd = $('#nombreDesarrolladorAdd').val();
    let apellidoDesarrolladorAdd = $('#apellidoDesarrolladorAdd').val();

    console.log(nombreDesarrolladorAdd.length);

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

                displayDataDesarrollador();

            }


        });
    }



}

function eliminarDesarrollador(id) {

    let eliminarDesarrollador = true;

    $.ajax({

        url: "app/desarrollador.php",
        type: "POST",
        data: {
            eliminarDesarrolladorSend: eliminarDesarrollador,
            deleteSend: id
        },
        success: function (data, status) {

            swal({
                title: "¿Estas seguro?",
                text: "Una vez eliminado, no podras recuperar a este desarrollador",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("Desarrollador Eliminado", {
                            icon: "success",

                        });

                        displayDataDesarrollador();//MOSTRAMOS LA TABLA ACTUALIZADA

                    } else {
                        swal("El desarrollador esta a salvo");
                    }
                });

        }

    });
    
}

function getInfoDesarrollador(id) {

    let getInfoDesarrollador = true;

    $.post("app/desarrollador.php", {
        getInfoDesarrolladorSend: getInfoDesarrollador,
        idSend: id
    }, function (data, status) {

        let desarrollador = JSON.parse(data);

        $('#idDesarrolladorSee').val(desarrollador.ID_DESARROLLADOR);
        $('#nombreDesarrolladorSee').val(desarrollador.NOMBRE);
        $('#apellidoDesarrolladorSee').val(desarrollador.APELLIDOS);
    });

    $('#modalInfoDesarrollador').modal("show");
    
}