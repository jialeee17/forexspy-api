<template>
    <div class="card col shadow-none copytrader-card scale-up-on-hover" :class="customClass">
        <div class="p-4 pb-0 card-header">
            <div class="row">
                <div class="col-8 d-flex">
                    <div>
                        <img :src="trader.image" class="avatar avatar-sm me-3 mt-2" alt="avatar image" />
                    </div>
                    <div class="d-flex flex-column justify-content-center text-start">
                        <h6 class="mb-0 text-sm">{{ trader.name }}</h6>
                        <p class="text-xs">{{ trader.username }}</p>
                    </div>
                </div>
                <div class="col-4 text-end">
                    <h5 :style="{ 'color': trader.risk_level === 4 ? '#FF8C00' : '' }"
                        :class="{ 'text-danger': trader.risk_level === 5, 'text-success': trader.risk_level < 4 }">{{
                            trader.risk_level }}</h5>
                    <p class="fw-bold text-xs">RISK LEVEL</p>
                </div>
            </div>
        </div>
        <hr class="mx-4 mt-2 mb-0" />
        <div class="card-body pt-3 pb-0">
            <!-- Line Charts -->
            <div class="row">
                <div class="col-lg-12 mb-lg">
                    <gradient-line-chart-green-red :id="trader.id" height="200" :success_fee="successFee.percentage" :chart="{
                            labels: trader.dataset.title,
                            datasets: [
                                {
                                    data: trader.dataset.graph,
                                },
                            ],
                            return_all_time: trader.dataset.returnPercentSum,
                        }" />
                </div>
            </div>
        </div>
        <div class="p-3 pt-1 card-footer">
            <div class="p-3 d-flex border-radius-lg">
                <p class="my-auto text-start">{{ people.amount }} people copying this trader</p>
                <a :href="action.route" class="mb-0 ms-auto text-primary fw-bolder text-end">
                    {{ action.label }}
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import GradientLineChartGreenRed from "@/Components/Charts/GradientLineChartGreenRed.vue";

export default {
    name: "AnnouncementCard",
    components: {
        GradientLineChartGreenRed,
    },
    props: {
        trader: {
            type: Object,
            default: () => { },
            id: Number,
            image: String,
            name: String,
            username: String,
            risk_level: Number, String,
        },
        successFee: {
            type: Object,
            default: () => { },
            percentage: Number,
        },
        profitOpenPositions: {
            type: Object,
            default: () => { },
            percentage: Number,
        },
        people: {
            type: Object,
            amount: Number,
            default: () => { },
        },
        action: {
            type: Object,
            route: String,
            label: String,
            default: () => { },
        },
        customClass: {
            type: String,
        }
    },
};
</script>

<style>
/* .copytrader-card {
    min-width: 280px;
    max-width: 500px;
}

@media only screen and (min-width: 576px) {
    .copytrader-card {
        min-width: 320px;
        max-width: 700px;
    }
}

@media only screen and (min-width: 992px) {
    .copytrader-card {
        min-width: 360px;
        max-width: 600px;
    }
}

@media only screen and (min-width: 1200px) {
    .copytrader-card {
        min-width: 370px;
        max-width: 600px;
    }
}

@media only screen and (min-width: 1400px) {
    .copytrader-card {
        min-width: 370px;
    }
} */
</style>
