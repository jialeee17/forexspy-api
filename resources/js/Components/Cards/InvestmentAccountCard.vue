<template>
  <div
    :key="account.id"
    v-for="account in accounts"
    class="card me-3 mb-3"
    :class="isChangeBgColor(account.id)"
    style="width: 300px; height: 253px"
  >
    <div class="card-body p-4 m-1">
      <div class="row">
        <div class="col-6">
          <p class="card-heading">IVA-23332</p>
        </div>
        <div class="col-6">
          <p class="card-heading text-end">+55%</p>
        </div>
      </div>
      <div class="row">
        <p class="text-white">Trader's A</p>
      </div>
      <div class="mb-2 row">
        <div class="col-6">
          <p class="card-heading mb-0">$100</p>
          <p class="card-paragraph">Initial Deposit</p>
        </div>
        <div class="col-6">
          <p class="card-heading mb-0">$100</p>
          <p class="card-paragraph">Current Balance</p>
        </div>
      </div>
      <div class="row d-flex justify-content-between">
        <div class="col-7 p-0">
          <button
            class="btn btn-sm btn-white m-0 w-95 p-2 border border-white"
            v-if="props.canTopUp"
          >
            Top Up Account
          </button>
        </div>
        <div class="col-5 d-flex justify-content-end p-0">
          <button
            class="btn btn-sm bg-transparent border text-white mb-0 w-95 p-2"
          >
            Close Account
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive } from "vue";

const props = defineProps({
  canTopUp: {
    type: Boolean,
  },
});

const accounts = reactive([
  { id: 1, name: "test1" },
  { id: 2, name: "test1" },
  { id: 3, name: "test1" },
  { id: 4, name: "test1" },
  { id: 5, name: "test1" },
  { id: 6, name: "test1" },
]);

function isChangeBgColor(id) {
  let color =
    id % 6 === 0
      ? "bg-gradient-success"
      : id % 5 === 0
      ? "bg-gradient-info"
      : id % 4 === 0
      ? "bg-gradient-warning"
      : id % 3 === 0
      ? "bg-gradient-danger"
      : id % 2 === 0
      ? "bg-gradient-secondary"
      : "bg-gradient-primary";
  return color;
}
</script>

<style scoped>
.card-heading {
  font-size: 1.25rem;
  font-weight: 700;
  color: white;
}
.card-paragraph {
  font-size: 0.625rem;
  font-weight: 700;
  color: white;
}
</style>
