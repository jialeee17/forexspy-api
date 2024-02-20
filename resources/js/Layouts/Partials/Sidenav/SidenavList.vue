<script setup>
import SidenavItem from "./SidenavItem.vue";
import SidenavCollapse from "./SidenavCollapse.vue";
import { watch, ref, computed, onMounted } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    showExpandedNav: {
        type: Boolean,
        required: true,
    },
});

// Side Navigation Menu
const customerMenu = [
    {
        ref: route("dashboard"),
        text: "Dashboard",
        route: "dashboard",
        icon: "ni ni-atom",
        collapse: false,
        navItems: [],
    },
];

const adminMenu = [
    {
        ref: route("admin.dashboard"),
        text: "Dashboard",
        route: "admin.dashboard",
        icon: "ni ni-atom",
        collapse: false,
        navItems: [],
    },
];

const menu = computed(() => {
    return route().current('admin.*') ? adminMenu : customerMenu;
});

const iconColor = computed(() => {
    return route().current('admin.*') ? "text-primary" : "text-success";
});

const showSubcategories = ref(props.showExpandedNav);

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
    <div id="sidenav-collapse-main" class="collapse navbar-collapse w-auto h-auto h-100">
        <ul class="navbar-nav">
            <li class="nav-item">
                <sidenav-collapse v-for="item in menu" :key="item" :collapse="item.collapse" :collapse-ref="item.ref"
                    :nav-text="item.text" :class="route().current(item.route) ? 'active' : ''">
                    <template #icon>
                        <i class="text-sm opacity-10" :class="[item.icon, iconColor]"></i>
                    </template>

                    <template #list>
                        <ul class="nav ms-4">
                            <sidenav-item v-for="navItem in item.navItems" :key="navItem" :href="route(navItem.route)"
                                mini-icon="L" :text="navItem.text" />
                        </ul>
                    </template>
                </sidenav-collapse>
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
