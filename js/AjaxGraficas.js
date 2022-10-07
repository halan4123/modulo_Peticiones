



function graficarEstadisticasGenerales() {

    let fechaInicio = $('#filtroFechaInicioGraficos').val();
    let fechaFinal = $('#filtroFechaFinalGraficos').val();


    let desarrolladorDatos = true;

    $.post("app/pruebaGraficas.php", {

        desarrolladorDatosSend: desarrolladorDatos,
        fechaInicioSend: fechaInicio,
        fechaFinalSend: fechaFinal,

    }, function (data, status) {

        let datos = JSON.parse(data);

        document.getElementById("peticionesAceptadasDesarrolladores").remove();

        let canvas1 = document.createElement("canvas");
        canvas1.id = "peticionesAceptadasDesarrolladores";
        document.getElementById("contenedor-desarrollador").appendChild(canvas1);



        const ctxDesarrollador = $('#peticionesAceptadasDesarrolladores');
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

    let soporteDatos = true;

    $.post("app/pruebaGraficas.php", {

        soporteDatosSend: soporteDatos,
        fechaInicioSend: fechaInicio,
        fechaFinalSend: fechaFinal,

    }, function (data, status) {

        let datosSoporte = JSON.parse(data);

        document.getElementById("peticionesRegistradasSoporte").remove();

        let canvas2 = document.createElement("canvas");
        canvas2.id = "peticionesRegistradasSoporte";
        document.getElementById("contenedor-soporte").appendChild(canvas2);

        const ctxSoporte = $('#peticionesRegistradasSoporte');
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






}








