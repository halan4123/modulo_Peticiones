

function graficarEstadisticasGenerales() {

    let fechaInicio = $('#filtroFechaInicioGraficos').val();
    let fechaFinal = $('#filtroFechaFinalGraficos').val();

    let desarrolladorDatos = true;
    let soporteDatos = true;
    let anualDatos = true;
    let anualDatosCompletadas = true;

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
                }
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
                }

            }
        });

    });

    //GRAFICA DE PETICIONES ANUALES
    $.post("app/graficas.php", {

        anualDatosSend: anualDatos,
        fechaInicioSend: fechaInicio,
        fechaFinalSend: fechaFinal,

    }, function (data, status) {

        let datosAnual = JSON.parse(data);


        document.getElementById("peticionesAnuales").remove();

        let canvas3 = document.createElement("canvas");
        canvas3.id = "peticionesAnuales";
        document.getElementById("contenedor-anuales").appendChild(canvas3);

        const ctx = document.getElementById('peticionesAnuales').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre',],
                datasets: [{
                    label: 'Peticiones Por Mes',
                    borderColor: 'rgb(255, 99, 132)',
                    data: datosAnual.datos,
                }]

            },
            options: {

            }
        });

    });

    //GRAFICA DE PETICIONES COMPLETADAS POR MES
    $.post("app/graficas.php", {

        anualDatosCompletadasSend: anualDatosCompletadas,
        fechaInicioSend: fechaInicio,
        fechaFinalSend: fechaFinal,

    }, function (data, status) {

        let datosAnualCompletadas = JSON.parse(data);

        document.getElementById("peticionesCompletadasMes").remove();

        let canvas3 = document.createElement("canvas");
        canvas3.id = "peticionesCompletadasMes";
        document.getElementById("contenedor-completadas-mes").appendChild(canvas3);

        const ctx = document.getElementById('peticionesCompletadasMes').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre',],
                datasets: [{
                    label: 'Peticiones Completadas Por Mes',
                    borderColor: 'rgb(46, 46, 83)',
                    data: datosAnualCompletadas.datos,
                }]

            },
            options: {

            }
        });


    });












}









