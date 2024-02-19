<template>
  <div class="card h-100 shadow">
    <div class="p-3 pb-0 card-header">
      <div class="d-flex flex-column">
        <h6 class="mb-0">{{ title }}</h6>
        <slot name="header"></slot>
      </div>
    </div>
    <div class="p-3 card-body d-flex flex-column justify-content-between">
      <div class="my-auto">
        <div class="chart">
          <canvas :id="id" class="chart-canvas" :height="height"></canvas>
        </div>
      </div>
      <div class="mx-auto my-3">
        <div class="d-flex flex-wrap">
          <!-- Forex -->
          <div class="d-flex me-3">
            <div class="my-auto me-1">
              <div
                class="border"
                style="width: 12px; height: 12px; background-color: #596cff"
              ></div>
            </div>
            <h6 class="mb-0 text-sm me-2">Forex</h6>
            <h6 class="mb-0 text-sm">{{ forex }}%</h6>
          </div>
          <!-- Crypto -->
          <div class="d-flex me-3">
            <div class="my-auto me-1">
              <div
                class="border"
                style="width: 12px; height: 12px; background-color: #d63384"
              ></div>
            </div>
            <h6 class="mb-0 text-sm me-2">Crypto</h6>
            <h6 class="mb-0 text-sm">{{ crypto }}%</h6>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Chart from "chart.js/auto";
export default {
  name: "DefaultDoughnutChart",
  props: {
    id: {
      type: String,
      default: "default-doughnut-chart",
    },
    height: {
      type: String,
      default: "150",
    },
    title: {
      type: String,
      default: "Default Doughnut Chart",
    },
    chart: {
      type: Object,
      required: true,
      labels: String,
      datasets: {
        type: Array,
        label: String,
        data: Array,
      },
    },
    forex: {
      type: Number,
      default: 0
    },
    crypto: {
      type: Number,
      default: ''
    },
    actions: {
      type: Object,
      route: String,
      color: String,
      label: String,
      default: () => ({
        color: "secondary",
        label: "See all refferals",
      }),
    },
  },
  mounted() {
    var chart = document.getElementById(this.id).getContext("2d");

    let chartStatus = Chart.getChart(this.id);
    if (chartStatus != undefined) {
      chartStatus.destroy();
    }

    new Chart(chart, {
      type: "doughnut",
      data: {
        labels: this.chart.labels,
        datasets: [
          {
            label: this.chart.datasets[0].label,
            weight: 9,
            cutout: 60,
            tension: 0.9,
            pointRadius: 2,
            borderWidth: 2,
            backgroundColor: ["#596CFF", "#D63384"],
            data: this.chart.datasets[0].data,
            fill: false,
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
              drawOnChartArea: false,
              drawTicks: false,
            },
            ticks: {
              display: false,
            },
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
            },
            ticks: {
              display: false,
            },
          },
        },
      },
    });
  },
};
</script>
