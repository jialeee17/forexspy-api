<script setup>
import { ref } from "vue";
import { Head, router } from "@inertiajs/vue3";
import TopNav from "@/Layouts/Admin/_Partials/TopNav.vue";
import SideNav from "@/Layouts/Admin/_Partials/SideNav.vue";
import { reactive, onMounted, onUnmounted, computed, watch } from "vue";

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(
        route("current-team.update"),
        {
            team_id: team.id,
        },
        {
            preserveState: false,
        }
    );
};

const logout = () => {
    router.post(route("logout"));
};

const checkWidth = () => {
    if (window.innerWidth < 1200) {
        return false;
    } else return JSON.parse(localStorage.getItem("showSideNav")) || false;
};

const layout = reactive({
    showSideNav: checkWidth(),
});

const hideSideNav = (event) => {
    const sideNav = document.querySelector(".sidenav");
    const button = document.querySelector("#iconNavbarSidenav");

    if (!sideNav.contains(event.target) && !button.contains(event.target)) {
        layout.showSideNav = !layout.showSideNav;
        // console.log(layout.showSideNav)
    }
};

watch(
    () => layout.showSideNav,
    (showSideNav, prevshowSideNav) => {
        if (window.innerWidth < 1201) {
            if (showSideNav) {
                document.addEventListener("click", hideSideNav, true);
                // console.log('add')
            } else {
                document.removeEventListener("click", hideSideNav, true);
                // console.log('remove')
            }
        }
    }
);
</script>

<template>
    <Head :title="title"></Head>

    <div
        id="app"
        class="g-sidenav-show"
        :class="layout.showSideNav ? 'g-sidenav-pinned' : 'g-sidenav-hidden'"
    >
        <SideNav :showSideNav="layout.showSideNav" />
        <main class="main-content position-relative max-height-vh-100 h-100">
            <TopNav
                @toggleSideNav="layout.showSideNav = !layout.showSideNav"
                :title="title"
            />
            <slot />
        </main>
    </div>
</template>

<style>
div.swal2-container {
    z-index: 10000;
}
</style>
