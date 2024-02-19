<template>
    <nav id="navbarBlur" class="navbar navbar-main navbar-expand-lg px-0 py-3 mx-sm-4 mx-2 border-radius-xl shadow-none"
        v-bind="$attrs" data-scroll="true">
        <div class="px-3 mx-0 container-fluid row">
            <div class="d-flex align-items-center col-auto px-0">
                <Breadcrumbs :current-page="title" :current-directory="currentDirectory" />
                <div class="sidenav-toggler sidenav-toggler-inner d-xl-block d-none">
                    <a href="#" class="p-0 nav-link text-body" @click.prevent="toggleSideNav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                        </div>
                    </a>
                </div>
            </div>

            <div id="navbar" class="p-0 collapse navbar-collapse col-auto">
                <ul class="navbar-nav justify-content-end ms-auto">
                    <li class="mx-2 nav-item d-xl-none d-flex align-items-center">
                        <a id="iconNavbarSidenav" href="#" class="p-0 nav-link text-white" @click.prevent="toggleSideNav">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line bg-white"></i>
                                <i class="sidenav-toggler-line bg-white"></i>
                                <i class="sidenav-toggler-line bg-white"></i>
                            </div>
                        </a>
                    </li>

                    <Notification />

                    <li class="nav-item d-flex align-items-center" v-if="!$page.props.auth.user">
                        <div class="ms-2 py-1 d-flex">
                            <a :href="route('login')">
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-1 text-sm font-weight-bold text-white">
                                            Login
                                        </h6>
                                    </div>
                                    <div class="my-auto avatar avatar-sm ms-2" style="background: #EBF4FF;">
                                        <i class="ni ni-single-02 text-primary"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </li>

                    <ProfileMenu />

                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import { Link, router } from '@inertiajs/vue3';
import Breadcrumbs from './Breadcrumbs.vue';
import ProfileMenu from './ProfileMenu.vue';
import Notification from './Notification.vue';

export default {
    components: {
        Breadcrumbs,
        Link,
        ProfileMenu,
        Notification,
    },
    props: {
        title: String,
    },
    data() {
        return {
            showMenu: false,
        };
    },
    computed: {
        currentRouteName() {
            // return this.$inertia.$page.route.current();
        },
        currentDirectory() {
            // let dir = this.Inertia.route().path.split("/")[1];
            // return dir.charAt(0).toUpperCase() + dir.slice(1);

            let dir = window.location.pathname.substring(window.location.pathname.lastIndexOf('/') + 1);
            return dir.charAt(0).toUpperCase() + dir.slice(1);
        }
    },
    methods: {
        toggleSideNav() {
            this.$emit('toggleSideNav');
            const showSideNav = JSON.parse(localStorage.getItem('showSideNav'))
            if (window.innerWidth >= 1200) {
                if (showSideNav === null) {
                    return localStorage.setItem('showSideNav', false)
                } else localStorage.setItem('showSideNav', !showSideNav);
            }
        }
    }
};
</script>

<style>
.text-success {
    color: #2DCE89 !important;
}
</style>
