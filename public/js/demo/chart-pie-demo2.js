// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart2");
var myPieChart2 = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["Playstation 5", "Playstation 4", "Playstation 3"],
    datasets: [],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});

$.get('/chart-pie-data', function(data) {
  console.log(data.labels);
  console.log(data.datasets)
  myPieChart2.data.labels = data.labels;
  myPieChart2.data.datasets = data.datasets;
  myPieChart2.update();
});
