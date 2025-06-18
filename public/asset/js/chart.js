document.addEventListener("DOMContentLoaded", function () {
  const chartDataEl = document.getElementById('chartData');

  const labels = JSON.parse(chartDataEl.dataset.labels);
  const quantityIn = JSON.parse(chartDataEl.dataset.quantityIn);
  const quantityOut = JSON.parse(chartDataEl.dataset.quantityOut);

  const quantityRemaining = quantityIn.map((val, idx) => val - quantityOut[idx]);
  const totalIn = quantityIn.reduce((a, b) => a + b, 0);
  const totalOut = quantityOut.reduce((a, b) => a + b, 0);
  const totalRemaining = quantityRemaining.reduce((a, b) => a + b, 0);

  // Bar Chart
  const ctxBar = document.getElementById('barChart').getContext('2d');
  new Chart(ctxBar, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [
        {
          label: 'Quantity In',
          data: quantityIn,
          backgroundColor: 'rgba(75, 192, 192, 0.7)'
        },
        {
          label: 'Quantity Out',
          data: quantityOut,
          backgroundColor: 'rgba(255, 99, 132, 0.7)'
        },
        {
          label: 'Quantity Tersisa',
          data: quantityRemaining,
          backgroundColor: 'rgba(153, 102, 255, 0.7)'
        }
      ]
    },
    options: {
      responsive: true,
      scales: { y: { beginAtZero: true } }
    }
  });

  // Pie Chart
  const ctxPie = document.getElementById('pieChart').getContext('2d');
  new Chart(ctxPie, {
    type: 'pie',
    data: {
      labels: ['Total In', 'Total Out', 'Total Tersisa'],
      datasets: [{
        data: [totalIn, totalOut, totalRemaining],
        backgroundColor: ['#36A2EB', '#FF6384', '#9966CC']
      }]
    },
    options: { responsive: true }
  });

  // Remaining Bar Chart
  const ctxRemaining = document.getElementById('remainingBarChart').getContext('2d');
  new Chart(ctxRemaining, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Quantity Tersisa',
        data: quantityRemaining,
        backgroundColor: 'rgba(153, 102, 255, 0.7)'
      }]
    },
    options: {
      responsive: true,
      scales: { y: { beginAtZero: true } }
    }
  });
});
