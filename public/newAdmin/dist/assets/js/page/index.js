// "use strict";
// const ctx = document.getElementById("memberChartLine").getContext('2d');
// const memberChartLine = new Chart(ctx, {
//   type: 'line',
//   data: {
//     labels: ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December",],
//     datasets: [{
//       label: 'New Members',
//       data: [290, 358, 220, 402, 690, 510, 688],
//       borderWidth: 2,
//       backgroundColor: 'transparent',
//       borderColor: 'rgba(254,86,83,.7)',
//       borderWidth: 2.5,
//       pointBackgroundColor: 'transparent',
//       pointBorderColor: 'transparent',
//       pointRadius: 4
//     },
//     {
//       label: 'Trials',
//       data: [450, 258, 390, 162, 440, 570, 438],
//       borderWidth: 2,
//       backgroundColor: 'transparent',
//       borderColor: 'rgba(63,82,227,.8)',
//       borderWidth: 2.5,
//       pointBackgroundColor: 'transparent',
//       pointBorderColor: 'transparent',
//       pointRadius: 4
//     },
//     ]
//   },
//   options: {
//     legend: {
//       display: true
//     },
//     scales: {
//       yAxes: [{
//         gridLines: {
//           drawBorder: false,
//           color: '#f2f2f2',
//         },
//         ticks: {
//           beginAtZero: true,
//           stepSize: 200
//         }
//       }],
//       xAxes: [{
//         gridLines: {
//           display: false
//         }
//       }]
//     },
//   }
// });


// const ctxType = document.getElementById("typeMemberChartPie").getContext('2d');
// const typeMemberChartPie = new Chart(ctxType, {
//   type: 'pie',
//   data: {
//     datasets: [{
//       data: [
//         80,
//         50,
//       ],
//       backgroundColor: [
//         '#fc544b',
//         '#6777ef',
//       ],
//       label: 'Dataset 1'
//     }],
//     labels: [
//       'Member Bulanan',
//       'Member Tahunan'
//     ],
//   },
//   options: {
//     responsive: true,
//     legend: {
//       position: 'bottom',
//     },
//   }
// });


// var ctxTransaction = document.getElementById("transactionChartBar").getContext('2d');
// var transactionChartBar = new Chart(ctxTransaction, {
//   type: 'bar',
//   data: {
//     labels: ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December",],
//     datasets: [{
//       label: 'Transaction',
//       data: [460, 458, 330, 502, 430, 610, 488,460, 458, 330, 502, 430,],
//       borderWidth: 2,
//       backgroundColor: '#6777ef',
//       borderColor: '#6777ef',
//       borderWidth: 2.5,
//       pointBackgroundColor: '#ffffff',
//       pointRadius: 4
//     }]
//   },
//   options: {
//     legend: {
//       display: false
//     },
//     scales: {
//       yAxes: [{
//         gridLines: {
//           drawBorder: false,
//           color: '#f2f2f2',
//         },
//         ticks: {
//           beginAtZero: true,
//           stepSize: 150
//         }
//       }],
//       xAxes: [{
//         ticks: {
//           display: true
//         },
//         gridLines: {
//           display: false
//         }
//       }]
//     },
//   }
// });