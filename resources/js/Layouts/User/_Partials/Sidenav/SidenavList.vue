<script setup>
import SidenavItem from "./SidenavItem.vue";
import SidenavCollapse from "./SidenavCollapse.vue";
import { watch, ref } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    showExpandedNav: {
        type: Boolean,
        required: true,
    },
});

const showSubcategories = ref(props.showExpandedNav);

const checkSideNav = () => {
    const showSideNav = JSON.parse(localStorage.getItem("showSideNav"));
    if (showSideNav === false) {
        showSubcategories.value = false;
    }
};

watch(
    () => props.showExpandedNav,
    (showExpandedNav, prevShowExpandedNav) => {
        if (window.innerWidth < 1200) {
            showSubcategories.value = true;
        } else showSubcategories.value = props.showExpandedNav;
    }
);
</script>

<template>
    <div
        id="sidenav-collapse-main"
        class="collapse navbar-collapse w-auto h-auto h-100"
    >
        <ul class="navbar-nav">
            <li class="nav-item">
                <Link :href="route('dashboard')">
                    <sidenav-collapse
                        :collapse="false"
                        collapse-ref=""
                        nav-text="Dashboard"
                        :class="route().current('dashboard') ? 'active' : ''"
                    >
                        <template #icon>
                            <i
                                class="ni ni-atom text-success text-sm opacity-10"
                            ></i>
                        </template>
                    </sidenav-collapse>
                </Link>
            </li>
        </ul>
    </div>
</template>

<style scoped>
.fa {
    font-size: 16px !important;
    margin-top: -5px;
}
</style>
