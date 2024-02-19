<template>
  <div class="card z-index-2 shadow-none p-0">
    <div class="p-0 card-header mb-0">
      <div class="d-flex">
        <div class="col-6 text-start">
          <h5 :class="{ 'text-danger fw-normal': chart.return_all_time < 0 }" style="color: #2dce89; font-weight: bold">
            {{ $filters.percentage(chart.return_all_time) }}
          </h5>
          <p class="text-sm fw-bold">RETURN (ALL TIME)</p>
        </div>
        <div class="col-6 text-end">
          <h5 :class="{ 'text-danger fw-normal': success_fee < 0 }" style="color: #2dce89; font-weight: bold">
            {{ $filters.percentage(success_fee) }}
          </h5>
          <p class="text-sm fw-bold">SUCCESS FEE</p>
        </div>
      </div>
    </div>
    <div class="p-0 card-body">
      <div class="chart">
        <canvas :id="id" class="chart-canvas" :height="height"></canvas>
      </div>
    </div>
  </div>
</template>

<script>
import Chart from "chart.js/auto";

export default {
  name: "GradientLineChartGreenRed",
  props: {
    id: {
      type: [Number, String],
      required: true,
    },
    height: {
      type: String,
      default: "300",
    },
    return_all_time: {
      type: [Number, String],
      default: 0,
    },
    success_fee: {
      type: Number,
      default: 0,
    },
    chart: {
      type: Object,
      required: true,
      labels: Array,
      datasets: {
        type: Array,
        data: Array,
      },
      return_all_time: Number,
    },
  },
  mounted() {
    var gradientLineChart = document.getElementById(this.id).getContext("2d");

    var gradientGreen = gradientLineChart.createLinearGradient(0, 230, 0, 50);

    gradientGreen.addColorStop(1, "rgba(71, 223, 207, 0.32)");
    gradientGreen.addColorStop(0.5, "rgba(71, 223, 207,0.1)");
    gradientGreen.addColorStop(0.3, "rgba(71, 223, 207, 0.01)");

    var gradientRed = gradientLineChart.createLinearGradient(0, 230, 0, 50);

    gradientRed.addColorStop(1, "rgba(255, 99, 71, 0.32)");
    gradientRed.addColorStop(0.5, "rgba(255, 99, 71,0.1)");
    gradientRed.addColorStop(0.3, "rgba(255, 99, 71, 0.01)");

    var gradientGray = gradientLineChart.createLinearGradient(0, 230, 0, 50);

    gradientGray.addColorStop(1, "rgba(128, 128, 128, 0.32)");
    gradientGray.addColorStop(0.5, "rgba(128, 128, 128,0.1)");
    gradientGray.addColorStop(0.3, "rgba(128, 128, 128, 0.01)");


    const setbackgroundColor = () => {
      // let chartData = this.chart.datasets[0].data;
      // if (chartData != null) {
      //   if (chartData[(chartData.length) - 1] > chartData[(chartData.length) - 2]) {
      //       return gradientGreen
      //   } else return gradientRed
      // }
      if (this.chart.return_all_time > 0) {
        return gradientGreen
      } else if (this.chart.return_all_time < 0) {
        return gradientRed
      } else return gradientGray
    }

    const setborderColor = () => {
      // let chartData = this.chart.datasets[0].data;
      // if (chartData != null) {
      //   if (chartData[(chartData.length) - 1] > chartData[(chartData.length) - 2]) {
      //     return "#47DFCF"
      //   } else return "#FF0000"
      // }
      if (this.chart.return_all_time > 0) {
        return "#47DFCF"
      } else if (this.chart.return_all_time < 0) {
        return "#FF0000"
      } else return "#808080"
    }

    let chartStatus = Chart.getChart(this.id);
    if (chartStatus != undefined) {
      chartStatus.destroy();
    }

    if (this.chart.datasets.length == 2) {

      new Chart(gradientLineChart, {
        type: "line",
        data: {
          labels: this.chart.labels,
          datasets: [
            {
              label: 'Returns (%)',
              tension: 0.4,
              borderWidth: 0,
              pointRadius: 0,
              borderColor: "#4BB543 ",
              backgroundColor: setbackgroundColor,
              // eslint-disable-next-line no-dupe-keys
              borderWidth: 3,
              fill: true,
              data: this.chart.datasets[0].data,
              maxBarThickness: 6,
            },
            {
              label: 'Returns (%)',
              tension: 0.4,
              borderWidth: 0,
              pointRadius: 0,
              borderColor: "#3A416F",
              // eslint-disable-next-line no-dupe-keys
              borderWidth: 3,
              backgroundColor: setbackgroundColor,
              fill: true,
              data: this.chart.datasets[1].data,
              maxBarThickness: 6,
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            },
          },
          interaction: {
            intersect: false,
            mode: "index",
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [5, 5],
              },
              ticks: {
                display: true,
                padding: 10,
                color: "#fbfbfb",
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: "normal",
                  lineHeight: 2,
                },
              },
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
                borderDash: [5, 5],
              },
              ticks: {
                display: true,
                color: "#ccc",
                padding: 20,
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: "normal",
                  lineHeight: 2,
                },
              },
            },
          },
        },
      });
    } else if (this.chart.datasets.length == 1) {

      new Chart(gradientLineChart, {
        type: "line",
        data: {
          labels: this.chart.labels,
          datasets: [
            {
              label: 'Returns (%)',
              tension: 0.4,
              borderWidth: 0,
              pointRadius: 0,
              borderColor: setborderColor,
              backgroundColor: setbackgroundColor,
              // eslint-disable-next-line no-dupe-keys
              borderWidth: 2,
              fill: true,
              data: this.chart.datasets[0].data,
              maxBarThickness: 6,
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            },
          },
          interaction: {
            intersect: false,
            mode: "index",
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [5, 5],
              },
              ticks: {
                display: true,
                padding: 0,
                color: "#fbfbfb",
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: "normal",
                  lineHeight: 2,
                },
              },
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
                borderDash: [5, 5],
              },
              ticks: {
                display: false,
                color: "#ccc",
                padding: 0,
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: "normal",
                  lineHeight: 2,
                },
              },
            },
          },
        },
      });
    }
  },
};
</script>
