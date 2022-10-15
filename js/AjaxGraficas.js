/**
* SE CARGA LA FUNCION DE BUSCADORLAB GRAFICAS
* DESDEN UN ONFOCUS EN LA PESTAÑA DE ESTADISTICAS DE LABORATORIOS
*/

//CANVAS DE GRAFICAS EN LA PESTAÑA DE ESTADISTICAS GENERALES
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
                    borderWidth: 1
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
                    borderWidth: 1
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

//CANVAS DE GRAFICA ANUALES EN LA PESTAÑA DE ESTADISTICAS GENERALES
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
                },
                {
                    label: 'Completadas',
                    data: datosAnualMix.datosCompletados,
                    borderColor: 'rgba(255, 159, 64, 1)',
                    backgroundColor: 'rgba(255, 255, 255, 0.1)',
                },
                {
                    label: 'Rechazadas',
                    data: datosAnualMix.datosRechazados,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 255, 255, 0.1)',
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
                    borderWidth: 1


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
                    borderWidth: 1


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
                    borderWidth: 1


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

//CANVAS DE GRAFICAS EN LA PESTAÑA DE ESTADISTICAS LABORATORIO
function graficarEstadisticasLaboratorios() {

    let laboratorioDatos = true;
    let laboratorio = $('#filtroLaboratorioGrafica').val();
    let year = $('#filtroAnualGraficaLab').val();
    // let fechaInicio = $('#filtroFechaInicioGraficosLab').val();
    // let fechaFinal = $('#filtroFechaFinalGraficosLab').val();



    if (laboratorio == null || year == '') {

        swal({
            title: "Completa todos los filtros de busqueda ",
            icon: "error",
            button: "Cerrar",
        })

    } else {



        //GRAFICA DE LABORATORIOS
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
                    },
                    {
                        label: 'Completadas',
                        data: datosLab.datosCompletados,
                        borderColor: 'rgba(255, 159, 64, 1)',
                        backgroundColor: 'rgba(255, 255, 255, 0.1)',
                    },
                    {
                        label: 'Rechazadas',
                        data: datosLab.datosRechazados,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 255, 255, 0.1)',
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


    }


}

//GRAFICA LAS GRAFICAS DE CADA DESARROLLADOR
function graficarEstadisticasDesarrolladores() {

    let graficaDesarrollador = true;

    let desarrollador = $('#filtroDesarrolladorGrafica').val();
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
                        borderWidth: 1
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





}

function buscadorEstadisticasDesarrolladores() {
    let boleanoDesarrollador = true;

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

}


function limpiarFiltrosGraficasDesa() {

    $('#filtroDesarrolladorGrafica').val(null).trigger('change');
    $('#filtroFechaInicioGraficosDesarrolladorPersonal').val('');
    $('#filtroFechaFinalGraficosDesarrolladorPersonal').val('');
}
