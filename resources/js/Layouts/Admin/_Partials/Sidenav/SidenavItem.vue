<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  href: {
    type: String,
    required: true,
  },
  miniIcon: {
    type: String,
    required: true,
  },
  text: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <li class="nav-item">
    <Link class="nav-link" :href="href">
      <span class="sidenav-mini-icon"> {{ miniIcon }} </span>
      <span class="sidenav-normal"> {{ text }} </span>
    </Link>
  </li>
</template>
