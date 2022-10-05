$(document).ready(function () {

    displayDataPendientes();

    buscadorLaboratorioSoporte();

});

function displayDataCompletas() {

    let displayData = true;
    let displayDataCompleta = true;

    $.ajax({
        url: "app/peticion.php",
        type: "POST",
        data: {
            displayDataSend: displayData,
            displayDataCompletaSend: displayDataCompleta
        },
        success: function (data, status) {
            $('#displayDataTableCompletadas').html(data);
            $('#tabla_peticiones_coompletadas').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },


            });
        }

    });

}

function displayDataDesarrollo() {

    let displayData = true;
    let displayDataDesarrollo = true;

    $.ajax({
        url: "app/peticion.php",
        type: "POST",
        data: {
            displayDataSend: displayData,
            displayDataDesarrolloSend: displayDataDesarrollo
        },
        success: function (data, status) {
            $('#displayDataTableDesarrolloo').html(data);
            $('#tabla_peticiones_desarrollo').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },


            });
        }

    });



}

function displayDataPendientes() {

    let displayData = true;
    let displayDataPendiente = true;

    $.ajax({
        url: "app/peticion.php",
        type: "POST",
        data: {
            displayDataSend: displayData,
            displayDataPendienteSend: displayDataPendiente
        },
        success: function (data, status) {
            $('#displayDataTablePendiente').html(data);
            $('#tabla_peticiones_pendientes').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },


            });
        }

    });


}

//MUESTRA LA TABLA
function displayData() {

    let displayData = true;
    let displayDataFull = true;

    let filtroEstatus = $('#filtroEstatus').val();
    let filtroNivel = $('#filtroNivel').val();
    let filtroFechaInicio = $('#filtroFechaInicio').val();
    let filtroFechaFinal = $('#filtroFechaFinal').val();
    let filtroLaboratorio = $('#filtroLaboratorio').val();

    $.ajax({
        url: "app/peticion.php",
        type: "POST",
        data: {
            displayDataSend: displayData,
            filtroEstatusSend: filtroEstatus,
            filtroNivelSend: filtroNivel,
            filtroFechaInicioSend: filtroFechaInicio,
            filtroFechaFinalSend: filtroFechaFinal,
            filtroLaboratorioSend: filtroLaboratorio,
            displayDataFullSend: displayDataFull,
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

                limpiarInputAgregar();

                //SE MUESTRA NUEVAMENTE LA TABLA ACTUALIZADA
                displayData();
                displayDataPendientes();

            }


        });
    }



}

//OBTIENE LA INFORMACIÓN PARA COLOCARLA EN EL MODAL
function getInfo(id) {

    let getInfoData = true;

    let men = 'Sin Definir';

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

        if (peticion.NOMDES === null) {
            $('#desarrolladorSee').val(men);
        } else {
            $('#desarrolladorSee').val(peticion.NOMDES);
        }


        //
        $('#nivelSee').val(peticion.NOMNIVEL);
        $('#estatusSee').val(peticion.NOMESTATUS);
        $('#descripcionSee').val(peticion.DESCRIPCION);


    });

    $('#modalVer').modal("show");

}

function actualizarGetInfo(id) {

    let getInfoUpdatePeticion = true;

    $('#idHidden').val(id);

    $.post("app/peticion.php", {
        getInfoUpdatePeticionSend: getInfoUpdatePeticion,
        idSend: id
    }, function (data, status) {



        let peticion = JSON.parse(data);

        //console.log(peticion.ID_DESARROLLADOR + ' ' + peticion.NOMDES); 0 & null

        let desarrolladorOption = "<option value='" + peticion.ID_DESARROLLADOR + "' selected='selected'>" + peticion.NOMDES + "</option>";

        let laboratorioOption = "<option value='" + peticion.ID_LABORATORIO + "' selected='selected'>" + peticion.NOMLAB + "</option>";

        let nivelOption = "<option value='" + peticion.ID_NIVEL + "' selected='selected'>" + peticion.NOMNIVEL + "</option>";

        let estatusOption = "<option value='" + peticion.ID_ESTATUS + "' selected='selected'>" + peticion.NOMESTATUS + "</option>";

        $('#asuntoUpdate').val(peticion.ASUNTO);
        $('#fecha_llegadaUpdate').val(peticion.FECHA_LLEGADA);
        $('#fecha_entregaUpdate').val(peticion.FECHA_ENTREGA_ESTIMADA);
        $('#fecha_completadoUpdate').val(peticion.FECHA_COMPLETADO);
        $('#descripcionUpdate').val(peticion.DESCRIPCION);


        $('#numeroCelularSoporte').val(peticion.NUMERO_SOPORTE);
        $('#soporte_Update').val(peticion.NOMSOP);
        $('#desarrollador_nombre').val(peticion.NOMDES);

        //ASIGNACIONES DEL SELECT2
        $('#desarrolladorUpdate').append(desarrolladorOption).trigger('change');
        $('#laboratorioUpdate').append(laboratorioOption).trigger('change');
        $('#nivelUpdate').append(nivelOption).trigger('change');
        $('#estatusUpdate').append(estatusOption).trigger('change');


    });

    $('#modalEditar').modal("show");
}

function actualizar() {

    let actualizarData = true;

    let enviado = true;

    let idHidden = $('#idHidden').val();
    let asuntoActualizar = $('#asuntoUpdate').val();
    let laboratorioActualizar = $('#laboratorioUpdate').val();
    let fechaEntregaActualizar = $('#fecha_entregaUpdate').val();
    let desarrolladorActualizar = $('#desarrolladorUpdate').val();
    let nivelActualizar = $('#nivelUpdate').val();
    let estatusActualizar = $('#estatusUpdate').val();
    // let estatusNombre = $("#estatusUpdate").text();
    let descripcionActualizar = $('#descripcionUpdate').val();//text

    let numeroCelularSoporte = $('#numeroCelularSoporte').val();

    let fechaLlegada = $('#fecha_llegadaUpdate').val();
    fechaLlegada = fechaLlegada.substring(0, 10);

    let soporteNombre = $('#soporte_Update').val()

    let fechaCompletado = $('#fecha_completadoUpdate').val()
    fechaCompletado = fechaCompletado.substring(0, 10);

    let desarrollador_wp = $('#desarrollador_nombre').val().trim();

    let laboratorio_wp = $('#laboratorioUpdate').text().trim();

    //$('#laboratorioUpdate').text().trim()
    // console.log("desarrollador: " + JSON.stringify(desarrolladorActualizar));

    if (estatusActualizar == "2") {

        swal({
            title: "¿Te gustaria enviar el mensaje de Whatsapp?",
            icon: "images/wp.png",
            buttons: ["No, no enviar", "Si, si enviar"],
            closeOnClickOutside: false,
            allowOutsideClick: false

        })
            .then((willSend) => {

                if (willSend) {

                    $.post("app/peticion.php", {

                        actualizarDataSend: actualizarData,
                        idHiddenSend: idHidden,
                        asuntoActualizarSend: asuntoActualizar,
                        laboratorioActualizarSend: laboratorioActualizar,
                        fechaEntregaActualizarSend: fechaEntregaActualizar,
                        desarrolladorActualizarSend: desarrolladorActualizar,
                        nivelActualizarSend: nivelActualizar,
                        estatusActualizarSend: estatusActualizar,
                        descripcionActualizarSend: descripcionActualizar,
                        enviadoSend: enviado,

                    }, function (data, status) {

                        swal({
                            title: "Petición Actualizada y ventana emergente de whatsapp abierta",
                            icon: "success",
                            button: "Cerrar",
                        });

                        window.open('https://wa.me/52' + numeroCelularSoporte + '?text=La%20petición%20de%20*' + laboratorio_wp + '*%20con%20el%20asunto%20*' + asuntoActualizar + '*%20ha%20sido%20completada%20el%20*' + fechaCompletado + '*%20por%20*' + desarrollador_wp + '*%20y%20fue%20solicitada%20el%20*' + fechaLlegada + '*%20por%20*' + soporteNombre + '*');

                        displayData();
                        displayDataPendientes();
                        displayDataDesarrollo();
                        displayDataCompletas();


                    });

                } else {

                    enviado = false;

                    $.post("app/peticion.php", {

                        actualizarDataSend: actualizarData,
                        idHiddenSend: idHidden,
                        asuntoActualizarSend: asuntoActualizar,
                        laboratorioActualizarSend: laboratorioActualizar,
                        fechaEntregaActualizarSend: fechaEntregaActualizar,
                        desarrolladorActualizarSend: desarrolladorActualizar,
                        nivelActualizarSend: nivelActualizar,
                        estatusActualizarSend: estatusActualizar,
                        descripcionActualizarSend: descripcionActualizar,
                        enviadoSend: enviado,

                    }, function (data, status) {

                        swal({
                            title: "Petición Actualizada",
                            icon: "success",
                            button: "Cerrar",
                        });

                        displayData();
                        displayDataPendientes();
                        displayDataDesarrollo();
                        displayDataCompletas();


                    });


                }
            });



    } else {

        enviado = false;

        $.post("app/peticion.php", {

            actualizarDataSend: actualizarData,
            idHiddenSend: idHidden,
            asuntoActualizarSend: asuntoActualizar,
            laboratorioActualizarSend: laboratorioActualizar,
            fechaEntregaActualizarSend: fechaEntregaActualizar,
            desarrolladorActualizarSend: desarrolladorActualizar,
            nivelActualizarSend: nivelActualizar,
            estatusActualizarSend: estatusActualizar,
            descripcionActualizarSend: descripcionActualizar,
            enviadoSend: enviado,

        }, function (data, status) {

            swal({
                title: "Petición Actualizada",
                icon: "success",
                button: "Cerrar",
            });

            displayData();
            displayDataPendientes();
            displayDataDesarrollo();
            displayDataCompletas();


        });


    }





    //     actualizarDataSend: actualizarData,
    //     idHiddenSend: idHidden,
    //     asuntoActualizarSend: asuntoActualizar,
    //     laboratorioActualizarSend: laboratorioActualizar,
    //     fechaEntregaActualizarSend: fechaEntregaActualizar,
    //     desarrolladorActualizarSend: desarrolladorActualizar,
    //     nivelActualizarSend: nivelActualizar,
    //     estatusActualizarSend: estatusActualizar,
    //     descripcionActualizarSend: descripcionActualizar,
    //     enviadoSend: enviado,

    // }, function (data, status) {

    //     if (estatusActualizar == "2") {
    //         swal({
    //             title: "¿Te gustaria enviar el mensaje de Whatsapp?",
    //             icon: "images/wp.png",
    //             buttons: ["No, no enviar", "Si, si enviar"],
    //             closeOnClickOutside: false,
    //             allowOutsideClick: false

    //         })
    //             .then((willSend) => {

    //                 if (willSend) {

    //                     swal({
    //                         title: "Petición Actualizada y ventana emergente de whatsapp abierta",
    //                         icon: "success",
    //                         button: "Cerrar",
    //                     });

    //                     window.open('https://wa.me/52' + numeroCelularSoporte + '?text=La%20petición%20de%20*' + laboratorio_wp + '*%20con%20el%20asunto%20*' + asuntoActualizar + '*%20ha%20sido%20completada%20el%20*' + fechaCompletado + '*%20por%20*' + desarrollador_wp + '*%20y%20fue%20solicitada%20el%20*' + fechaLlegada + '*%20por%20*' + soporteNombre + '*');

    //                     displayData();
    //                     displayDataPendientes();
    //                     displayDataDesarrollo();
    //                     displayDataCompletas();


    //                 } else {

    //                     swal({
    //                         title: "Petición Actualizada",
    //                         icon: "success",
    //                         button: "Cerrar",
    //                     });

    //                     displayData();
    //                     displayDataPendientes();
    //                     displayDataDesarrollo();

    //                 }
    //             });

    //     } else {
    //         swal({
    //             title: "Petición Actualizada",
    //             icon: "success",
    //             button: "Cerrar",
    //         });

    //         displayData();
    //         displayDataPendientes();
    //         displayDataDesarrollo();
    //     }

    // });

}

//ELIMINA UNA PETICIÓN
function eliminar(id) {

    let eliminarData = true;

    swal({
        title: "¿Estas seguro?",
        text: "Una vez eliminado, no podras recuperar esta petición",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {

                $.ajax({

                    url: "app/peticion.php",
                    type: "POST",
                    data: {
                        eliminarDataSend: eliminarData,
                        deleteSend: id
                    },
                    success: function (data, status) {

                        swal("Petición Eliminada", {
                            icon: "success",

                        });

                        displayData();//MOSTRAMOS LA TABLA ACTUALIZADA
                        displayDataPendientes();
                        displayDataDesarrollo();
                        displayDataCompletas();
                    }

                });

            } else {
                swal("La petición esta a salvo!");
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

//LIMPIAR INPUT AGREGAR
function limpiarInputAgregar() {
    $('#asuntoAdd').val('');
    $('#descripcionAdd').val('');
    $('#soporteAdd').val(null).trigger('change');
    $('#laboratorioAdd').val(null).trigger('change');
}

//Al momento de presionar el boton de Wp en la sección de completadas sin enviar, se completa y se va
//A la tabla de los filtros
function wp(id, asunto, celular,laboratorio,fechaCompletado, desarrollador,fechaLlegada, soporte) {


    let actualizarDesdeWp = true;

    console.log(id);
    console.log(asunto);

    console.log(celular);
    console.log(laboratorio);
    console.log(fechaCompletado);
    console.log(desarrollador);
    console.log(fechaLlegada);
    console.log(soporte);

    swal({
        title: "¿Te gustaria enviar el mensaje de Whatsapp?",
        icon: "images/wp.png",
        buttons: ["No, no enviar", "Si, si enviar"],
        closeOnClickOutside: false,
        allowOutsideClick: false
    })
        .then((willSend) => {

            if (willSend) {


                $.post("app/peticion.php", {

                    actualizarDesdeWpSend: actualizarDesdeWp,
                    idSendWp: id,

                }, function (data, status) {

                    // displayData();
                    // displayDataPendientes();
                    // displayDataDesarrollo();
                    displayDataCompletas();

                    window.open('https://wa.me/52' + celular + '?text=La%20petición%20de%20*' + laboratorio + '*%20con%20el%20asunto%20*' + asunto + '*%20ha%20sido%20completada%20el%20*' + fechaCompletado + '*%20por%20*' + desarrollador + '*%20y%20fue%20solicitada%20el%20*' + fechaLlegada + '*%20por%20*' + soporte + '*');

                });

            } else {


                swal({
                    title: "La Petición No Fue Enviada",
                    icon: "warning",
                    button: "Cerrar",
                });



            }
        });





}

