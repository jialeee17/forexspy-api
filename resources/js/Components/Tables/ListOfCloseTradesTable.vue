<template>
    <div class="py-4 container-fluid px-0">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>List of Close Trades</h5>
                        <p class="mb-0 text-sm">
                            List of closed trades.
                        </p>
                    </div>
                    <div class="table-responsive mt-0" v-if="rerender">
                        <table id="closed-trade-table" class="table table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Id</th>
                                    <th>Symbol</th>
                                    <th>Time</th>
                                    <th>Type</th>
                                    <th>Open Price</th>
                                    <th>Close Price</th>
                                    <th>Profit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr :key="closeTrade.id" v-for="(closeTrade, index) in closeTrades">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ closeTrade.symbol.name }}</td>
                                    <td>{{ closeTrade.close_timestamp }}</td>
                                    <td :class="{ green: closeTrade.type === 'buy' }">
                                        {{ closeTrade.type }}
                                    </td>
                                    <td>${{ closeTrade.open_price }}</td>
                                    <td>${{ closeTrade.close_price }}</td>
                                    <td :class="{ green: closeTrade.return_percent > 0 }">
                                        {{ closeTrade.return_percent }}%
                                    </td>
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
import { onMounted, ref, watch } from "vue";
import { DataTable } from "simple-datatables";

const props = defineProps({
    closeTrades: {
        type: [Object, Array],
        default: () => ({})
    },
    showTradersPerformance: {
        type: Boolean,
    }
});

const createTable = () => {
    let dataTable = new DataTable("#closed-trade-table", {
        searchable: true,
        fixedHeight: true,
        perPage: 5,
    });
}

onMounted(() => {
    createTable()
});

const rerender = ref(true)

watch(
    () => props.closeTrades,
    (newValue, oldValue) => {
        rerender.value = false;
        setTimeout(() => {
            rerender.value = true;
            setTimeout(() => {
                createTable()
            }, 1);
        }, 1);
    }
);

</script>

<style scoped>
table td {
    font-size: 0.875rem;
    line-height: 1.5;
    text-transform: capitalize;
}

.green {
    color: #2dce89;
}
</style>
