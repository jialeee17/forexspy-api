<template>
  <div
    class="position-absolute w-100 min-height-300 top-0"
    :style="{
      'background-image': 'url(' + image + ')',
      'background-position-y': '50%',
    }"
  >
    <span class="mask bg-success opacity-6"></span>
  </div>
  <div class="min-height-300 position-absolute w-100 bg-success" />

  <aside
    id="sidenav-main"
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 ms-4 fixed-start ms-3 bg-white"
  >
    <div class="sidenav-header">
      <i
        id="iconSidenav"
        class="top-0 p-3 cursor-pointer fas fa-times text-secondary opacity-5 position-absolute end-0 d-none d-xl-none"
        aria-hidden="true"
      ></i>
      <router-link class="m-0 navbar-brand" to="/admin">
        <img :src="logo" class="navbar-brand-img h-100" alt="main_logo" />
        <span class="ms-2 font-weight-bold">CoTrade</span>
      </router-link>
    </div>
    <hr class="mt-0 horizontal dark" />
    <sidenav-list />
  </aside>
</template>
<script>
import SidenavList from "./SidenavList.vue";
import logo from "@/assets/img/logo-ct-dark.png";
import logoWhite from "@/assets/img/logo-ct.png";
import image from "@/assets/img/profile-layout-header.jpg";

export default {
  name: "Index",
  components: {
    SidenavList,
  },
  data() {
    return {
      logo,
      logoWhite,
      image,
    };
  },
  computed: {},
  beforeUnmount() {},
};
</script>
