<template>
  <Link :data-bs-toggle="collapse ? 'collapse' : ''" :href="collapse ? `#${collapseRef}` : collapseRef"
    :aria-controls="collapseRef" :aria-expanded="isExpanded" class="nav-link" v-bind="$attrs"
    @click="isExpanded = !isExpanded">
    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
      <slot name="icon"></slot>
    </div>
    <span class="nav-link-text ms-2 py-1">{{ navText }}</span>
  </Link>
  <div :class="isExpanded ? 'collapse show' : 'collapse'">
    <slot name="list"></slot>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Link } from "@inertiajs/vue3";

const props = defineProps({
  collapseRef: {
    type: String,
    required: true
  },
  navText: {
    type: String,
    required: true
  },
  collapse: {
    type: Boolean,
    default: true
  },
});

const checkRoute = () => {
  if ((route().current('user.*') || route().current('profile.show')) && props.collapseRef === 'users') {
    return true;
  } else if (route().current('affiliate') && props.collapseRef === 'affiliate') {
    return true;
  } else return false;
}

const isExpanded = ref(checkRoute());

</script>