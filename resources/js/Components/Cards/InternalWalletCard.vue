<template>
  <div class="card bg-gradient-dark mb-4">
    <div class="card-body" style="min-height: 230px; min-width: 320px">
      <h4 class="text-white mb-3" v-if="!props.isDeposit">Current Balance</h4>
      <div class="">
        <sup class="text-white text-lg align-middle">$</sup>
        <span class="h2 text-white">3,300</span>
      </div>
      <div class="text-white opacity-8 mt-3 text-sm">Your current balance</div>
      <div class="mb-4">
        <span class="font-weight-600" style="color: #48bb78">+ 15% </span>
        <span class="text-white opacity-8">($250)</span>
      </div>
      <button
        class="btn btn-sm btn-white mt-3 w-100"
        v-if="props.canDeposit"
        @click="onDepositButtonClicked"
      >
        Deposit
      </button>
    </div>
  </div>
</template>

<script setup>
// import { useRouter } from "vue-router";

const props = defineProps({
  canDeposit: {
    type: Boolean,
  },
});

// Routes
// const router = useRouter();

// function onDepositButtonClicked() {
//   router.push("depositwallet");
// }
</script>
