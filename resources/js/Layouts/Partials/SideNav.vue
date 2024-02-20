<template>
  <div class="position-absolute w-100 min-height-300 top-0" :style="{
    'background-image': 'url(' + image + ')',
    'background-position-y': '50%',
  }">
    <span class="mask bg-success opacity-6"></span>
  </div>
  <div class="min-height-300 position-absolute w-100 bg-success" />

  <aside id="sidenav-main" v-on:mouseover="showExpandedNav = true" v-on:mouseout="checkSideNav"
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 ms-4 fixed-start bg-white">
    <div class="sidenav-header">
      <i id="iconSidenav"
        class="top-0 p-3 cursor-pointer fas fa-times text-secondary opacity-5 position-absolute end-0 d-none d-xl-none"
        aria-hidden="true"></i>
      <Link :href="(route().current('admin.*')) ? route('admin.dashboard') : route('dashboard')"
        class="m-0 navbar-brand text-center">
      <img :src="logo" v-show="showExpandedNav" class="navbar-brand-img h-100" alt="main_logo" />
      <img :src="favicon" v-show="!showExpandedNav" class="navbar-brand-img h-100 rounded" alt="main_logo" />
      </Link>
    </div>
    <hr class="my-0 horizontal dark" />
    <SideNavList :showExpandedNav="showExpandedNav" />
  </aside>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import SideNavList from "./Sidenav/SidenavList.vue";
import logo from "@/assets/img/logo.png";
import favicon from "@/assets/img/logos/favicon.ico";
import image from "@/assets/img/profile-layout-header.jpg";
import { watch, ref } from "vue";

const props = defineProps({
  showSideNav: {
    type: Boolean,
    required: true,
  },
});

const showExpandedNav = ref(props.showSideNav);

const checkSideNav = () => {
  const showSideNav = JSON.parse(localStorage.getItem("showSideNav"));
  if (showSideNav === false) {
    showExpandedNav.value = false;
  }
};

watch(
  () => props.showSideNav,
  (showSideNav, prevshowSideNav) => {
    if (window.innerWidth < 1200) {
      showExpandedNav.value = true;
    } else showExpandedNav.value = props.showSideNav;
  }
);
</script>
