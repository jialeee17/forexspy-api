<template>
    <li class="mx-3 nav-item dropdown d-flex align-items-center">
        <a id="dropdownMenuButton" href="#" class="p-0 nav-link text-white toggle-button" data-bs-toggle="dropdown"
            aria-expanded="false" @click.prevent="showNotificationMenu = !showNotificationMenu; markAsRead();">
            <i class="cursor-pointer fa fa-bell"></i>
        </a>
        <ul class="px-2 py-3 dropdown-menu dropdown-menu-end me-sm-n4" :class=" showNotificationMenu ? 'show' : '' "
            aria-labelledby="dropdownMenuButton" @click.prevent=" showNotificationMenu = false ">

            <div v-if=" notifications.length < 1 ">
                <div class="text-center py-2">
                    <i class="cursor-pointer fa fa-bell"></i>
                    <h6 class="mt-2">No Notifications</h6>
                    <small class="text-muted">Check this section for updates news and general notifications.</small>
                </div>
            </div>

            <li v-for="  notification   in   notifications  " :key=" notification.id ">
                <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="py-1 d-flex">
                        <div class="my-auto">
                            <i class="avatar avatar-sm bg-gradient-secondary me-3"
                                :class=" getIcon(notification.type) "></i>
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-1 text-sm font-weight-normal">
                                <span class="fw-bold">{{ notification.subject }}</span>
                            </h6>
                            <p class="mb-0 text-xs text-secondary">
                                <i class="fa fa-clock me-1"></i>
                                {{ notification.created_at }}
                            </p>
                        </div>
                    </div>
                </a>
            </li>
        </ul>
    </li>
</template>

<script setup>
import { usePage, router } from '@inertiajs/vue3';
import { computed, ref, watch, reactive } from 'vue';

// const notifications = computed(() => usePage().props.value.notification.list)
const notifications = []

function getIcon(type) {
    if (type === 'withdrawal-requested' || type === 'withdrawal-success' || type === 'withdrawal-failed') {
        return 'fa fa-hand-holding-usd'
    } else if (type === 'verification-success' || type === 'verification-failed') {
        return 'fa fa-user-plus'
    } return 'fa fa-coins'
}

function markAsRead() {
    router.put(route('mark-notification'));
};

const showNotificationMenu = ref(false)

const hideNotificationMenu = (event) => {
    const notificationMenu = document.querySelector('.dropdown-menu');
    const button = document.querySelector('.toggle-button')

    if (!notificationMenu.contains(event.target) && !button.contains(event.target)) {
        showNotificationMenu.value = !showNotificationMenu.value;
    }
};

watch(
    () => showNotificationMenu.value,
    (showNotificationMenu, prevshowNotificationMenu) => {
        if (showNotificationMenu) {
            document.addEventListener('click', hideNotificationMenu, true);
        } else {
            document.removeEventListener('click', hideNotificationMenu, true);
        }
    }
)
</script>
