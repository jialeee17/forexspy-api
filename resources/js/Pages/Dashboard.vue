<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="fw-semibold fs-5 line-height-sm">
                Dashboard
            </h2>
        </template>

        <div class="py-12 px-4">
            <div class="bg-white rounded shadow p-5">
                <Welcome />
            </div>
        </div>
    </AppLayout>
</template>
