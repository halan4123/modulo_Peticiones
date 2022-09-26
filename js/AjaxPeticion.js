$(document).ready(function () {

    displayData(); //DESPLIEGA LA FUNCIÓN

    buscadorLaboratorioSoporte();

});

//MUESTRA LA TABLA
function displayData() {

    let displayData = true;

    $.ajax({
        url: "app/peticion.php",
        type: "POST",
        data: {
            displayDataSend: displayData,
        },
        success: function (data, status) {
            $('#displayDataTable').html(data);
            $('#tabla_peticiones').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },

            });
        }

    });

}

//AGREGA UNA PETICIÓN
function agregar() {

    let insertData = true;

    let asuntoAdd = $('#asuntoAdd').val();
    let laboratorioAdd = $('#laboratorioAdd').val();
    let soporteAdd = $('#soporteAdd').val();
    let descripcionAdd = $('#descripcionAdd').val();
    let fechaEntregaEstimadaAdd = $('#fechaEntregaEstimadaAdd').val();
    let fechaCompletadoAdd = $('#fechaCompletadoAdd').val();
    let nivelAdd = $('#nivelAdd').val();
    let estatusAdd = $('#estatusAdd').val();
    let desarrolladorAdd = $('#desarrolladorAdd').val();

    if (
        asuntoAdd.length === 0 ||
        descripcionAdd.length === 0 ||
        laboratorioAdd === '0' ||
        soporteAdd === '0' ||
        laboratorioAdd === null ||
        soporteAdd === null

    ) {
        swal({
            title: "Completa todos los campos",
            icon: "error",
            button: "Cerrar",
        })
            .then(() => {

                $('#modalAgregar').modal("show")

            });
    } else {
        $.ajax({

            url: "app/peticion.php",
            type: "POST",
            data: { //INFORMACION QUE RECIBE PHP Send
                insertDataSend: insertData,
                asuntoSend: asuntoAdd,
                laboratorioSend: laboratorioAdd,
                fechaEntregaEstimadaSend: fechaEntregaEstimadaAdd,
                fechaCompletadoSend: fechaCompletadoAdd,
                soporteSend: soporteAdd,
                desarrolladorSend: desarrolladorAdd,
                nivelSend: nivelAdd,
                estatusSend: estatusAdd,
                descripcionSend: descripcionAdd,

            },
            success: function (data, status) {
                //SWEET ALERT
                swal({
                    title: "Petición Agregada",
                    icon: "success",
                    button: "Cerrar",
                });

                limpiarInput();
                //SE MUESTRA NUEVAMENTE LA TABLA ACTUALIZADA
                displayData();

            }


        });
    }



}


//OBTIENE LA INFORMACIÓN PARA COLOCARLA EN EL MODAL
function getInfo(id) {

    let getInfoData = true;

    $.post("app/peticion.php", {
        getInfoDataSend: getInfoData,
        idSend: id
    }, function (data, status) {

        let peticion = JSON.parse(data);

        $('#idSee').val(peticion.ID_PETICION);
        $('#asuntoSee').val(peticion.ASUNTO);
        $('#laboratorioSee').val(peticion.NOMLAB);
        $('#fecha_llegadaSee').val(peticion.FECHA_LLEGADA);
        $('#fecha_entregaSee').val(peticion.FECHA_ENTREGA_ESTIMADA);
        $('#fecha_completadoSee').val(peticion.FECHA_COMPLETADO);
        $('#soporteSee').val(peticion.NOMSOP);

        $('#desarrolladorSee').val(peticion.NOMDES);
        $('#nivelSee').val(peticion.NOMNIVEL);
        $('#estatusSee').val(peticion.NOMESTATUS);
        $('#descripcionSee').val(peticion.DESCRIPCION);
    });

    $('#modalVer').modal("show");

}

function actualizarGetInfo(id) {

    let getInfoData = true;

    $('#idHidden').val(id);

    $.post("app/peticion.php", {
        getInfoDataSend: getInfoData,
        idSend: id
    }, function (data, status) {

        let peticion = JSON.parse(data);

        $('#asuntoUpdate').val(peticion.ASUNTO);
        $('#fecha_llegadaUpdate').val(peticion.FECHA_LLEGADA);
        $('#fecha_entregaUpdate').val(peticion.FECHA_ENTREGA_ESTIMADA);
        $('#fecha_completadoUpdate').val(peticion.FECHA_COMPLETADO);
        $('#descripcionUpdate').val(peticion.DESCRIPCION);

       
        
    });

    $('#modalEditar').modal("show");
}

function actualizar() { 

    let actualizarData = true;

    let idHidden = $('#idHidden').val();
    let asuntoActualizar = $('#asuntoUpdate').val();
    let laboratorioActualizar = $('#laboratorioUpdate').val();
    let fechaEntregaActualizar = $('#fecha_entregaUpdate').val();
    let desarrolladorActualizar = $('#desarrolladorUpdate').val();
    let nivelActualizar = $('#nivelUpdate').val();
    let estatusActualizar = $('#estatusUpdate').val();
    let descripcionActualizar = $('#descripcionUpdate').val();

    $.post("app/peticion.php", {

        actualizarDataSend: actualizarData,
        idHiddenSend: idHidden,
        asuntoActualizarSend: asuntoActualizar,
        laboratorioActualizarSend: laboratorioActualizar,
        fechaEntregaActualizarSend: fechaEntregaActualizar,
        desarrolladorActualizarSend: desarrolladorActualizar,
        nivelActualizarSend: nivelActualizar,
        estatusActualizarSend: estatusActualizar,
        descripcionActualizarSend: descripcionActualizar
        

    }, function (data, status) {

        //SWEET ALERT
        swal({
            title: "Petición Actualizada",
            icon: "success",
            button: "Cerrar",
        });

        displayData();

    });
    
 }

//ELIMINA UNA PETICIÓN
function eliminar(id) {

    let eliminarData = true;

    $.ajax({

        url: "app/peticion.php",
        type: "POST",
        data: {
            eliminarDataSend: eliminarData,
            deleteSend: id
        },
        success: function (data, status) {

            swal({
                title: "¿Estas seguro?",
                text: "Una vez eliminado, no podras recuperar esta petición",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("Petición Eliminada", {
                            icon: "success",

                        });

                        displayData();//MOSTRAMOS LA TABLA ACTUALIZADA

                    } else {
                        swal("La petición esta a salvo!");
                    }
                });

        }

    });
}

//BUSCADORES PARA LOS SELECT2
function buscadorLaboratorioSoporte() {
    let boleanoLaboratorio = true;
    $("#laboratorioAdd").select2({
        placeholder: "Selecciona",
        ajax: {
            url: "app/autoCompleteLab.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    buscarLaboratorio: params.term,// search term
                    boleanoLaboratorioSend: boleanoLaboratorio
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });

    
    $("#laboratorioUpdate").select2({
        placeholder: "Selecciona",
        ajax: {
            url: "app/autoCompleteLab.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    buscarLaboratorio: params.term,// search term
                    boleanoLaboratorioSend: boleanoLaboratorio
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });

    let boleanoDesarrollador = true;
    $("#desarrolladorUpdate").select2({
        placeholder: "Selecciona",
        ajax: {
            url: "app/autoCompleteLab.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    buscarDesarrollador: params.term,// search term
                    boleanoDesarrolladorSend: boleanoDesarrollador
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });

    let boleanoSoporte = true;
    $("#soporteAdd").select2({
        placeholder: "Selecciona",
        ajax: {
            url: "app/autoCompleteLab.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    buscarSoporte: params.term, // search term
                    boleanoSoporteSend: boleanoSoporte
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });

    let boleanoNivel = true;
    $("#nivelUpdate").select2({

        placeholder: "Selecciona",
        ajax: {
            url: "app/autoCompleteLab.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    buscarNivel: params.term, // search term
                    boleanoNivelSend: boleanoNivel
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });

    let boleanoEstatus = true;
    $("#estatusUpdate").select2({
        placeholder: "Selecciona",
        ajax: {
            url: "app/autoCompleteLab.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    buscarEstatus: params.term, // search term
                    boleanoEstatusSend: boleanoEstatus
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });
}

//LIMPIAR INPUT
function limpiarInput() {

    $('#asuntoAdd').val('');
    $('#descripcionAdd').val('');
    $('#soporteAdd').val(null).trigger('change');
    $('#laboratorioAdd').val(null).trigger('change');
}

