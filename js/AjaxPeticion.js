$(document).ready(function () {

    //POR DEFECTO CUANDO EL DOCUMENTO CARGA LA PESTAÑA DE PENDIENTES
    displayDataPendientes();

    //CARGA LOS NUMEROS EN BADGES
    badgesAjax();

    //POSTERIORMENTE CARGAN TODOS LOS BUSCADORES DE SELECT2
    buscadoresSelect2();

    //EFECTO VISUAL POPOVER
    popoverVisual();

    //EDITOR DE TEXTO INTEGRADO
    trumbowygEditor();

});

//MUSTRA LOS NUMEROS JUNTO AL TITULO
function badgesAjax() {

    const badgesAjax = true;

    $.ajax({
        url: "app/badges.php",
        type: "POST",
        data: {
            badgesAjaxSend: badgesAjax,
        },
        success: function (data, status) {

            const datos = JSON.parse(data);


            $('#spanPeticionesPendientes').text(datos.pendientes);

            $('#spanPeticionesDesarrollo').text(datos.desarrollo);

            $('#spanPeticionesSinEnviar').text(datos.sinenviar);


        }

    });

}

//MUESTRA LA TABLA CON PETICIONES RECHAZADAS, COMPLETAS Y QUE NO HAN SIDO ENVIADAS, EN LA PESTAÑA DE PETICIONES POR ENVIAR
function displayDataCompletas() {

    const displayData = true;
    const displayDataCompleta = true;

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
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        titleAttr: 'Exportar a PDF',
                        pageSize: 'LEGAL',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        titleAttr: 'Exportar a excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        titleAttr: 'Exportar a csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        }
                    },

                ]


            });
        }

    });

}

//MUESTRA LA TABLA CON PETICIONES EN DESARROLLO Y QUE NO HAN SIDO ENVIADAS, EN LA PESTAÑA DE EN DESARROLLO
function displayDataDesarrollo() {

    const displayData = true;
    const displayDataDesarrollo = true;

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
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        titleAttr: 'Exportar a PDF',
                        pageSize: 'LEGAL',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        titleAttr: 'Exportar a excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        titleAttr: 'Exportar a csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        }
                    },

                ]


            });
        }

    });



}

//MUESTRA EL HISTORIAL EN CADA PETICION
function mostrarHistorial(id) {

    const displayHistorial = true;

    $.ajax({
        url: "app/historial.php",
        type: "POST",
        data: {
            displayHistorialSend: displayHistorial,
            idSend: id
        },
        success: function (data, status) {
            $('#display-historial').html(data);

            $('#tabla-historial').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                "bDestroy": true,
                searching: false,

            });

            $('#modalHistorialPeticion').modal("show")
        }

    });



}

//MUESTRA TABLA HISTORIAL EN ADMID GROUP
function mostrarModificacionesHistorial() {

    const displayHistorialModificacion = true;

    const filtroFechaInicio = $('#filtroFechaInicioModificaciones').val();
    const filtroFechaFinal = $('#filtroFechaFinalModificaciones').val();

    $.ajax({
        url: "app/historial.php",
        type: "POST",
        data: {
            displayHistorialModificacionSend: displayHistorialModificacion,
            filtroFechaInicioSend: filtroFechaInicio,
            filtroFechaFinalSend: filtroFechaFinal,
       
        },
        success: function (data, status) {
            $('#displayDataTableHistorialModificaciones').html(data);
            $('#tabla-historial-modificaciones').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        titleAttr: 'Exportar a PDF',
                        pageSize: 'LEGAL',
                       
                    },
                    {
                        extend: 'excelHtml5',
                        titleAttr: 'Exportar a excel',
                      
                    },
                    {
                        extend: 'csvHtml5',
                        titleAttr: 'Exportar a csv',
                        
                    },

                ]

            });
        }

    });

    
}

//MUESTRA LA TABLA CON PETICIONES PENDIENTES Y QUE NO HAN SIDO ENVIADAS, EN LA PESTAÑA DE PENDIENTES
function displayDataPendientes() {

    const displayData = true;
    const displayDataPendiente = true;

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

                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        titleAttr: 'Exportar a PDF',
                        pageSize: 'LEGAL',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        titleAttr: 'Exportar a excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        titleAttr: 'Exportar a csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        }
                    },

                ]


            });
        }

    });


}

//MUESTRA LA TABLA DE LA PESTAÑA DE BUSCADOR DE PETICIONES
function displayData() {

    const displayData = true;
    const displayDataFull = true;

    const filtroEstatus = $('#filtroEstatus').val();
    const filtroNivel = $('#filtroNivel').val();
    const filtroFechaInicio = $('#filtroFechaInicio').val();
    const filtroSoporte = $('#filtroSoportePeti').val();
    const filtroDesarrollador = $('#filtroDesarrolladorPeti').val();
    const filtroFechaFinal = $('#filtroFechaFinal').val();
    const filtroLaboratorio = $('#filtroLaboratorioPeti').val();


    $.ajax({
        url: "app/peticion.php",
        type: "POST",
        data: {
            displayDataSend: displayData,
            filtroFechaInicioSend: filtroFechaInicio,
            filtroFechaFinalSend: filtroFechaFinal,
            filtroLaboratorioSend: filtroLaboratorio,
            filtroNivelSend: filtroNivel,
            filtroEstatusSend: filtroEstatus,
            filtroSoporteSend: filtroSoporte,
            filtroDesarrolladorSend: filtroDesarrollador,
            displayDataFullSend: displayDataFull,
        },
        success: function (data, status) {
            $('#displayDataTable').html(data);
            $('#tabla_peticiones').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        titleAttr: 'Exportar a PDF',
                        pageSize: 'LEGAL',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        titleAttr: 'Exportar a excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        titleAttr: 'Exportar a csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                        }
                    },

                ]

            });
        }

    });

}

//AGREGA LA PETICIÓN
function agregar() {

    const insertData = true;

    const asuntoAdd = $('#asuntoAdd').val();
    const laboratorioAdd = $('#laboratorioAdd').val();
    const soporteAdd = $('#soporteAdd').val();
    const descripcionAdd = $('#descripcionAdd').val();
    const fechaEntregaEstimadaAdd = $('#fechaEntregaEstimadaAdd').val();
    const fechaCompletadoAdd = $('#fechaCompletadoAdd').val();
    const nivelAdd = $('#nivelAdd').val();
    const estatusAdd = $('#estatusAdd').val();
    const desarrolladorAdd = $('#desarrolladorAdd').val();

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
                desarrolladorSend: desarrolladorAdd,

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
                displayDataPendientes();

                //CARGA LOS BADGES ACTUALIZADOS
                badgesAjax();

            }


        });
    }



}

//OBTIENE LA INFORMACIÓN PARA COLOCARLA EN EL MODAL DE VER
function getInfo(id) {

    const getInfoData = true;

    const men = 'Sin Definir';

    $.post("app/peticion.php", {
        getInfoDataSend: getInfoData,
        idSend: id
    }, function (data, status) {

        const peticion = JSON.parse(data);

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

        $('#nivelSee').val(peticion.NOMNIVEL);
        $('#estatusSee').val(peticion.NOMESTATUS);
        $('#descripcionSee').trumbowyg('html', peticion.DESCRIPCION);//$('#descripcionSee').val(peticion.DESCRIPCION);

    });

    $('#modalVer').modal("show");

}

//COLOCA LA INFORMACIÓN CORRESPONDINTE EN EL MODAL DE ACTUALIZAR
function actualizarGetInfo(id, display) {

    const getInfoUpdatePeticion = true;

    $('#idHidden').val(id);
    $('#caso_display').val(display);

    $.post("app/peticion.php", {
        getInfoUpdatePeticionSend: getInfoUpdatePeticion,
        idSend: id
    }, function (data, status) {

        const peticion = JSON.parse(data);

        //VALIDACIONES PARA EL SELECT2 PARA QUE EL INPUT OBTENGA EL VALOR AL MOMENTO DE DAR CLICK EN ACTUALIZAR
        let desarrolladorOption;
        if (JSON.stringify(peticion.NOMDES) === JSON.stringify(null)) {
            desarrolladorOption = "<option value='" + peticion.ID_DESARROLLADOR + "' selected='selected'>" + 'Sin Definir' + "</option>";
        } else {
            desarrolladorOption = "<option value='" + peticion.ID_DESARROLLADOR + "' selected='selected'>" + peticion.NOMDES + "</option>";
        }

        const laboratorioOption = "<option value='" + peticion.ID_LABORATORIO + "' selected='selected'>" + peticion.NOMLAB + "</option>";

        const nivelOption = "<option value='" + peticion.ID_NIVEL + "' selected='selected'>" + peticion.NOMNIVEL + "</option>";

        const estatusOption = "<option value='" + peticion.ID_ESTATUS + "' selected='selected'>" + peticion.NOMESTATUS + "</option>";

        //ASIGNACIONES POR DEFECTO O CON EL VALOR QUE TENGAN DEL SELECT2
        $('#desarrolladorUpdate').append(desarrolladorOption).trigger('change');
        $('#laboratorioUpdate').append(laboratorioOption).trigger('change');
        $('#nivelUpdate').append(nivelOption).trigger('change');
        $('#estatusUpdate').append(estatusOption).trigger('change');

        //ASIGNACIONES NORMALES
        $('#asuntoUpdate').val(peticion.ASUNTO);
        $('#fecha_llegadaUpdate').val(peticion.FECHA_LLEGADA);
        $('#fecha_entregaUpdate').val(peticion.FECHA_ENTREGA_ESTIMADA);
        $('#fecha_completadoUpdate').val(peticion.FECHA_COMPLETADO);

        //ASIGNACION CON Trumbowyg
        $('#descripcionUpdate').trumbowyg('html', peticion.DESCRIPCION);//$('#descripcionUpdate').val(peticion.DESCRIPCION);

        //ASIGNACIONES HIDDEN PARA LA FUNCION DE ENVIAR WP
        $('#numeroCelularSoporte').val(peticion.NUMERO_SOPORTE);
        $('#soporte_Update').val(peticion.NOMSOP);
        $('#desarrollador_nombre').val(peticion.NOMDES);


    });

    $('#modalEditar').modal("show");
}

//ACTUALIZA LA PETICION
function actualizar() {

    const actualizarData = true;

    let enviado = true;

    const caso_display = $('#caso_display').val();

    const idHidden = $('#idHidden').val();
    const asuntoActualizar = $('#asuntoUpdate').val();
    const laboratorioActualizar = $('#laboratorioUpdate').val();
    const fechaEntregaActualizar = $('#fecha_entregaUpdate').val();
    const desarrolladorActualizar = $('#desarrolladorUpdate').val();
    const nivelActualizar = $('#nivelUpdate').val();
    const estatusActualizar = $('#estatusUpdate').val();
    // let estatusNombre = $("#estatusUpdate").text();
    const descripcionActualizar = $('#descripcionUpdate').val();//text

    const numeroCelularSoporte = $('#numeroCelularSoporte').val();

    let fechaLlegada = $('#fecha_llegadaUpdate').val();
    fechaLlegada = fechaLlegada.substring(0, 10);

    const soporteNombre = $('#soporte_Update').val()

    let fechaCompletado = $('#fecha_completadoUpdate').val()
    fechaCompletado = fechaCompletado.substring(0, 10);

    const desarrollador_wp = $('#desarrollador_nombre').val().trim();

    const laboratorio_wp = $('#laboratorioUpdate').text().trim();

    // console.log("desarrollador: " + JSON.stringify(desarrolladorActualizar));

    if (estatusActualizar == "2" || estatusActualizar == '3') {

        swal({
            title: "¿Enviar correo electronico y mensaje de whatsapp?",
            // icon: "images/wp.png",
            icon: "warning",
            buttons: ["No, no enviar", "Si, si enviar"],
            closeOnClickOutside: false,
            allowOutsideClick: false

        })
            .then((willSend) => {

                if (willSend) {

                    swal("Enviando Correo...", {
                        icon: "images/loading3.gif",
                        buttons: false,
                        closeOnClickOutside: false
                    });

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
                            title: "Correo enviado y ventana emergente de whatsapp abierta",
                            icon: "success",
                            button: "Cerrar",
                        });

                        if (estatusActualizar == "2") {
                            window.open('https://wa.me/52' + numeroCelularSoporte + '?text=La%20petición%20de%20*' + laboratorio_wp + '*%20con%20el%20asunto%20*' + asuntoActualizar + '*%20ha%20sido%20completada%20por%20*' + desarrollador_wp + '*%20y%20fue%20solicitada%20el%20*' + fechaLlegada + '*%20por%20*' + soporteNombre + '*');

                        } else {
                            window.open('https://wa.me/52' + numeroCelularSoporte + '?text=La%20petición%20de%20*' + laboratorio_wp + '*%20con%20el%20asunto%20*' + asuntoActualizar + '*%20ha%20sido%rechazada%20por%20*' + desarrollador_wp + '*%20y%20fue%20solicitada%20el%20*' + fechaLlegada + '*%20por%20*' + soporteNombre + '*');

                        }


                        if (caso_display == '1') {

                            displayData();
                            //CARGA LOS BADGES ACTUALIZADOS
                            badgesAjax();

                        } else if (caso_display == '2') {

                            displayDataPendientes();
                            //CARGA LOS BADGES ACTUALIZADOS
                            badgesAjax();

                        } else if (caso_display == '3') {

                            displayDataDesarrollo();
                            //CARGA LOS BADGES ACTUALIZADOS
                            badgesAjax();

                        } else {

                            displayDataCompletas();
                            //CARGA LOS BADGES ACTUALIZADOS
                            badgesAjax();
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

                        if (caso_display == '1') {

                            displayData();
                            //CARGA LOS BADGES ACTUALIZADOS
                            badgesAjax();
                        } else if (caso_display == '2') {

                            displayDataPendientes();
                            //CARGA LOS BADGES ACTUALIZADOS
                            badgesAjax();
                        } else if (caso_display == '3') {

                            displayDataDesarrollo();
                            //CARGA LOS BADGES ACTUALIZADOS
                            badgesAjax();
                        } else {

                            displayDataCompletas();
                            //CARGA LOS BADGES ACTUALIZADOS
                            badgesAjax();
                        }



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

            if (caso_display == '1') {

                displayData();
                //CARGA LOS BADGES ACTUALIZADOS
                badgesAjax();
            } else if (caso_display == '2') {

                displayDataPendientes();
                //CARGA LOS BADGES ACTUALIZADOS
                badgesAjax();
            } else if (caso_display == '3') {

                displayDataDesarrollo();
                //CARGA LOS BADGES ACTUALIZADOS
                badgesAjax();
            } else {

                displayDataCompletas();
                //CARGA LOS BADGES ACTUALIZADOS
                badgesAjax();
            }


        });


    }

}

//ELIMINA LA PETICIÓN
function eliminar(id, display) {

    const eliminarData = true;

    const caso_display = display;


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

                        if (caso_display == 1) {

                            displayData();
                            //CARGA LOS BADGES ACTUALIZADOS
                            badgesAjax();

                        } else if (caso_display == 2) {

                            displayDataPendientes();
                            //CARGA LOS BADGES ACTUALIZADOS
                            badgesAjax();

                        } else if (caso_display == 3) {

                            displayDataDesarrollo();
                            //CARGA LOS BADGES ACTUALIZADOS
                            badgesAjax();

                        } else if (caso_display == 4) {

                            displayDataCompletas();
                            //CARGA LOS BADGES ACTUALIZADOS
                            badgesAjax();
                        }


                    }

                });

            } else {
                swal("La petición esta a salvo!");
            }
        });


}

//BUSCADORES DE SELECT2
function buscadoresSelect2() {

    const boleanoLaboratorio = true;
    const boleanoSoporteNoOcultos = true;
    const boleanoDesarrolladorNoOcultos = true;
    const boleanoDesarrollador = true;
    const boleanoSoporte = true;
    const boleanoNivel = true;
    const boleanoEstatus = true;


    //===========================================================================
    //BUSCADORES EN EL MODAL DE AGREGAR PETICION
    //===========================================================================
    $("#laboratorioAdd").select2({
        placeholder: "Selecciona",
        theme: "bootstrap",
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

    $("#soporteAdd").select2({
        placeholder: "Selecciona",
        theme: "bootstrap",
        ajax: {
            url: "app/autoCompleteLab.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    buscarSoporte: params.term, // search term
                    boleanoSoporteNoOcultosSend: boleanoSoporteNoOcultos
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

    $("#desarrolladorAdd").select2({
        placeholder: "Selecciona",
        theme: "bootstrap",
        ajax: {
            url: "app/autoCompleteLab.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    buscarDesarrollador: params.term, // search term
                    boleanoDesarrolladorNoOcultosSend: boleanoDesarrolladorNoOcultos
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


    //===========================================================================
    //BUSCADORES EN EL MODAL DE ACTUALIZAR PETICION
    //===========================================================================
    $("#laboratorioUpdate").select2({
        placeholder: "Selecciona",
        theme: "bootstrap",
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

    $("#desarrolladorUpdate").select2({
        placeholder: "Selecciona",
        theme: "bootstrap",
        ajax: {
            url: "app/autoCompleteLab.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    buscarDesarrollador: params.term,// search term
                    boleanoDesarrolladorNoOcultosSend: boleanoDesarrolladorNoOcultos
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

    $("#nivelUpdate").select2({

        placeholder: "Selecciona",
        theme: "bootstrap",
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

    $("#estatusUpdate").select2({
        placeholder: "Selecciona",
        theme: "bootstrap",
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

    //===========================================================================
    //BUSCADORES EN LA PESTAÑA DE BUSCADOR DE PETICIONES
    //===========================================================================

    $("#filtroLaboratorioPeti").select2({
        placeholder: "Laboratorio",
        theme: "bootstrap",
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

    $("#filtroDesarrolladorPeti").select2({
        placeholder: "Desarrollador",
        theme: "bootstrap",
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

    $("#filtroSoportePeti").select2({
        placeholder: "Soporte",
        theme: "bootstrap",
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

    $("#filtroNivel").select2({

        placeholder: "Nivel",
        theme: "bootstrap",
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

    $("#filtroEstatus").select2({
        placeholder: "Estatus",
        theme: "bootstrap",
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

//LIMPIA LOS INPUTS EN AGREGAR PETICION
function limpiarInputAgregar() {
    $('#asuntoAdd').val('');
    $('#descripcionAdd').trumbowyg('html', '');
    $('#soporteAdd').val(null).trigger('change');
    $('#laboratorioAdd').val(null).trigger('change');
    $('#desarrolladorAdd').val(null).trigger('change');
}

//ENVIA MENSAJE DE PETICION COMPLETADA
function wp(id, asunto, celular, laboratorio, desarrollador, fechaLlegada, soporte) {

    const actualizarDesdeWp = true;

    swal({
        title: "¿Enviar correo electrónico y mensaje de whatsapp?",
        icon: "images/wp.png",
        buttons: ["No, no enviar", "Si, si enviar"],
        closeOnClickOutside: false,
        allowOutsideClick: false
    })
        .then((willSend) => {

            if (willSend) {

                swal("Enviando correo electrónico...", {
                    icon: "images/loading3.gif",
                    buttons: false,
                    closeOnClickOutside: false
                });

                $.post("app/peticion.php", {

                    actualizarDesdeWpSend: actualizarDesdeWp,
                    idSendWp: id,

                }, function (data, status) {

                    swal({
                        title: "Correo enviado y ventana emergente de whatsapp abierta",
                        icon: "success",
                        button: "Cerrar",
                    });

                    displayDataCompletas();
                    //CARGA LOS BADGES ACTUALIZADOS
                    badgesAjax();
                    window.open('https://wa.me/52' + celular + '?text=La%20petición%20de%20*' + laboratorio + '*%20con%20el%20asunto%20*' + asunto + '*%20ha%20sido%20completada%20por%20*' + desarrollador.trim() + '*%20y%20fue%20solicitada%20el%20*' + fechaLlegada + '*%20por%20*' + soporte + '*');

                });

            } else {


                swal({
                    title: "La petición no fue enviada",
                    icon: "warning",
                    button: "Cerrar",
                });



            }
        });


}

//ENVIA MENSAJE DE PETICION RECHAZADA
function wpRechazado(id, asunto, celular, laboratorio, desarrollador, fechaLlegada, soporte) {

    const actualizarDesdeWp = true;

    const fechaEnviado = moment().format("DD-MM-YYYY");

    swal({
        title: "¿Enviar correo electrónico y mensaje de whatsapp?",
        icon: "images/wp.png",
        buttons: ["No, no enviar", "Si, si enviar"],
        closeOnClickOutside: false,
        allowOutsideClick: false
    })
        .then((willSend) => {

            if (willSend) {

                swal("Enviando correo electrónico...", {
                    icon: "images/loading3.gif",
                    buttons: false,
                    closeOnClickOutside: false
                });


                $.post("app/peticion.php", {

                    actualizarDesdeWpSend: actualizarDesdeWp,
                    idSendWp: id,

                }, function (data, status) {

                    swal({
                        title: "Correo enviado y ventana emergente de whatsapp abierta",
                        icon: "success",
                        button: "Cerrar",
                    });

                    displayDataCompletas();

                    //CARGA LOS BADGES ACTUALIZADOS
                    badgesAjax();

                    window.open('https://wa.me/52' + celular + '?text=La%20petición%20de%20*' + laboratorio + '*%20con%20fecha%20de%20llegada%20*' + fechaLlegada + '*%20con%20el%20asunto%20*' + asunto + '*%20ha%20sido%20rechazada%20el%20*' + fechaEnviado + '*%20por%20*' + desarrollador + '*.');

                });

            } else {


                swal({
                    title: "La petición no fue enviada",
                    icon: "warning",
                    button: "Cerrar",
                });



            }
        });




}

//LIMPIA LOS FILTROS DE BUSQUEDA DE LAS PETICIONES EN LA PESTAÑA DE BUSCADOR DE PETICIONES
function limpiarFiltros() {


    const dia_acual = moment();

    $('#filtroNivel').val(null).trigger('change');
    $('#filtroLaboratorioPeti').val(null).trigger('change');
    $('#filtroEstatus').val(null).trigger('change');
    $('#filtroSoportePeti').val(null).trigger('change');
    $('#filtroDesarrolladorPeti').val(null).trigger('change');
    $('#filtroFechaInicio').val(dia_acual.format("yyyy-MM-DD"));
    //document.getElementById("filtroFechaInicio").value = date.format("yyyy-MM-DD");
    $('#filtroFechaFinal').val(dia_acual.format("yyyy-MM-DD"));







}

//Trumbowyg
function trumbowygEditor() {
    $('#descripcionAdd').trumbowyg({
        btns: [
            ['viewHTML'],
            ['formatting'],
            ['strong', 'em'],
            ['superscript', 'subscript'],
            ['link'],
            ['insertImage'],
            ['upload'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['horizontalRule'],
            ['removeformat'],
            ['emoji'],
            ['fullscreen']


        ],
        plugins: {

            upload: {
                serverPath: 'app/img.php',
                fileFieldName: 'image',
                headers: {
                    'Authorization': 'Client-ID xxxxxxxxxxxx'
                },
                urlPropertyName: 'file'
            }
        },
        autogrow: true
    });

    $('#descripcionSee').trumbowyg({
        btns: [
            ['viewHTML'],
            ['formatting'],
            ['strong', 'em'],
            ['superscript', 'subscript'],
            ['link'],
            ['insertImage'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['horizontalRule'],
            ['removeformat'],
            ['emoji'],
            ['fullscreen'],

        ],
        autogrow: true
    });

    $('#descripcionUpdate').trumbowyg({
        btns: [
            ['viewHTML'],
            ['formatting'],
            ['strong', 'em'],
            ['superscript', 'subscript'],
            ['link'],
            ['insertImage'],
            ['upload'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['horizontalRule'],
            ['removeformat'],
            ['emoji'],
            ['fullscreen'],

        ],
        plugins: {

            upload: {
                serverPath: 'app/img.php',
                fileFieldName: 'image',
                headers: {
                    'Authorization': 'Client-ID xxxxxxxxxxxx'
                },
                urlPropertyName: 'file'
            }
        },
        autogrow: true
    });
}

//POPOVER
function popoverVisual() {
    $('[data-toggle="popover"]').popover({
        html: true,
    });
}

//LIMPIAR FILTROS DE MODALES
function limpiarModal() {

    $('#desarrolladorAdd').val(null).trigger('change');

}

function limpiarLaboratorio() {
    $('#filtroLaboratorioPeti').val(null).trigger('change');
}

function limpiarNivel() {
    $('#filtroNivel').val(null).trigger('change');
}

function limpiarSoportew() {
    $('#filtroSoportePeti').val(null).trigger('change');
}

function limpiarDesarrolladorw() {
    $('#filtroDesarrolladorPeti').val(null).trigger('change');
}

function limpiarEstatusw() {
    $('#filtroEstatus').val(null).trigger('change');
}

function limpiarFiltrosModificaciones() {

    const dia_acual = moment();

    $('#filtroFechaInicioModificaciones').val(dia_acual.format("yyyy-MM-DD"));
    //document.getElementById("filtroFechaInicio").value = date.format("yyyy-MM-DD");
    $('#filtroFechaFinalModificaciones').val(dia_acual.format("yyyy-MM-DD"));
}

function soloNumeros(e) {

    const key = e.KeyCode || e.which;

    const teclado = String.fromCharCode(key);

    const numero = "0123456789";

    const especiales = "8-37-38-46";

    const teclado_especial = false;

    for (const i in especiales) {
        if (key == especiales[i]) {
            teclado_especial = true;

        }
    }

    if (numero.indexOf(teclado) == -1 && !teclado_especial) {
        return false;
    }


}

function insertarTexto(frase, textoAgregar, posicion) {
    return frase.slice(0, posicion) + textoAgregar + frase.slice(posicion);
}



