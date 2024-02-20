<script setup>
import { ref } from "vue";
import { Head, router } from "@inertiajs/vue3";
import TopNav from "@/Layouts/Partials/TopNav.vue";
import SideNav from "@/Layouts/Partials/SideNav.vue";
import { reactive, watch } from "vue";

defineProps({
    title: String,
});

const checkWidth = () => {
    if (window.innerWidth < 1200) {
        return false;
    } else {
        const storedValue = localStorage.getItem("showSideNav");
        return storedValue === null ? true : JSON.parse(storedValue);
    }
};

const layout = reactive({
    showSideNav: checkWidth(),
});

const hideSideNav = (event) => {
    const sideNav = document.querySelector(".sidenav");
    const button = document.querySelector("#iconNavbarSidenav");

    if (!sideNav.contains(event.target) && !button.contains(event.target)) {
        layout.showSideNav = !layout.showSideNav;
    }
};

watch(
    () => layout.showSideNav,
    (showSideNav, prevshowSideNav) => {
        if (window.innerWidth < 1201) {
            if (showSideNav) {
                document.addEventListener("click", hideSideNav, true);
            } else {
                document.removeEventListener("click", hideSideNav, true);
            }
        }
    }
);
</script>

<template>
    <Head :title="title"></Head>

    <div id="app" class="g-sidenav-show" :class="layout.showSideNav ? 'g-sidenav-pinned' : 'g-sidenav-hidden'">
        <SideNav :showSideNav="layout.showSideNav" />

        <main class="main-content position-relative max-height-vh-100 h-100">
            <TopNav @toggleSideNav="layout.showSideNav = !layout.showSideNav" :title="title" />
            <slot class="content" />
        </main>
    </div>
</template>

<style>
div.swal2-container {
    z-index: 10000;
}

.welcome-guide-background {
    filter: blur(30px);
    overflow: hidden;
}
</style>
