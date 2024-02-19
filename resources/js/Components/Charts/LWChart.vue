<script setup>
import {
  ref,
  onMounted,
  onUnmounted,
  watch,
} from 'vue';
import { createChart } from 'lightweight-charts';

const props = defineProps({
  type: {
    type: String,
    default: 'line',
  },
  data: {
    type: Array,
    required: true,
  },
  autosize: {
    default: true,
    type: Boolean,
  },
  chartOptions: {
    type: Object,
  },
  seriesOptions: {
    type: Object,
  },
  timeScaleOptions: {
    type: Object,
  },
  priceScaleOptions: {
    type: Object,
  },
  markers: {
    type: Array,
    // default: () => ({})
  },
  symbol: {
    type: String,
  }
});

// Function to get the correct series constructor name for current series type.
function getChartSeriesConstructorName(type) {
  return `add${type.charAt(0).toUpperCase() + type.slice(1)}Series`;
}

// Lightweight Chart instances are stored as normal JS variables
// If you need to use a ref then it is recommended that you use `shallowRef` instead
let series;
let chart;

const chartContainer = ref();

const fitContent = () => {
  if (!chart) return;
  chart.timeScale().fitContent();
};

const getChart = () => {
  return chart;
};

defineExpose({ fitContent, getChart });

// Auto resizes the chart when the browser window is resized.
const resizeHandler = () => {
  if (!chart || !chartContainer.value) return;
  const dimensions = chartContainer.value.getBoundingClientRect();
  chart.resize(dimensions.width, dimensions.height);
};

// Creates the chart series and sets the data.
const addSeriesAndData = (props) => {
  const seriesConstructor = getChartSeriesConstructorName(props.type);
  series = chart[seriesConstructor](props.seriesOptions);
  series.setData(props.data);
};

const addMarkers = (props) => {

  function formatTimestamp(dateString) {
    const date = new Date(dateString.replace(" ", "T").replace(/\s(AM|PM)/i, ""));
    const unixTimestamp = Math.floor(date.getTime() / 1000);
    return unixTimestamp;
  }

  let formattedData = []
  if (props.markers) {
    formattedData = (props.markers).map((item) => ({
      open_time: formatTimestamp(item.open_timestamp),
      close_time: formatTimestamp(item.close_timestamp),
      open_price: parseFloat(item.open_price),
      close_price: parseFloat(item.close_price),
      type: item.type,
      symbol: item.symbol.symbol,
    }));
  }

  var markers = [];
  for (var i = 0; i < formattedData.length; i++) {
    if (formattedData[i].type === 'sell' && formattedData[i].symbol === props.symbol) {
      markers.push({ time: formattedData[i].close_time, position: 'aboveBar', color: '#e91e63', shape: 'arrowDown', text: 'Sell @ ' + formattedData[i].close_price });
    } else if (formattedData[i].type === 'buy' && formattedData[i].symbol === props.symbol) {
      markers.push({ time: formattedData[i].open_time, position: 'belowBar', color: '#2196F3', shape: 'arrowUp', text: 'Buy @ ' + formattedData[i].open_price });
    }
  }

  series.setMarkers(markers);
}

onMounted(() => {
  // Create the Lightweight Charts Instance using the container ref.
  chart = createChart(chartContainer.value, props.chartOptions);
  addSeriesAndData(props);
  addMarkers(props)

  if (props.priceScaleOptions) {
    series.applyOptions(props.priceScaleOptions);
  }

  if (props.timeScaleOptions) {
    chart.timeScale().applyOptions(props.timeScaleOptions);
  }

  // chart.timeScale().fitContent();

  // if (props.autosize) {
  //   window.addEventListener('resize', resizeHandler);
  // }
});

onUnmounted(() => {
  if (chart) {
    chart.remove();
    chart = null;
  }
  if (series) {
    series = null;
  }
});

/*
 * Watch for changes to any of the component properties.

 * If an options property is changed then we will apply those options
 * on top of any existing options previously set (since we are using the
 * `applyOptions` method).
 * 
 * If there is a change to the chart type, then the existing series is removed
 * and the new series is created, and assigned the data.
 * 
 */
watch(
  () => props.autosize,
  (enabled) => {
    if (!enabled) {
      window.removeEventListener('resize', resizeHandler);
      return;
    }
    window.addEventListener('resize', resizeHandler);
  }
);

watch(
  () => props.type,
  (newType) => {
    if (series && chart) {
      chart.removeSeries(series);
    }
    addSeriesAndData(props);
  }
);

watch(
  () => props.data,
  (newData) => {
    if (!series) return;
    series.setData(newData);
  }
);

watch(
  () => (props.data).length,
  (newData) => {
    series.update(props.data[(props.data.length) - 1]);
  }
);

watch(
  () => props.chartOptions,
  (newOptions) => {
    if (!chart) return;
    chart.applyOptions(newOptions);
  }
);

watch(
  () => props.seriesOptions,
  (newOptions) => {
    if (!series) return;
    series.applyOptions(newOptions);
  }
);

watch(
  () => props.priceScaleOptions,
  (newOptions) => {
    if (!chart) return;
    series.applyOptions(newOptions);
  }
);

watch(
  () => props.timeScaleOptions,
  (newOptions) => {
    if (!chart) return;
    chart.timeScale().applyOptions(newOptions);
  }
);
</script>

<template>
  <div class="lw-chart" ref="chartContainer"></div>
</template>

<style scoped>
.lw-chart {
  height: 100%;
}
</style>
