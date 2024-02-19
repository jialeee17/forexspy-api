<template>
  <div class="card shadow slide-up-on-hover">
    <div class="py-5 text-center card-body">
      <h6 class="text-sm text-uppercase font-weight-bolder opacity-6">
        {{ props.title }}
      </h6>
      <h3 class="lh-1 m-0 text-uppercase font-weight-bolder">
        {{ props.value }}
      </h3>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  title: {
    type: String,
  },
  value: {
    type: [String, Number],
    default: "",
  },
});
</script>

<style scoped>
.green h3 {
  color: #2dce89;
}
</style>