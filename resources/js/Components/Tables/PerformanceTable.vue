<template>
  <div class="row mb-4">
    <div class="col-12 mt-4" v-for="(performance, index) in props.performance" :key="index">
      <!-- <div class="col-12 mt-4" v-for="(performance, index) in test.data" :key="index"> -->
      <bar-chart :id="performance.year" :title="`Performance ${performance.year}`" height="200" :chart="{
        labels: getMonthLabels(),
        datasets: {
          label: 'Performance',
          data: performance.total,
        },
      }" />
    </div>
  </div>
  <div class="row mb-4">
    <div class="col-12">
      <div class="card bg-gray-100 shadow-none " style="overflow-x: auto;">
        <div class="card-body p-0">
          <div>
            <table class="table table-borderless text-center text-sm">
              <thead>
                <tr>
                  <th></th>
                  <th class="pb-1" v-for="month in getMonthLabels()" :key="month">{{ month }}</th>
                </tr>
              </thead>
              <tbody class="bg-white rounded-lg">
                <tr v-for="(performance, index) in props.performance" :key="index">
                  <!-- <tr v-for="(performance, index) in test.data" :key="index"> -->
                  <td class="fw-bold" style="border-top: 8px solid #F8F9FA;">{{ performance.year }}</td>
                  <td class="fw-bold" style="border-top: 8px solid #F8F9FA;" :class="$filters.percentage_colour(percentage)"
                    v-for="(percentage, index) in Array.from({ length: 12 }, (_, index) => performance.percentage[index] || '')"
                    :key="index">{{ percentage ? (parseFloat(percentage).toFixed(2) + '%') : '' }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive } from "vue";
import BarChart from "@/Components/Charts/BarChart.vue";

const props = defineProps({
  performance: {
    type: [Object, Array],
    default: []
  },
});

const test = reactive({
  data: [{ "year": "2023", "total": ["1567", "1582", "1220"], "percentage": ["12.4365", "13.7565", "11.9608"] }, { "year": "2024", "total": ["1567", "1582", "1220"], "percentage": ["12.4365", "13.7565", "11.9608"] }, { "year": "2025", "total": ["1567", "1582", "1220"], "percentage": ["12.4365", "13.7565", "11.9608"] }, { "year": "2026", "total": ["1567", "1582", "1220"], "percentage": ["12.4365", "13.7565", "11.9608"] }]
})

function getMonthLabels() {
  return [
    'Jan',
    'Feb',
    'Mar',
    'Apr',
    'May',
    'Jun',
    'Jul',
    'Aug',
    'Sep',
    'Oct',
    'Nov',
    'Dec',
  ];
}
</script>
