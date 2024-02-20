<template>
  <li class="nav-item dropdown d-flex align-items-center" v-if="$page.props.auth.user">
    <a id="dropdownMenuButton" href="#" class="p-0 nav-link text-white" data-bs-toggle="dropdown" aria-expanded="false"
      @click="showProfileMenu = !showProfileMenu">
      <div class="d-flex align-items-center">
        <div class="avatar avatar-sm ms-2">
          <img class="shadow-xs border-radius-lg" :src="$page.props.auth.user.profile_photo_url"
            :alt="$page.props.auth.user.name" />
        </div>
      </div>
    </a>
    <ul class="px-2 py-3 dropdown-menu dropdown-menu-end me-sm-n4" :class="showProfileMenu ? 'show' : ''"
      aria-labelledby="dropdownMenuButton" @click="showProfileMenu = false">
      <li>
        <div class="dropdown-item border-radius-md pe-none" href="">
          <div class="py-1 d-flex">
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
        <template v-for="item in menu" key="menu">
          <Link :href="item.href" class="dropdown-item border-radius-md">
          <div class="py-1 d-flex">
            <div class="my-auto avatar avatar-sm bg-gradient-secondary me-3">
              <i class="text-white" :class="item.icon"></i>
            </div>
            <div class="d-flex flex-column justify-content-center">
              <h6 class="mb-1 text-sm font-weight-normal">
                {{ item.text }}
              </h6>
            </div>
          </div>
          </Link>
        </template>

        <Link class="dropdown-item border-radius-md" as="button" @click="logout">
        <div class="py-1 d-flex">
          <div class="my-auto avatar avatar-sm bg-gradient-secondary me-3">
            <i class="ni ni-button-power text-white"></i>
          </div>
          <div class="d-flex flex-column justify-content-center">
            <h6 class="mb-1 text-sm font-weight-normal">Logout</h6>
          </div>
        </div>
        </Link>
      </li>
    </ul>
  </li>
</template>

<script setup>
import { router, Link } from "@inertiajs/vue3";
import { ref, computed, watch } from "vue";

const showProfileMenu = ref(false);

// Profile Menu
const customerMenu = [
  {
    text: "Profile",
    href: route("profile.show"),
    icon: "ni ni-single-02",
  },
  {
    text: "Change Password",
    href: route("user.password.edit"),
    icon: "ni ni-lock-circle-open",
  },
  {
    text: "Settings",
    href: route("user.setting.show"),
    icon: "ni ni-settings-gear-65",
  },
];

const adminMenu = [
  {
    text: "Profile",
    href: route("admin.profile.show"),
    icon: "ni ni-single-02",
  },
  {
    text: "Change Password",
    href: route("admin.password.edit"),
    icon: "ni ni-lock-circle-open",
  },
  {
    text: "Settings",
    href: route("admin.setting.show"),
    icon: "ni ni-settings-gear-65",
  },
];

const menu = computed(() => {
  return route().current("admin.*") ? adminMenu : customerMenu;
});

const logout = () => {
  router.post(route("logout"));
};

const hideSideNav = (event) => {
  const sideNav = document.querySelector(".dropdown-menu");
  const button = document.querySelector(".avatar img");

  if (!sideNav.contains(event.target) && !button.contains(event.target)) {
    showProfileMenu.value = !showProfileMenu.value;
  }
};

watch(
  () => showProfileMenu.value,
  (showProfileMenu, prevShowProfileMenu) => {
    if (showProfileMenu) {
      document.addEventListener("click", hideSideNav, true);
    } else {
      document.removeEventListener("click", hideSideNav, true);
    }
  }
);
</script>
