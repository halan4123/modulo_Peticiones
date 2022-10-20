/**
* SE CARGA LA FUNCION DE BUSCADORLAB GRAFICAS
* DESDEN UN ONFOCUS EN LA PESTAÑA DE ESTADISTICAS DE LABORATORIOS
*/
$(document).ready(function () {

    $('#rendimiento_2').hide(); //oculto mediante id
    $("#opcion_1").attr('disabled', 'disabled');
    $('#filtroMonthDes').hide();
    $('#buscar_opcion_2').hide();
    $('#limpiar_opcion_2').hide();
    $('#filtroDes_opcion_2').hide();

});


//GRAFICA LA PRIMERA SECCION DE ESTADISTICAS GENERALES
function graficarEstadisticasGenerales() {

    let fechaInicio = $('#filtroFechaInicioGraficos').val();
    let fechaFinal = $('#filtroFechaFinalGraficos').val();

    let desarrolladorDatos = true;
    let soporteDatos = true;

    //GRAFICA DE PETICIONES POR DESARROLLADOR
    $.post("app/graficas.php", {

        desarrolladorDatosSend: desarrolladorDatos,
        fechaInicioSend: fechaInicio,
        fechaFinalSend: fechaFinal,

    }, function (data, status) {

        let datos = JSON.parse(data);

        document.getElementById("peticionesAceptadasDesarrolladores").remove();

        let canvas1 = document.createElement("canvas");
        canvas1.id = "peticionesAceptadasDesarrolladores";
        document.getElementById("contenedor-desarrollador").appendChild(canvas1);


        const ctxDesarrollador = document.getElementById('peticionesAceptadasDesarrolladores').getContext('2d');
        //const ctxDesarrollador = $('#peticionesAceptadasDesarrolladores');
        const myChartDesarrollador = new Chart(ctxDesarrollador, {
            type: 'pie',
            data: {
                labels: datos.nombre,
                datasets: [{
                    label: 'Peticiones Por Desarrollador',
                    data: datos.datos,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1,
                    datalabels: {
                        color: function (context) {
                            let index = context.dataIndex;
                            let value = context.dataset.data[index];
                            return value <= 0 ? 'rgba(255, 255, 255, 0)' :  // draw negative values in red
                                'black';      // else

                        }
                    }
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
            }
        });

    });

    //GRAFICA DE PETICIONES POR SOPORTE
    $.post("app/graficas.php", {

        soporteDatosSend: soporteDatos,
        fechaInicioSend: fechaInicio,
        fechaFinalSend: fechaFinal,

    }, function (data, status) {

        let datosSoporte = JSON.parse(data);

        document.getElementById("peticionesRegistradasSoporte").remove();

        let canvas2 = document.createElement("canvas");
        canvas2.id = "peticionesRegistradasSoporte";
        document.getElementById("contenedor-soporte").appendChild(canvas2);

        const ctxSoporte = document.getElementById('peticionesRegistradasSoporte').getContext('2d');
        //const ctxSoporte = $('#peticionesRegistradasSoporte');
        const myChartSoporte = new Chart(ctxSoporte, {
            type: 'pie',
            data: {
                labels: datosSoporte.nombre,
                datasets: [{
                    label: 'Peticiones Por Desarrollador',
                    data: datosSoporte.datos,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1,
                    datalabels: {
                        color: function (context) {
                            let index = context.dataIndex;
                            let value = context.dataset.data[index];
                            return value <= 0 ? 'rgba(255, 255, 255, 0)' :  // draw negative values in red
                                'black';      // else

                        }
                    }
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
            },

        });

    });


}

//GRAFICA LA SEGUNDA SECCION DE ESTADISTICAS GENERALES
function graficarAnualmente() {

    let year = $('#filtroAnualGrafica_3').val();

    let anualMix = true;
    let anualDatos = true;
    let anualDatosCompletadas = true;
    let anualDatosRechazadas = true;


    //GRAFICA DE PETICIONES MIX
    $.post("app/graficas.php", {

        anualMixSend: anualMix,
        yearSend: year,

    }, function (data, status) {

        let datosAnualMix = JSON.parse(data);

        document.getElementById("peticionesMix").remove();

        let canvasMix = document.createElement("canvas");
        canvasMix.id = "peticionesMix";
        document.getElementById("contenedorMix").appendChild(canvasMix);

        const ctx = document.getElementById('peticionesMix').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre',],
                datasets: [{
                    label: 'Recibidas',
                    data: datosAnualMix.datosRegistrados,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(255, 255, 255, 0.1)',
                    datalabels: {
                        color: function (context) {
                            let index = context.dataIndex;
                            let value = context.dataset.data[index];
                            return value <= 0 ? 'rgba(255, 255, 255, 0)' :  // draw negative values in red
                                'rgba(255, 255, 255, 0)';      // else

                        }
                    }
                },
                {
                    label: 'Completadas',
                    data: datosAnualMix.datosCompletados,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(255, 255, 255, 0.1)',
                    datalabels: {
                        color: function (context) {
                            let index = context.dataIndex;
                            let value = context.dataset.data[index];
                            return value <= 0 ? 'rgba(255, 255, 255, 0)' :  // draw negative values in red
                                'rgba(255, 255, 255, 0)';      // else

                        }
                    }
                },
                {
                    label: 'Rechazadas',
                    data: datosAnualMix.datosRechazados,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 255, 255, 0.1)',
                    datalabels: {
                        color: function (context) {
                            let index = context.dataIndex;
                            let value = context.dataset.data[index];
                            return value <= 0 ? 'rgba(255, 255, 255, 0)' :  // draw negative values in red
                                'rgba(255, 255, 255, 0)';      // else

                        }
                    }
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Chart.js Line Chart'
                    }

                },
                responsive: true,
                maintainAspectRatio: false,

            }
        });


    });

    //GRAFICA DE PETICIONES ANUALES
    $.post("app/graficas.php", {

        anualDatosSend: anualDatos,
        yearSend: year,

    }, function (data, status) {

        let datosAnual = JSON.parse(data);

        document.getElementById("peticionesAnuales").remove();

        let canvas3 = document.createElement("canvas");
        canvas3.id = "peticionesAnuales";
        document.getElementById("contenedor-anuales").appendChild(canvas3);

        const ctx = document.getElementById('peticionesAnuales').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre',],
                datasets: [{
                    label: 'Peticiones Por Mes',
                    data: datosAnual.datos,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)',
                        'rgba(214, 137, 16, 0.2)',
                        'rgba(23, 165, 137, 0.2)',
                        'rgba(46, 64, 83, 0.2)',
                        'rgba(166, 172, 175, 0.2)',
                        'rgba(169, 50, 38, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)',
                        'rgb(214, 137, 16)',
                        'rgb(23, 165, 137)',
                        'rgb(46, 64, 83)',
                        'rgb(166, 172, 175)',
                        'rgb(169, 50, 38)'

                    ],
                    borderWidth: 1,
                    datalabels: {
                        color: function (context) {
                            let index = context.dataIndex;
                            let value = context.dataset.data[index];
                            return value <= 0 ? 'rgba(255, 255, 255, 0)' :  // draw negative values in red
                                'black';      // else

                        }
                    }


                }]

            },
            options: {
                legend: {
                    display: false
                },
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem) {
                            return tooltipItem.yLabel;
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
            }
        });


    });

    //GRAFICA DE PETICIONES COMPLETADAS POR MES
    $.post("app/graficas.php", {

        anualDatosCompletadasSend: anualDatosCompletadas,
        yearSend: year,

    }, function (data, status) {

        let datosAnualCompletadas = JSON.parse(data);

        document.getElementById("peticionesCompletadasMes").remove();

        let canvas3 = document.createElement("canvas");
        canvas3.id = "peticionesCompletadasMes";
        document.getElementById("contenedor-completadas-mes").appendChild(canvas3);

        const ctx = document.getElementById('peticionesCompletadasMes').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre',],
                datasets: [{
                    label: 'Peticiones Completadas Por Mes',
                    data: datosAnualCompletadas.datos,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)',
                        'rgba(214, 137, 16, 0.2)',
                        'rgba(23, 165, 137, 0.2)',
                        'rgba(46, 64, 83, 0.2)',
                        'rgba(166, 172, 175, 0.2)',
                        'rgba(169, 50, 38, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)',
                        'rgb(214, 137, 16)',
                        'rgb(23, 165, 137)',
                        'rgb(46, 64, 83)',
                        'rgb(166, 172, 175)',
                        'rgb(169, 50, 38)'

                    ],
                    borderWidth: 1,
                    datalabels: {
                        color: function (context) {
                            let index = context.dataIndex;
                            let value = context.dataset.data[index];
                            return value <= 0 ? 'rgba(255, 255, 255, 0)' :  // draw negative values in red
                                'black';      // else

                        }
                    }

                }]

            },
            options: {
                legend: {
                    display: false
                },
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem) {
                            return tooltipItem.yLabel;
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,

            }
        });



    });

    //GRAFICA DE PETICIONES RECHAZADAS POR MES
    $.post("app/graficas.php", {

        anualDatosRechazadasSend: anualDatosRechazadas,
        yearSend: year,

    }, function (data, status) {

        let datosAnualRechazadas = JSON.parse(data);

        document.getElementById("peticionesRechazadasMes").remove();

        let canvasRechazadas = document.createElement("canvas");
        canvasRechazadas.id = "peticionesRechazadasMes";
        document.getElementById("contenedor-rechazadas-mes").appendChild(canvasRechazadas);

        const ctx = document.getElementById('peticionesRechazadasMes').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre',],
                datasets: [{
                    label: 'Peticiones Rechazadas Por Mes',
                    data: datosAnualRechazadas.datos,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)',
                        'rgba(214, 137, 16, 0.2)',
                        'rgba(23, 165, 137, 0.2)',
                        'rgba(46, 64, 83, 0.2)',
                        'rgba(166, 172, 175, 0.2)',
                        'rgba(169, 50, 38, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)',
                        'rgb(214, 137, 16)',
                        'rgb(23, 165, 137)',
                        'rgb(46, 64, 83)',
                        'rgb(166, 172, 175)',
                        'rgb(169, 50, 38)'

                    ],
                    borderWidth: 1,
                    datalabels: {
                        color: function (context) {
                            let index = context.dataIndex;
                            let value = context.dataset.data[index];
                            return value <= 0 ? 'rgba(255, 255, 255, 0)' :  // draw negative values in red
                                'black';      // else

                        }
                    }


                }]

            },
            options: {
                legend: {
                    display: false
                },
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem) {
                            return tooltipItem.yLabel;
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false,

            }
        });



    });


}

//GRAFICA LA PRIMERA SECCION DE ESTADISTICAS DE LABORATORIO
function graficarEstadisticasPorFechaLab() {

    let laboratorioDatosFechas = true;
    let laboratorio = $('#filtroLaboratorioGrafica_2').val();
    let fechaInicio = $('#filtroFechaInicioGraficosLaboratorio').val();
    let fechaFinal = $('#filtroFechaFinalGraficosLaboratorio').val();

    if (laboratorio == null || fechaInicio == '' || fechaFinal == '') {

        swal({
            title: "Completa todos los filtros de busqueda ",
            icon: "error",
            button: "Cerrar",
        })

    } else {
        $.post("app/graficas.php", {

            laboratorioDatosFechasSend: laboratorioDatosFechas,
            laboratorioSend: laboratorio,
            fechaInicioSend: fechaInicio,
            fechaFinalSend: fechaFinal,

        }, function (data, status) {

            let datos = JSON.parse(data);

            document.getElementById("peticionesLabFechas").remove();

            let canvas1 = document.createElement("canvas");
            canvas1.id = "peticionesLabFechas";
            document.getElementById("contenedor-lab-fechas").appendChild(canvas1);

            const ctxDesarrollador = document.getElementById('peticionesLabFechas').getContext('2d');
            const myChartDesarrollador = new Chart(ctxDesarrollador, {
                type: 'pie',
                data: {
                    labels: ['Pendientes', 'Desarrollo', 'Completas', 'Rechazadas'],
                    datasets: [{
                        label: 'Peticiones',
                        data: datos.datos,
                        backgroundColor: [
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(54, 162, 235, 0.2)',


                            'rgba(75, 192, 192, 0.2)',

                            'rgba(255, 99, 132, 0.2)',

                        ],
                        borderColor: [
                            'rgba(255, 206, 86, 1)',

                            'rgba(54, 162, 235, 1)',


                            'rgba(75, 192, 192, 1)',

                            'rgba(255, 99, 132, 1)',

                        ],
                        borderWidth: 1,
                        datalabels: {
                            color: function (context) {
                                let index = context.dataIndex;
                                let value = context.dataset.data[index];
                                return value <= 0 ? 'rgba(255, 255, 255, 0)' :  // draw negative values in red
                                    'black';      // else

                            }
                        }
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });

            $('#totalDatosPendientesLab').text(datos.datosPendientes);
            $('#totalDatosDesarrolloLab').text(datos.datosDesarrollo);
            $('#totalDatosCompletadosLab').text(datos.datosCompletados);
            $('#totalDatosRechazadosLab').text(datos.datosRechazados);
            $('#totalDatosLab').text(datos.datosTotal);


        });
    }




}

//GRAFICA LA SEGUNDA SECCION DE ESTADISTICAS DE LABORATORIO
function graficarEstadisticasLaboratorios() {

    let laboratorioDatos = true;
    let laboratorioMix = true;
    let laboRecibidas = true;
    let laboratorioCompletadas = true;
    let laboratorioRechazado = true;
    let laboratorio = $('#filtroLaboratorioGrafica').val();
    let year = $('#filtroAnualGraficaLab').val();


    if (laboratorio == null || year == '') {

        swal({
            title: "Completa todos los filtros de busqueda ",
            icon: "error",
            button: "Cerrar",
        })

    } else {

        //GRAFICA DE LABORATORIOS ANUALMENTE
        $.post("app/graficas.php", {

            laboratorioDatosSend: laboratorioDatos,
            laboratorioSend: laboratorio,
            yearSend: year,



        }, function (data, status) {

            let datosLab = JSON.parse(data);

            document.getElementById("peticionesPorLaboratorio").remove();

            let canvasMix = document.createElement("canvas");
            canvasMix.id = "peticionesPorLaboratorio";
            document.getElementById("contenedorLabGrafica").appendChild(canvasMix);

            const ctx = document.getElementById('peticionesPorLaboratorio').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre',],
                    datasets: [{
                        label: 'Recibidas',
                        data: datosLab.datos,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(255, 255, 255, 0.1)',
                        datalabels: {
                            color: function (context) {
                                let index = context.dataIndex;
                                let value = context.dataset.data[index];
                                return value <= 0 ? 'rgba(255, 255, 255, 0)' :  // draw negative values in red
                                    'rgba(255, 255, 255, 0)';      // else

                            }
                        }
                    },
                    {
                        label: 'Completadas',
                        data: datosLab.datosCompletados,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(255, 255, 255, 0.1)',
                        datalabels: {
                            color: function (context) {
                                let index = context.dataIndex;
                                let value = context.dataset.data[index];
                                return value <= 0 ? 'rgba(255, 255, 255, 0)' :  // draw negative values in red
                                    'rgba(255, 255, 255, 0)';      // else

                            }
                        }
                    },
                    {
                        label: 'Rechazadas',
                        data: datosLab.datosRechazados,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 255, 255, 0.1)',
                        datalabels: {
                            color: function (context) {
                                let index = context.dataIndex;
                                let value = context.dataset.data[index];
                                return value <= 0 ? 'rgba(255, 255, 255, 0)' :  // draw negative values in red
                                    'rgba(255, 255, 255, 0)';      // else

                            }
                        }
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Chart.js Line Chart'
                        }

                    },
                    responsive: true,
                    maintainAspectRatio: false,

                }
            });


        });

        //GRAFICA DE PETICIONES RECIBIDAS
        $.post("app/graficas.php", {

            laboratorioMixSend: laboratorioMix,
            laboRecibidasSend: laboRecibidas,
            yearSend: year,
            laboratorioSend: laboratorio,


        }, function (data, status) {

            let datos = JSON.parse(data);

            document.getElementById("peticionesPorLaboratorioRecibidas").remove();

            let canvas3 = document.createElement("canvas");
            canvas3.id = "peticionesPorLaboratorioRecibidas";
            document.getElementById("contenedor-lab-recibidas").appendChild(canvas3);

            const ctx = document.getElementById('peticionesPorLaboratorioRecibidas').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre',],
                    datasets: [{
                        label: 'Peticiones Recibidas Por Mes',
                        data: datos.datos,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)',
                            'rgba(214, 137, 16, 0.2)',
                            'rgba(23, 165, 137, 0.2)',
                            'rgba(46, 64, 83, 0.2)',
                            'rgba(166, 172, 175, 0.2)',
                            'rgba(169, 50, 38, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)',
                            'rgb(214, 137, 16)',
                            'rgb(23, 165, 137)',
                            'rgb(46, 64, 83)',
                            'rgb(166, 172, 175)',
                            'rgb(169, 50, 38)'

                        ],
                        borderWidth: 1,
                        datalabels: {
                            color: function (context) {
                                let index = context.dataIndex;
                                let value = context.dataset.data[index];
                                return value <= 0 ? 'rgba(255, 255, 255, 0)' :  // draw negative values in red
                                    'black';      // else

                            }
                        }

                    }]

                },
                options: {
                    legend: {
                        display: false
                    },
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.yLabel;
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,

                }
            });



        });

        //GRAFICA DE PETICIONES COMPLETADAS
        $.post("app/graficas.php", {

            laboratorioMixSend: laboratorioMix,
            laboratorioCompletadasSend: laboratorioCompletadas,
            yearSend: year,
            laboratorioSend: laboratorio,


        }, function (data, status) {

            let datos = JSON.parse(data);

            document.getElementById("peticionesPorLaboratorioCompletadas").remove();

            let canvas3 = document.createElement("canvas");
            canvas3.id = "peticionesPorLaboratorioCompletadas";
            document.getElementById("contenedor-lab-completadas").appendChild(canvas3);

            const ctx = document.getElementById('peticionesPorLaboratorioCompletadas').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre',],
                    datasets: [{
                        label: 'Peticiones Completadas Por Mes',
                        data: datos.datos,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)',
                            'rgba(214, 137, 16, 0.2)',
                            'rgba(23, 165, 137, 0.2)',
                            'rgba(46, 64, 83, 0.2)',
                            'rgba(166, 172, 175, 0.2)',
                            'rgba(169, 50, 38, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)',
                            'rgb(214, 137, 16)',
                            'rgb(23, 165, 137)',
                            'rgb(46, 64, 83)',
                            'rgb(166, 172, 175)',
                            'rgb(169, 50, 38)'

                        ],
                        borderWidth: 1,
                        datalabels: {
                            color: function (context) {
                                let index = context.dataIndex;
                                let value = context.dataset.data[index];
                                return value <= 0 ? 'rgba(255, 255, 255, 0)' :  // draw negative values in red
                                    'black';      // else

                            }
                        }

                    }]

                },
                options: {
                    legend: {
                        display: false
                    },
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.yLabel;
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,

                }
            });



        });

        //GRAFICA DE PETICIONES RECHAZADAS
        $.post("app/graficas.php", {

            laboratorioMixSend: laboratorioMix,
            laboratorioRechazadoSend: laboratorioRechazado,
            yearSend: year,
            laboratorioSend: laboratorio,


        }, function (data, status) {

            let datos = JSON.parse(data);

            document.getElementById("peticionesPorLaboratorioRechazadas").remove();

            let canvas3 = document.createElement("canvas");
            canvas3.id = "peticionesPorLaboratorioRechazadas";
            document.getElementById("contenedor-lab-rechazadas").appendChild(canvas3);

            const ctx = document.getElementById('peticionesPorLaboratorioRechazadas').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre',],
                    datasets: [{
                        label: 'Peticiones Completadas Por Mes',
                        data: datos.datos,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)',
                            'rgba(214, 137, 16, 0.2)',
                            'rgba(23, 165, 137, 0.2)',
                            'rgba(46, 64, 83, 0.2)',
                            'rgba(166, 172, 175, 0.2)',
                            'rgba(169, 50, 38, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)',
                            'rgb(214, 137, 16)',
                            'rgb(23, 165, 137)',
                            'rgb(46, 64, 83)',
                            'rgb(166, 172, 175)',
                            'rgb(169, 50, 38)'

                        ],
                        borderWidth: 1,
                        datalabels: {
                            color: function (context) {
                                let index = context.dataIndex;
                                let value = context.dataset.data[index];
                                return value <= 0 ? 'rgba(255, 255, 255, 0)' :  // draw negative values in red
                                    'black';      // else

                            }
                        }

                    }]

                },
                options: {
                    legend: {
                        display: false
                    },
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.yLabel;
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,

                }
            });



        });

    }


}

//GRAFICA LA PRIMERA SECCION DE DESARROLLADORES
function graficarComparacionDesarrolladores() {

    let graficaPorYear = true;

    let desarrollador = $('#filtroDesarrolladorGrafica_all').val();
    let year = $('#filtroAnualGraficaDesarrollador').val();

    if (desarrollador == null || year == '') {

        swal({
            title: "Completa todos los filtros de busqueda ",
            icon: "error",
            button: "Cerrar",
        })

    } else {
        $.post("app/graficas.php", {

            graficaPorYearSend: graficaPorYear,
            yearSend: year,
            desarrolladorSend: desarrollador,


        }, function (data, status) {

            let datos = JSON.parse(data);

            document.getElementById("desarrolladorComparacion").remove();

            let canvas3 = document.createElement("canvas");
            canvas3.id = "desarrolladorComparacion";
            document.getElementById("contenedor-comparacion-desarrollador").appendChild(canvas3);

            const ctx = document.getElementById('desarrolladorComparacion').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre',],
                    datasets: [{
                        data: datos.datos,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)',
                            'rgb(214, 137, 16)',
                            'rgb(23, 165, 137)',
                            'rgb(46, 64, 83)',
                            'rgb(166, 172, 175)',
                            'rgb(169, 50, 38)'

                        ],
                        borderWidth: 1,
                        datalabels: {
                            color: function (context) {
                                let index = context.dataIndex;
                                let value = context.dataset.data[index];
                                return value <= 0 ? 'rgba(255, 255, 255, 0)' :  // draw negative values in red
                                    'rgba(255, 255, 255, 0)';      // else

                            }
                        }


                    }]

                },
                options: {
                    legend: {
                        display: false
                    },
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.yLabel;
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });


        });
    }
}

//GRAFICA LA TERCERA SECCION DE DESARROLLADORES
function graficarDesarrolladoresSeccion3() {

    let desComoaracion = true;

    let completadas = true;

    let rechazadas = true;

    let pendientes = true;

    let desarrollo = true;

    let total = true;
    
    let valores_array = $('#filtroDesarrolladorGrafica_4').select2("val");
  
    let fechaInicio = $('#filtroFechaInicioMultiple').val();

    let fechaFinal = $('#filtroFechaFinalMultiple').val();

    //COMPLETADAS
    $.post("app/graficas.php", {

        desComoaracionSend: desComoaracion,
        completadasSend: completadas,
        valores_array_send: valores_array,
        fechaInicioSend: fechaInicio,
        fechaFinalSend: fechaFinal,
    

    }, function (data, status) {

        let datos = JSON.parse(data);

        document.getElementById("desarrolladoresComparadosCompletas").remove();

        let canvas1 = document.createElement("canvas");
        canvas1.id = "desarrolladoresComparadosCompletas";
        document.getElementById("contenedor-grafica-desarrollador-comparacion-completas").appendChild(canvas1);
    
    
        const ctxDesarrollador = document.getElementById('desarrolladoresComparadosCompletas').getContext('2d');
        const myChartDesarrollador = new Chart(ctxDesarrollador, {
            type: 'pie',
            data: {
                labels: datos.nombres,
                datasets: [{
                    data: datos.valores,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1,
                    datalabels: {
                        color: function (context) {
                            let index = context.dataIndex;
                            let value = context.dataset.data[index];
                            return value <= 0 ? 'rgba(255, 255, 255, 0)' :  // draw negative values in red
                                'black';      // else
    
                        }
                    }
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
            }
        });

    });

    //RECHAZADAS
    $.post("app/graficas.php", {

        desComoaracionSend: desComoaracion,
        rechazadasSend: rechazadas,
        valores_array_send: valores_array,
        fechaInicioSend: fechaInicio,
        fechaFinalSend: fechaFinal,
    

    }, function (data, status) {

        let datos = JSON.parse(data);

        document.getElementById("desarrolladoresComparadosRechazadas").remove();

        let canvas1 = document.createElement("canvas");
        canvas1.id = "desarrolladoresComparadosRechazadas";
        document.getElementById("contenedor-grafica-desarrollador-comparacion-rechazadas").appendChild(canvas1);
    
    
        const ctxDesarrollador = document.getElementById('desarrolladoresComparadosRechazadas').getContext('2d');
        const myChartDesarrollador = new Chart(ctxDesarrollador, {
            type: 'pie',
            data: {
                labels: datos.nombres,
                datasets: [{
                    data: datos.valores,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1,
                    datalabels: {
                        color: function (context) {
                            let index = context.dataIndex;
                            let value = context.dataset.data[index];
                            return value <= 0 ? 'rgba(255, 255, 255, 0)' :  // draw negative values in red
                                'black';      // else
    
                        }
                    }
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
            }
        });

    });

    //PENDIENTES
    $.post("app/graficas.php", {

        desComoaracionSend: desComoaracion,
        pendientesSend: pendientes,
        valores_array_send: valores_array,
        fechaInicioSend: fechaInicio,
        fechaFinalSend: fechaFinal,
    

    }, function (data, status) {

        let datos = JSON.parse(data);

        document.getElementById("desarrolladoresComparadosPendientes").remove();

        let canvas1 = document.createElement("canvas");
        canvas1.id = "desarrolladoresComparadosPendientes";
        document.getElementById("contenedor-grafica-desarrollador-comparacion-pendientes").appendChild(canvas1);
    
    
        const ctxDesarrollador = document.getElementById('desarrolladoresComparadosPendientes').getContext('2d');
        const myChartDesarrollador = new Chart(ctxDesarrollador, {
            type: 'pie',
            data: {
                labels: datos.nombres,
                datasets: [{
                    data: datos.valores,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1,
                    datalabels: {
                        color: function (context) {
                            let index = context.dataIndex;
                            let value = context.dataset.data[index];
                            return value <= 0 ? 'rgba(255, 255, 255, 0)' :  // draw negative values in red
                                'black';      // else
    
                        }
                    }
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
            }
        });

    });

    //DESARROLLO
    $.post("app/graficas.php", {

        desComoaracionSend: desComoaracion,
        desarrolloSend: desarrollo,
        valores_array_send: valores_array,
        fechaInicioSend: fechaInicio,
        fechaFinalSend: fechaFinal,
    

    }, function (data, status) {

        let datos = JSON.parse(data);

        document.getElementById("desarrolladoresComparadosDesarrollo").remove();

        let canvas1 = document.createElement("canvas");
        canvas1.id = "desarrolladoresComparadosDesarrollo";
        document.getElementById("contenedor-grafica-desarrollador-comparacion-desarrollo").appendChild(canvas1);
    
    
        const ctxDesarrollador = document.getElementById('desarrolladoresComparadosDesarrollo').getContext('2d');
        const myChartDesarrollador = new Chart(ctxDesarrollador, {
            type: 'pie',
            data: {
                labels: datos.nombres,
                datasets: [{
                    data: datos.valores,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1,
                    datalabels: {
                        color: function (context) {
                            let index = context.dataIndex;
                            let value = context.dataset.data[index];
                            return value <= 0 ? 'rgba(255, 255, 255, 0)' :  // draw negative values in red
                                'black';      // else
    
                        }
                    }
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
            }
        });

    });

    //TOTAL
    $.post("app/graficas.php", {

        desComoaracionSend: desComoaracion,
        totalSend: total,
        valores_array_send: valores_array,
        fechaInicioSend: fechaInicio,
        fechaFinalSend: fechaFinal,
    

    }, function (data, status) {

        let datos = JSON.parse(data);

        document.getElementById("desarrolladoresComparadostotal").remove();

        let canvas1 = document.createElement("canvas");
        canvas1.id = "desarrolladoresComparadostotal";
        document.getElementById("contenedor-grafica-desarrollador-comparacion-total").appendChild(canvas1);
    
    
        const ctxDesarrollador = document.getElementById('desarrolladoresComparadostotal').getContext('2d');
        const myChartDesarrollador = new Chart(ctxDesarrollador, {
            type: 'pie',
            data: {
                labels: datos.nombres,
                datasets: [{
                    data: datos.valores,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1,
                    datalabels: {
                        color: function (context) {
                            let index = context.dataIndex;
                            let value = context.dataset.data[index];
                            return value <= 0 ? 'rgba(255, 255, 255, 0)' :  // draw negative values in red
                                'black';      // else
    
                        }
                    }
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
            }
        });

    });


}

function graficarDesarrolladorMes() {

    let desarrolladorDiasMes = true;

    let laboratorio = $('#filtroDesarrolladorGrafica').val();
    let fecha = $('#filtroMes_1').val();
    let year = fecha.slice(0, -3);
    let mes = fecha.slice(5);

    if (laboratorio == null || year == '' || mes == '') {

        swal({
            title: "Completa todos los filtros de busqueda ",
            icon: "error",
            button: "Cerrar",
        })

    } else {
        $.post("app/graficas.php", {

            desarrolladorDiasMesSend: desarrolladorDiasMes,
            yearSend: year,
            mesSend: mes,
            laboratorioSend: laboratorio,


        }, function (data, status) {

            let datos = JSON.parse(data);


            let coloR = [];

            let dynamicColors = function () {
                var r = Math.floor(Math.random() * 255);
                var g = Math.floor(Math.random() * 255);
                var b = Math.floor(Math.random() * 255);
                return "rgb(" + r + "," + g + "," + b + ")";
            };

            for (let i in datos.valores) {

                coloR.push(dynamicColors());
            }

            document.getElementById("desarrolladorComparacionDiasMes").remove();

            let canvas3 = document.createElement("canvas");
            canvas3.id = "desarrolladorComparacionDiasMes";
            document.getElementById("contenedor-comparacion-desarrollador-diasMes").appendChild(canvas3);

            const ctx = document.getElementById('desarrolladorComparacionDiasMes').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: datos.dias,
                    datasets: [{
                        data: datos.valores,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                        ],
                        borderColor: coloR,
                        borderWidth: 1,

                        datalabels: {
                            color: function (context) {
                                let index = context.dataIndex;
                                let value = context.dataset.data[index];
                                return value <= 0 ? 'rgba(255, 255, 255, 0)' :  // draw negative values in red
                                    'rgba(255, 255, 255, 0)';      // else

                            }
                        }


                    }]

                },
                options: {
                    legend: {
                        display: false
                    },
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.yLabel;
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });


        });
    }




}

//GRAFICA LA SEGUNDA SECCION DE DESARROLLADORES
function graficarEstadisticasDesarrolladores() {

    let graficaDesarrollador = true;

    let desarrollador = $('#filtroDesarrolladorGrafica_3').val();
    let fechaInicio = $('#filtroFechaInicioGraficosDesarrolladorPersonal').val();
    let fechaFinal = $('#filtroFechaFinalGraficosDesarrolladorPersonal').val();

    if (desarrollador == null || fechaInicio == '' || fechaFinal == '') {

        swal({
            title: "Completa todos los filtros de busqueda ",
            icon: "error",
            button: "Cerrar",
        })

    } else {

        $.post("app/graficas.php", {

            graficaDesarrolladorSend: graficaDesarrollador,
            desarrolladorSend: desarrollador,
            fechaInicioSend: fechaInicio,
            fechaFinalSend: fechaFinal,

        }, function (data, status) {



            let datos = JSON.parse(data);
            document.getElementById("desarrolladorGraficaPendiente").remove();

            let canvas1 = document.createElement("canvas");
            canvas1.id = "desarrolladorGraficaPendiente";
            document.getElementById("contenedor-grafica-desarrollador-pendiente").appendChild(canvas1);

            const ctxDesarrollador = document.getElementById('desarrolladorGraficaPendiente').getContext('2d');
            const myChartDesarrollador = new Chart(ctxDesarrollador, {
                type: 'pie',
                data: {
                    labels: datos.datos,
                    datasets: [{
                        label: 'Desarrollador',
                        data: datos.datosNumericos,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(255, 99, 132, 0.2)',

                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(255, 99, 132, 1)',

                        ],
                        borderWidth: 1,
                        datalabels: {
                            color: function (context) {
                                let index = context.dataIndex;
                                let value = context.dataset.data[index];
                                return value <= 0 ? 'rgba(255, 255, 255, 0)' :  // draw negative values in red
                                    'black';      // else

                            }
                        }
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });

            $('#totalDatosPendientes').text(datos.datosPendientes);
            $('#totalDatosDes').text(datos.datosTotal);
            $('#totalDatosCompletados').text(datos.datosCompletados);
            $('#totalDatosRechazados').text(datos.datosRechazados);
            $('#totalDatosDesarrollo').text(datos.datosDesarrollo);





        });




    }






}

//BUSCADOR SELECT2 PARA LAS GRAFICAS
function buscadorLabGraficas() {

    let boleanoLaboratorio = true;

    $("#filtroLaboratorioGrafica").select2({
        placeholder: "Selecciona Laboratorio",
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



    $("#filtroLaboratorioGrafica_2").select2({
        placeholder: "Selecciona Laboratorio",
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





}

function buscadorEstadisticasDesarrolladores() {
    let boleanoDesarrollador = true;



    $("#filtroDesarrolladorGrafica_4").select2({
        placeholder: "Desarrollador",
        theme: "bootstrap",
        
        ajax: {
            url: "app/autoCompleteLab.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    buscarLaboratorio: params.term,// search term
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

    $("#filtroDesarrolladorGrafica_3").select2({
        placeholder: "Desarrollador",
        theme: "bootstrap",

        ajax: {
            url: "app/autoCompleteLab.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    buscarLaboratorio: params.term,// search term
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


    $("#filtroDesarrolladorGrafica").select2({
        placeholder: "Desarrollador",
        theme: "bootstrap",

        ajax: {
            url: "app/autoCompleteLab.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    buscarLaboratorio: params.term,// search term
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


    $("#filtroDesarrolladorGrafica_all").select2({
        placeholder: "Desarrollador",
        theme: "bootstrap",

        ajax: {
            url: "app/autoCompleteLab.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    buscarLaboratorio: params.term,// search term
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

}

function limpiarFiltrosSeccion1Desarrolladores() {
    $('#filtroDesarrolladorGrafica_all').val(null).trigger('change');

}

function limpiarDesMensual() {
    $('#filtroDesarrolladorGrafica').val(null).trigger('change');
    $('#filtroMes_1').val('');
}

function limpiarFiltrosGraficasDesa() {

    $('#filtroDesarrolladorGrafica').val(null).trigger('change');
    $('#filtroFechaInicioGraficosDesarrolladorPersonal').val('');
    $('#filtroFechaFinalGraficosDesarrolladorPersonal').val('');
}

function limpiarFiltrosGraficasGeneral() {

    $('#filtroFechaInicioGraficos').val('');
    $('#filtroFechaFinalGraficos').val('');
}

function limpiarFiltrosGraficasLab() {

    $('#filtroLaboratorioGrafica_2').val(null).trigger('change');


}

function opcionAnual() {

    $('#rendimiento_2').hide();
    $("#opcion_2").removeAttr('disabled');
    $("#opcion_1").attr('disabled', 'disabled');
    $('#rendimiento_1').show();

    $('#filtroYeardDes').show();

    $('#filtroMonthDes').hide();

    $('#buscar_opcion_2').hide();

    $('#buscar_opcion_1').show();

    $('#limpiar_opcion_2').hide();

    $('#limpiar_opcion_1').show();

    $('#filtroDes_opcion_1').show();

    $('#filtroDes_opcion_2').hide();

}

function opcionDiasMes() {

    $('#rendimiento_1').hide();
    $("#opcion_1").removeAttr('disabled');
    $("#opcion_2").attr('disabled', 'disabled');
    $('#rendimiento_2').show();

    $('#filtroYeardDes').hide();

    $('#filtroMonthDes').show();

    $('#buscar_opcion_2').show();

    $('#buscar_opcion_1').hide();

    $('#limpiar_opcion_2').show();

    $('#limpiar_opcion_1').hide();

    $('#filtroDes_opcion_1').hide();

    $('#filtroDes_opcion_2').show();


}


