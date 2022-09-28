$(document).ready(function () {

    displayDataSoporte(); //DESPLIEGA LA FUNCIÓN


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
            console.log('Respuesta');
            $('#displayDataTableSoporte').html(data);
            $('#tabla_soporte').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },

            });
        }

    });
    
}