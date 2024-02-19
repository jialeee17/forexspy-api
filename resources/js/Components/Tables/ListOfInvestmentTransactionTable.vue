<template>
    <div class="py-4 container-fluid px-0">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>List of Close Trades</h5>
                        <p class="mb-0 text-sm">
                            Closed trades since the beginning of your copy trade.
                        </p>
                    </div>
                    <div class="table-responsive mt-0">
                        <table :id="`${tableId}`" class="table table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Id</th>
                                    <th>Symbol</th>
                                    <th>Time</th>
                                    <th>Type</th>
                                    <th>Open Price</th>
                                    <th>Close Price</th>
                                    <th>Profit</th>
                                    <th v-if="!showTradersPerformance">Profit Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr :key="transaction.id" v-for="(transaction, index) in signals">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ transaction.trade.symbol.name }}</td>
                                    <td>{{ transaction.trade.close_timestamp }}</td>
                                    <td :class="{ green: transaction.trade.type === 'buy' }">
                                        {{ transaction.trade.type }}
                                    </td>
                                    <td>${{ transaction.trade.open_price }}</td>
                                    <td>${{ transaction.trade.close_price }}</td>
                                    <td :class="{ green: transaction.trade.return_percent > 0 }">
                                        {{ transaction.trade.return_percent }}%
                                    </td>
                                    <td :class="{ green: transaction.amount > 0 }">
                                        {{ transaction.amount }}
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
import { reactive, onMounted, computed } from "vue";
import { DataTable } from "simple-datatables";

const props = defineProps({
    investmentTransactions: {
        type: [Object, Array],
        default: () => ({})
    },
    tableId: {
        type: String,
        default: 'table'
    },
});

// Transaction Record Table
onMounted(() => {
    // eslint-disable-next-line no-unused-vars
    const dataTableSearch = new DataTable("#" + props.tableId, {
        searchable: true,
        fixedHeight: true,
        perPage: 5,
    });
});
const signals = computed(() => {
    return props.investmentTransactions.filter((transaction) => transaction.status === 'signal')
})
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
