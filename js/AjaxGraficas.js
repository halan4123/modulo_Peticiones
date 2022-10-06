
function pruebaGrafic() {

    let prueba = true;

    $.post("app/pruebaGraficas.php", {

        pruebaSend: prueba,

    }, function (data, status) {

        let prueba = JSON.parse(data);
        //console.log(prueba);

        const ctx = $('#peticionesAceptadasDesarrolladores');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: prueba.nombre,
                datasets: [{
                    label: 'Peticiones Por Desarrollador',
                    data: prueba.datos,
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

    // const ctx = $('#myChart');
    // const myChart = new Chart(ctx, {
    //     type: 'bar',
    //     data: {
    //         labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
    //         datasets: [{
    //             label: 'Peticiones Por Desarrollador',
    //             data: [12, 19, 3, 5, 2, 3],
    //             backgroundColor: [
    //                 'rgba(255, 99, 132, 0.2)',
    //                 'rgba(54, 162, 235, 0.2)',
    //                 'rgba(255, 206, 86, 0.2)',
    //                 'rgba(75, 192, 192, 0.2)',
    //                 'rgba(153, 102, 255, 0.2)',
    //                 'rgba(255, 159, 64, 0.2)'
    //             ],
    //             borderColor: [
    //                 'rgba(255, 99, 132, 1)',
    //                 'rgba(54, 162, 235, 1)',
    //                 'rgba(255, 206, 86, 1)',
    //                 'rgba(75, 192, 192, 1)',
    //                 'rgba(153, 102, 255, 1)',
    //                 'rgba(255, 159, 64, 1)'
    //             ],
    //             borderWidth: 1
    //         }]
    //     },
    //     options: {
    //         scales: {
    //             y: {
    //                 beginAtZero: true
    //             }
    //         }
    //     }
    // });




}








// (async () => {
//     // Llamar a nuestra API. Puedes usar cualquier librería para la llamada, yo uso fetch, que viene nativamente en JS
//     const respuestaRaw = await fetch("app/graficas.php");
//     // Decodificar como JSON
//     const respuesta = await respuestaRaw.json();
//     // Ahora ya tenemos las etiquetas y datos dentro de "respuesta"
//     // Obtener una referencia al elemento canvas del DOM
//     const $grafica = document.querySelector("#graficas");
//     const etiquetas = respuesta.etiquetas; // <- Aquí estamos pasando el valor traído usando AJAX
//     // Podemos tener varios conjuntos de datos. Comencemos con uno
//     const datosVentas2020 = {
//         label: "Ventas por mes",
//         // Pasar los datos igualmente desde PHP
//         data: respuesta.datos, // <- Aquí estamos pasando el valor traído usando AJAX
//         backgroundColor: [
//             'rgb(255, 165, 0)',
//             'rgb(0, 128, 0)',
//             'rgb(255, 0, 0)',
//             'rgb(41, 149, 184)'
//         ],
//     };
//     new Chart($grafica, {
//         type: 'pie', // Tipo de gráfica
//         data: {
//             labels: etiquetas,
//             datasets: [
//                 datosVentas2020,
//                 // Aquí más datos...
//             ]
//         },
//         options: {
//             scales: {
//                 yAxes: [{
//                     ticks: {
//                         beginAtZero: true
//                     }
//                 }],
//             },
//         }
//     });
// })();

