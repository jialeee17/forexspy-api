<template>
    <AppLayout title="Account Settings">
        <div class="container-fluid py-7">
            <div class="col-12 col-lg-8 mx-auto">
                <!-- TODO: Replace the Telegram Code in the future -->
                <Connections :code="abc" />

                <DeleteAccount v-if="$page.props.jetstream.hasAccountDeletionFeatures" />
            </div>
        </div>

    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/User/AppLayout.vue";
import Connections from "@/Pages/Settings/Partials/Connections.vue";
import DeleteAccount from "@/Pages/Settings/Partials/DeleteAccount.vue";
</script>
