<template>
    <AppLayout title="Dashboard">
        <div class="py-4 container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <!-- 4 Statistic Cards -->
                    <div class="row" v-if="stats">
                        <div class="col-lg-3 col-md-6 col-12">
                            <mini-statistics-card
                                title="Portfolio"
                                :value="$filters.currency(stats.portfolio ?? 0)"
                                :percentage="stats.diff_portfolio"
                                :icon="{
                                    component: 'ni ni-money-coins',
                                    background: 'bg-gradient-primary',
                                    shape: 'rounded-circle',
                                }"
                            />
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <mini-statistics-card
                                title="Profit"
                                :value="$filters.currency(stats.profit ?? 0)"
                                :percentage="stats.diff_profit"
                                :icon="{
                                    component: 'ni ni-briefcase-24',
                                    background: 'bg-gradient-primary',
                                    shape: 'rounded-circle',
                                }"
                            />
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <mini-statistics-card
                                title="Internal Wallet"
                                :value="
                                    $filters.currency(
                                        stats.internal_wallet ?? 0
                                    )
                                "
                                :percentage="stats.diff_internal_wallet"
                                :icon="{
                                    component: 'ni ni-credit-card',
                                    background: 'bg-gradient-primary',
                                    shape: 'rounded-circle',
                                }"
                            />
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <mini-statistics-card
                                title="TOTAL INVESTED"
                                :value="
                                    $filters.currency(
                                        stats.invested_amount ?? 0
                                    )
                                "
                                :percentage="stats.diff_invested_amount"
                                :icon="{
                                    component: 'ni ni-chart-bar-32',
                                    background: 'bg-gradient-primary',
                                    shape: 'rounded-circle',
                                }"
                            />
                        </div>
                    </div>

                    <!-- Performance Line Chart -->
                    <!-- <div class="row mt-1">
                        <div class="col-lg-12 mb-lg">
                            <gradient-line-chart id="chart-line" title="Performance"
                                :return_rate="performance.percentage !== 0 ? performance.percentage : 0" :chart="{
                                    labels: performance.title,
                                    datasets: [
                                        {
                                            label: '',
                                            data: performance.graph,
                                        },
                                    ],
                                }" :class="performance.graph.length > 0 ? '' : 'overlay'" />
                        </div>
                    </div> -->

                    <!-- Investment Line Charts-->
                    <div class="row mt-4">
                        <!-- Display fake positive investment data when user does not have any investments -->
                        <div
                            class="col-12 position-relative"
                            v-if="investments.length < 1"
                        >
                            <h5 class="mb-3">Investment</h5>
                            <carousel
                                v-if="rerender"
                                :items-to-show="2"
                                :mouseDrag="true"
                                :breakpoints="carouselSettings.breakpoints"
                                style="filter: blur(2px)"
                            >
                                <slide
                                    v-for="investment in defaultInvestments"
                                    :key="investment.uuid"
                                >
                                    <CopyTraderCard
                                        :trader="{
                                            id: investment.id,
                                            image: investment.image,
                                            name: investment.name,
                                            username: investment.username,
                                            risk_level: investment.risk_level,
                                            dataset: investment.graph,
                                        }"
                                        :successFee="{
                                            percentage: investment.successFee,
                                        }"
                                        :profitOpenPositions="{
                                            percentage:
                                                investment.profitOpenPositions,
                                        }"
                                        :people="{ amount: investment.people }"
                                        :action="{
                                            route: 'javascript:;',
                                            label: 'View Trader',
                                        }"
                                        :customClass="'col-11'"
                                    />
                                </slide>
                                <template #addons></template>
                            </carousel>
                            <div
                                v-if="rerender"
                                class="position-absolute bg-gray-300 rounded-3 noActiveInvestmentBg"
                            >
                                <div class="m-auto text-center">
                                    <h5>No Active Investments ...</h5>
                                    <i
                                        class="ni ni-chart-bar-32 my-5"
                                        style="font-size: 4rem"
                                    ></i>
                                    <h5>Let's Start Copy Trading</h5>
                                    <a
                                        :href="route('trader.list')"
                                        type="button"
                                        color="success"
                                        class="btn btn-primary my-2"
                                    >
                                        Choose Trader
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Has minimum 1 Investment -->
                        <div class="col-12" v-if="investments.length >= 1">
                            <h5 class="mb-3">Investment</h5>
                            <carousel
                                v-if="rerender"
                                :items-to-show="2"
                                :mouseDrag="true"
                                :breakpoints="carouselSettings.breakpoints"
                            >
                                <slide
                                    v-for="investment in investments"
                                    :key="investment.id"
                                >
                                    <CopyTraderCard
                                        :trader="{
                                            id: investment.username,
                                            image: $filters.avatar(
                                                investment.profile_photo_path,
                                                investment.name
                                            ),
                                            name: investment.name,
                                            username: investment.username,
                                            risk_level: investment.risk_level,
                                            dataset: investment.graph,
                                        }"
                                        :successFee="{
                                            percentage:
                                                investment.success_fee_percent ??
                                                0,
                                        }"
                                        :returnAllTime="{
                                            percentage:
                                                investment.return_rate ?? 0,
                                        }"
                                        :profitOpenPositions="{
                                            percentage:
                                                investment.diff_balance_percent ??
                                                0,
                                        }"
                                        :people="{
                                            amount: investment.people ?? 0,
                                        }"
                                        :action="{
                                            route: `/trader/${investment.username}`,
                                            label: 'View Trader',
                                        }"
                                        :customClass="'col-11'"
                                    />
                                </slide>
                                <template #addons></template>
                            </carousel>
                        </div>
                    </div>
                    <!-- Following Line Charts-->
                    <div class="row mt-4">
                        <div class="col">
                            <h5 class="mb-3" v-if="followings.length >= 1">
                                Following
                            </h5>
                            <carousel
                                :items-to-show="2"
                                :mouseDrag="true"
                                :breakpoints="carouselSettings.breakpoints"
                            >
                                <slide
                                    v-for="following in followings"
                                    :key="following.id"
                                >
                                    <CopyTraderCard
                                        :trader="{
                                            id: following.id,
                                            image: $filters.avatar(
                                                following.profile_photo_path,
                                                following.name
                                            ),
                                            name: following.name,
                                            username: following.username,
                                            risk_level: following.risk_level,
                                            dataset: following.graph,
                                        }"
                                        :successFee="{
                                            percentage:
                                                following.success_fee_percent ??
                                                0,
                                        }"
                                        :returnAllTime="{
                                            percentage:
                                                following.return_rate ?? 0,
                                        }"
                                        :profitOpenPositions="{
                                            percentage:
                                                following.profitOpenPositions ??
                                                0,
                                        }"
                                        :people="{
                                            amount: following.copying ?? 0,
                                        }"
                                        :action="{
                                            route: `/trader/${following.username}`,
                                            label: 'View Trader',
                                        }"
                                        :customClass="'col-11'"
                                    />
                                </slide>
                                <template #addons></template>
                            </carousel>
                        </div>
                        <!-- Display when user does not have any following -->
                        <div
                            class="col-12 position-relative"
                            v-if="followings.length < 1"
                        >
                            <h5 class="mb-3">Following</h5>
                            <carousel
                                :items-to-show="2"
                                :mouseDrag="true"
                                :breakpoints="carouselSettings.breakpoints"
                                style="filter: blur(2px)"
                            >
                                <slide
                                    v-for="investment in defaultInvestments"
                                    :key="investment.uuid"
                                >
                                    <CopyTraderCard
                                        :trader="{
                                            id: investment.id + 4,
                                            image: investment.image,
                                            name: investment.name,
                                            username: investment.username,
                                            risk_level: investment.risk_level,
                                            dataset: investment.graph,
                                        }"
                                        :successFee="{
                                            percentage: investment.successFee,
                                        }"
                                        :returnAllTime="{
                                            percentage:
                                                investment.profitAllTime,
                                        }"
                                        :profitOpenPositions="{
                                            percentage:
                                                investment.profitOpenPositions,
                                        }"
                                        :people="{ amount: investment.people }"
                                        :action="{
                                            route: 'javascript:;',
                                            label: 'View Trader',
                                        }"
                                        :customClass="'col-11'"
                                    />
                                </slide>
                                <template #addons></template>
                            </carousel>
                            <div
                                class="position-absolute bg-gray-300 rounded-3 noActiveInvestmentBg"
                            >
                                <div class="m-auto text-center">
                                    <i
                                        class="ni ni-album-2 my-5"
                                        style="font-size: 4rem"
                                    ></i>
                                    <h5>No Active Followings ...</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- List of Close Trades Table -->
                    <div class="row">
                        <div class="col-12">
                            <ListOfCloseTradesTable
                                :closeTrades="close_trades"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { reactive, ref, watch } from "vue";
import AppLayout from "@/Layouts/User/AppLayout.vue";
import MiniStatisticsCard from "@/Components/Cards/MiniStatisticsCard.vue";
import GradientLineChart from "@/Components/Charts/GradientLineChart.vue";
import CopyTraderCard from "@/Components/Cards/CopyTraderCard.vue";
import ListOfCloseTradesTable from "@/Components/Tables/ListOfCloseTradesTable.vue";
import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide } from "vue3-carousel";
import ArgonButton from "@/Components/ArgonButton.vue";
import team1 from "@/assets/img/team-1.jpg";
import team2 from "@/assets/img/team-2.jpg";
import team3 from "@/assets/img/team-3.jpg";
import team4 from "@/assets/img/team-4.jpg";

const props = defineProps({
    stats: {
        type: [Object, Array],
        default: () => ({}),
    },
    investments: {
        type: [Object, Array],
        default: () => ({}),
    },
    followings: {
        type: [Object, Array],
        default: () => ({}),
    },
    performance: {
        type: [Object, Array],
        default: () => ({}),
    },
    close_trades: {
        type: [Object, Array],
        default: () => ({}),
    },
});

const rerender = ref(true);

watch(
    () => props.investments,
    (newValue, oldValue) => {
        rerender.value = false;
        setTimeout(() => {
            rerender.value = true;
        }, 1);
    }
);

function generateLabels(numDates) {
    const dateArray = Array(numDates)
        .fill("")
        .map((_, index) => {
            const date = new Date();
            date.setDate(date.getDate() - numDates + index + 1);
            const month = new Intl.DateTimeFormat("en-US", {
                month: "long",
            }).format(date);
            const day = date.getDate();
            return `${month} ${day}`;
        });
    return dateArray;
}

function generateData(numDataPoints) {
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
}

// Default Data //
const defaultInvestments = reactive([
    {
        id: 100001,
        image: team1,
        name: "name1",
        username: "username1",
        risk_level: 1,
        successFee: 50,
        returnAllTime: 5,
        profitOpenPositions: 5,
        people: 100,
        graph: {
            graph: generateData(9),
            title: generateLabels(9),
            returnPercentSum: 50,
        },
    },
    {
        id: 100002,
        image: team2,
        name: "name2",
        username: "username2",
        risk_level: 1,
        successFee: 60,
        returnAllTime: 5,
        profitOpenPositions: 5,
        people: 200,
        graph: {
            graph: generateData(9),
            title: generateLabels(9),
            returnPercentSum: 50,
        },
    },
    {
        id: 100003,
        image: team3,
        name: "name3",
        username: "username3",
        risk_level: 1,
        successFee: 60,
        returnAllTime: 5,
        profitOpenPositions: 5,
        people: 250,
        graph: {
            graph: generateData(9),
            title: generateLabels(9),
            returnPercentSum: 50,
        },
    },
    {
        id: 100004,
        image: team4,
        name: "name3",
        username: "username3",
        risk_level: 1,
        successFee: 60,
        returnAllTime: -5,
        profitOpenPositions: -5,
        people: 250,
        graph: {
            graph: generateData(9),
            title: generateLabels(9),
            returnPercentSum: 50,
        },
    },
]);

const numberOfCards = (width) => {
    return width / 500;
};

// Carousel Settings //
const carouselSettings = reactive({
    breakpoints: {
        // 0px and up
        0: {
            itemsToShow: 1.1,
            snapAlign: "start",
        },
        // 768px and up
        768: {
            itemsToShow: numberOfCards(768),
            snapAlign: "start",
        },
        // 992px and up
        992: {
            itemsToShow: numberOfCards(992),
            snapAlign: "start",
        },
        // 1400px and up
        1400: {
            itemsToShow: numberOfCards(1400),
            snapAlign: "start",
        },
        // 1600 and up
        1600: {
            itemsToShow: numberOfCards(1600),
            snapAlign: "start",
        },
        // 1920 and up
        1920: {
            itemsToShow: numberOfCards(1920),
            snapAlign: "start",
        },
        // 2160 and up
        2160: {
            itemsToShow: numberOfCards(2160),
            snapAlign: "start",
        },
    },
});
</script>

<style>
.noActiveInvestmentBg {
    display: flex;
    top: 8%;
    width: 99%;
    height: 92%;
    opacity: 0.9;
}

.overlay {
    position: relative;
}

.overlay::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #dee2e6;
    /* background-size: 50px 50px; */
    opacity: 0.2;
    z-index: 3;
    border-radius: 16px;
}

.overlay::after {
    content: "No Active Trades";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 1.25rem;
    font-weight: 600;
    opacity: 0.6;
}
</style>
