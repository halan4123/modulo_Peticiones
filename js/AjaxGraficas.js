/*
Encierro todo en una función asíncrona para poder usar async y await cómodamente
https://parzibyte.me/blog
*/
// (async () => {
//     // Llamar a nuestra API. Puedes usar cualquier librería para la llamada, yo uso fetch, que viene nativamente en JS
//     const respuestaRaw = await fetch("app/graficas.php");
//     // Decodificar como JSON
//     const respuesta = await respuestaRaw.json();
//     // Ahora ya tenemos las etiquetas y datos dentro de "respuesta"
//     // Obtener una referencia al elemento canvas del DOM
//     const $grafica = document.querySelector("#grafica");
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
//           ],
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