<template>
    <div class="container-fluid card card-body mb-4">
        <div class="d-flex justify-content-center pe-2 my-2">
            <div class="pulse-dot my-auto me-2"></div>
            <h6 class="my-auto fw-bold">LIVE TRADING</h6>
        </div>
        <div class="d-flex justify-content-center pt-2 pb-4 flex-wrap" style="z-index: 3;">
            <div class="mx-2 text-center" style="width: 14rem;">
                <select v-on:change="fetchData(($event.target.value)); dataChannel(($event.target.value))"
                    id="choices-symbols" class="form-control" name="choices-symbols">
                    <option :value="symbol.name" v-for="symbol in symbols" :key="symbol.id">{{ symbol.name }}</option>
                </select>
            </div>
        </div>
        <p v-if="!chart.data.length && !chart.loading" class="text-center fw-bold">Live chart is currently unavailable.</p>
        <div class="chart-container">
            <LWChart :type="chartType" :data="chart.data" :markers="trades" :symbol="chart.prevTicker" :autosize="true"
                :chart-options="chartOptions" :series-options="seriesOptions" :time-scale-options="timeScaleOptions"
                :price-scale-options="priceScaleOptions" ref="lwChart" v-if="!chart.loading" />
            <div v-if="chart.loading" class="loading-dots" style="margin: 180px auto;">
                <div class="one"></div>
                <div class="two"></div>
                <div class="three"></div>
            </div>

        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, reactive, onUnmounted } from 'vue';
import LWChart from './LWChart.vue';
import Choices from "choices.js";

const props = defineProps({
    symbols: {
        type: [Object, Array],
        default: () => ({})
    },
    trades: {
        type: [Object, Array],
        default: () => ({})
    }
})

const chart = reactive({
    data: [],
    loading: true,
    prevTicker: props.symbols[0].symbol
})

const fetchData = async (ticker) => {
    chart.loading = true;
    await fetch(`https://data.cotrade.finance/api/historical/${ticker}`)
        .then(response => response.json())
        .then(data => {
            // chart.data.splice(0, chart.data.length);
            let formattedData = []
            chart.data = data;

            // if (data) {
            //     formattedData = data.map((item) => ({
            //         time: (item.timestamp) / 1000,
            //         open: parseFloat(item.open),
            //         high: parseFloat(item.high),
            //         low: parseFloat(item.low),
            //         close: parseFloat(item.close),
            //     }));
            // }
            // chart.data = formattedData

            // if (chart.data) {
            //     for (let i = 1; i < chart.data.length; i++) {
            //         if (chart.data[i].time === chart.data[i - 1].time) {
            //             chart.data.splice(i, 1);
            //             i--;
            //         }
            //     }
            //     chart.loading = false;
            // }
        })
        .then(() => {
            chart.loading = false;
        })
        .catch(() => { })
}

const dataChannel = (ticker) => {
    Echo.leaveChannel(`ohlc.channel.${chart.prevTicker}`);
    chart.prevTicker = ticker
    var channel = Echo.channel(`ohlc.channel.${ticker}`);
    channel.listen('.ohlc', function (data) {
        let formattedData = {}

        if (data) {
            formattedData = {
                time: (data.message.timestamp) / 1000,
                open: parseFloat(data.message.open),
                high: parseFloat(data.message.high),
                low: parseFloat(data.message.low),
                close: parseFloat(data.message.close),
            };
        }
        (chart.data).push(formattedData);
    });
}

onMounted(() => {
    fetchData(chart.prevTicker)
    dataChannel(chart.prevTicker)
}) 

onUnmounted(() => {
    // leave a channel and also its associated private and presence channels
    Echo.leave(`ohlc.channel.${chart.prevTicker}`);
})

const chartOptions = ref({});
// const data = ref(generateSampleData(false));

const seriesOptions = ref({
    color: 'rgb(45, 77, 205)',
});

const timeScaleOptions = ref({
    timeVisible: true,
    // secondsVisible: true,
    barSpacing: 15,
})

const priceScaleOptions = ref({
    priceFormat: {
        type: 'price',
        precision: 4,
        minMove: 0.0001,
    },
})

const chartType = ref('candlestick');
const lwChart = ref();

// function randomShade() {
// 	return Math.round(Math.random() * 255);
// }

// const randomColor = (alpha = 1) => {
// 	return `rgba(${randomShade()}, ${randomShade()}, ${randomShade()}, ${alpha})`;
// };

// const colorsTypeMap = {
// 	area: [
// 		['topColor', 0.4],
// 		['bottomColor', 0],
// 		['lineColor', 1],
// 	],
// 	bar: [
// 		['upColor', 1],
// 		['downColor', 1],
// 	],
// 	baseline: [
// 		['topFillColor1', 0.28],
// 		['topFillColor2', 0.05],
// 		['topLineColor', 1],
// 		['bottomFillColor1', 0.28],
// 		['bottomFillColor2', 0.05],
// 		['bottomLineColor', 1],
// 	],
// 	candlestick: [
// 		['upColor', 1],
// 		['downColor', 1],
// 		['borderUpColor', 1],
// 		['borderDownColor', 1],
// 		['wickUpColor', 1],
// 		['wickDownColor', 1],
// 	],
// 	histogram: [['color', 1]],
// 	line: [['color', 1]],
// };

// Set a random colour for the series as an example of how
// to apply new options to series. A similar appraoch will work on the
// option properties.
// const changeColors = () => {
// 	const options = {};
// 	const colorsToSet = colorsTypeMap[chartType.value];
// 	colorsToSet.forEach((c) => {
// 		options[c[0]] = randomColor(c[1]);
// 	});
// 	seriesOptions.value = options;
// };

// const changeData = () => {
// 	const candlestickTypeData = ['candlestick', 'bar'].includes(chartType.value);
// 	const newData = generateSampleData(candlestickTypeData);
// 	data.value = newData;
// 	if (chartType.value === 'baseline') {
// 		const average =
// 			newData.reduce((s, c) => {
// 				return s + c.value;
// 			}, 0) / newData.length;
// 		seriesOptions.value = { baseValue: { type: 'price', price: average } };
// 	}
// };

// const changeType = () => {
// 	const types = [
// 		'line',
// 		'area',
// 		'baseline',
// 		'histogram',
// 		'candlestick',
// 		'bar',
// 	].filter((t) => t !== chartType.value);
// 	const randIndex = Math.round(Math.random() * (types.length - 1));
// 	chartType.value = types[randIndex];
// 	changeData();

// 	// call a method on the component.
// 	lwChart.value.fitContent();
// };

// Symbols Dropdown //
onMounted(() => {
    if (document.getElementById("choices-symbols")) {
        var symbol = document.getElementById("choices-symbols");
        new Choices(symbol, {
            searchEnabled: false,
            itemSelectText: "",
            allowHTML: true,
        });
    }
});

// Traders Dropdown //
onMounted(() => {
    if (document.getElementById("choices-traders")) {
        var trader = document.getElementById("choices-traders");
        new Choices(trader, {
            searchEnabled: false,
            itemSelectText: "",
            allowHTML: true,
        });
    }
});
</script>

<style scoped>
.chart-container {
    height: 500px;
}
</style>
