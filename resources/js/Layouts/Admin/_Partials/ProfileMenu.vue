<template>
    <li
        class="nav-item dropdown d-flex align-items-center"
        v-if="$page.props.auth.user"
    >
        <a
            id="dropdownMenuButton"
            href="#"
            class="p-0 nav-link text-white"
            data-bs-toggle="dropdown"
            aria-expanded="false"
            @click="showProfileMenu = !showProfileMenu"
        >
            <div class="d-flex align-items-center">
                <div
                    class="d-flex flex-column justify-content-center text-end ms-2 d-md-block d-none"
                >
                    <h6 class="mb-0 text-sm font-weight-bold text-white">
                        {{ $page.props.auth.user.name }}
                    </h6>
                    <p class="mb-0 text-xs text-white">
                        {{ $page.props.auth.user.email }}
                    </p>
                </div>
                <div class="avatar avatar-sm ms-2">
                    <img
                        class="shadow-xs border-radius-lg"
                        :src="$page.props.auth.user.profile_photo_url"
                        :alt="$page.props.auth.user.name"
                    />
                </div>
            </div>
        </a>
        <ul
            class="px-2 py-3 dropdown-menu dropdown-menu-end me-sm-n4"
            :class="showProfileMenu ? 'show' : ''"
            aria-labelledby="dropdownMenuButton"
            @click="showProfileMenu = false"
        >
            <li class="d-md-none d-block">
                <div class="dropdown-item border-radius-md pe-none" href="">
                    <div class="py-1 d-flex">
                        <div class="my-auto avatar avatar-sm me-3">
                            <img
                                class="shadow-xs border-radius-lg"
                                :src="$page.props.auth.user.profile_photo_url"
                                :alt="$page.props.auth.user.name"
                            />
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm font-weight-bold">
                                {{ $page.props.auth.user.name }}
                            </h6>
                            <p class="mb-0 text-xs">
                                {{ $page.props.auth.user.email }}
                            </p>
                        </div>
                    </div>
                </div>
            </li>
            <li class="mb-2">
                <a
                    class="dropdown-item border-radius-md"
                    :href="route('profile.show')"
                >
                    <div class="py-1 d-flex">
                        <div
                            class="my-auto avatar avatar-sm bg-gradient-secondary me-3"
                        >
                            <i class="ni ni-single-02 text-white"></i>
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-1 text-sm font-weight-normal">
                                Profile
                            </h6>
                        </div>
                    </div>
                </a>
                <a
                    class="dropdown-item border-radius-md"
                    :href="route('user.password.edit')"
                >
                    <div class="py-1 d-flex">
                        <div
                            class="my-auto avatar avatar-sm bg-gradient-secondary me-3"
                        >
                            <i class="ni ni-lock-circle-open text-white"></i>
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-1 text-sm font-weight-normal">
                                Change Password
                            </h6>
                        </div>
                    </div>
                </a>
                <a
                    class="dropdown-item border-radius-md"
                    :href="route('user.setting.index')"
                >
                    <div class="py-1 d-flex">
                        <div
                            class="my-auto avatar avatar-sm bg-gradient-secondary me-3"
                        >
                            <i class="ni ni-settings-gear-65 text-white"></i>
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-1 text-sm font-weight-normal">
                                Settings
                            </h6>
                        </div>
                    </div>
                </a>
                <a
                    class="dropdown-item border-radius-md"
                    href="javascript:;"
                    @click="logout"
                >
                    <div class="py-1 d-flex">
                        <div
                            class="my-auto avatar avatar-sm bg-gradient-secondary me-3"
                        >
                            <i class="ni ni-button-power text-white"></i>
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-1 text-sm font-weight-normal">
                                Logout
                            </h6>
                        </div>
                    </div>
                </a>
            </li>
        </ul>
    </li>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const showProfileMenu = ref(false);

const logout = () => {
    router.post(route("logout"));
};

const hideSideNav = (event) => {
    const sideNav = document.querySelector(".dropdown-menu");
    const button = document.querySelector(".avatar img");

    if (!sideNav.contains(event.target) && !button.contains(event.target)) {
        showProfileMenu.value = !showProfileMenu.value;
        // console.log(showProfileMenu.value)
    }
};

watch(
    () => showProfileMenu.value,
    (showProfileMenu, prevShowProfileMenu) => {
        if (showProfileMenu) {
            document.addEventListener("click", hideSideNav, true);
            // console.log('add')
        } else {
            document.removeEventListener("click", hideSideNav, true);
            // console.log('remove')
        }
    }
);
</script>
