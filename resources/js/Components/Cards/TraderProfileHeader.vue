<template>
<div class="card p-3">
      <div class="row">
        <slot />
      </div>
    </div>
</template>

<script setup>
import { reactive } from "vue";

const props = defineProps({
  showInvestButton: {
    type: Boolean,
    required: true,
  },
});
</script>
