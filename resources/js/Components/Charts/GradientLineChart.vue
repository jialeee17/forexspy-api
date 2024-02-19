<template>
  <div class="card z-index-2">
    <div class="pb-0 card-header mb-0">
      <h6>{{ title }}</h6>
      <p v-if="return_rate > 0" class="text-sm"><span class="fw-bold text-success"><i class="fa fa-arrow-up"></i> {{
        $filters.percentage(return_rate, 2) }}
          more</span> in {{ getCurrentYear() }}</p>
      <p v-if="return_rate < 0" class="text-sm"><span class="fw-bold text-danger"><i class="fa fa-arrow-down"></i> {{
        $filters.percentage(-1, 2) }}
          less</span> in {{ getCurrentYear() }}</p>
      <p v-if="return_rate === 0" class="text-sm"><span class="fw-bold text-secondary">{{
        $filters.percentage(return_rate, 2) }}
        </span> in {{ getCurrentYear() }}</p>
    </div>
    <div class="p-3 card-body">
      <div class="chart">
        <canvas :id="id" class="chart-canvas" :height="height"></canvas>
      </div>
    </div>
  </div>
</template>

<script>
import Chart from "chart.js/auto";

export default {
  name: "GradientLineChart",
  props: {
    id: {
      type: [Number, String],
      required: true,
    },
    height: {
      type: String,
      default: "300",
    },
    title: {
      type: [Number, String],
      default: "",
    },
    return_rate: {
      type: [Number, String],
      default: 0,
    },
    chart: {
      type: Object,
      required: true,
      labels: Array,
      datasets: {
        type: Array,
        label: String,
        data: Array,
      },
    },
  },
  methods: {
    getCurrentYear() {
      return new Date().getFullYear();
    },

    generateLabels(numDates) {
      const dateArray = Array(numDates).fill("").map((_, index) => {
        const date = new Date();
        date.setDate(date.getDate() - numDates + index + 1);
        const month = new Intl.DateTimeFormat('en-US', { month: 'long' }).format(date);
        const day = date.getDate();
        return `${month} ${day}`;
      });
      return dateArray;
    },

    generateData(numDataPoints) {
      const data = [];
      let lastValue = Math.floor(Math.random() * 50) + 1;
      for (let i = 0; i < numDataPoints; i++) {
        let newValue;
        if (i === numDataPoints - 1) {
          // Last data point - ensure it is higher than the second-to-last value
          newValue = lastValue + Math.floor(Math.random() * 50) + 1;
        } else {
          // Generate random value between last value and last value + 10
          newValue = lastValue + Math.floor(Math.random() * 10);
        }
        data.push(newValue);
        lastValue = newValue;
      }
      return data;
    },

    createChart() {
      var gradientLineChart = document.getElementById(this.id).getContext("2d");

      var gradientBlue = gradientLineChart.createLinearGradient(0, 230, 0, 50);

      gradientBlue.addColorStop(1, "rgba(89, 108, 255, 0.22)");
      gradientBlue.addColorStop(0.2, "rgba(72,72,176,0.0)");
      gradientBlue.addColorStop(0, "rgba(255, 255, 255, 0)"); //blue colors

      var gradientGray = gradientLineChart.createLinearGradient(0, 230, 0, 50);

      gradientGray.addColorStop(1, "rgba(128, 128, 128, 0.22)");
      gradientGray.addColorStop(0.2, "rgba(128, 128, 128, 0.0)");
      gradientGray.addColorStop(0, "rgba(255, 255, 255, 0)"); // gray color

      var gradientStroke2 = gradientLineChart.createLinearGradient(0, 230, 0, 50);

      gradientStroke2.addColorStop(1, "rgba(20,23,39,0.2)");
      gradientStroke2.addColorStop(0.2, "rgba(72,72,176,0.0)");
      gradientStroke2.addColorStop(0, "rgba(20,23,39,0)"); //purple colors

      let chartStatus = Chart.getChart(this.id);
      if (chartStatus != undefined) {
        chartStatus.destroy();
      }

      new Chart(gradientLineChart, {
        type: "line",
        data: {
          labels: (this.chart.labels).length > 0 ? this.chart.labels : this.generateLabels(9),
          datasets: [
            {
              label: this.chart.datasets.label,
              tension: 0.4,
              borderWidth: 0,
              pointRadius: 0,
              borderColor: (this.chart.datasets[0].data).length > 0 ? '#596CFF' : 'rgba(128, 128, 128, 0.3)',
              backgroundColor: (this.chart.datasets[0].data).length > 0 ? gradientBlue : gradientGray,
              // eslint-disable-next-line no-dupe-keys
              borderWidth: 3,
              fill: true,
              data: (this.chart.datasets[0].data).length > 0 ? this.chart.datasets[0].data : this.generateData(9),
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
    }
  },

  mounted() {
    this.createChart()
  },

  beforeUpdate() {
    this.createChart()
  }
}
</script>
