<template>
    <AppLayout title="Account Settings">
        <div class="container-fluid py-7">
            <div class="col-12 col-lg-8 mx-auto">
                <Connections :bot="bot" />

                <DeleteAccount
                    v-if="$page.props.jetstream.hasAccountDeletionFeatures"
                />
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Connections from "@/Pages/Profile/Partials/Connections.vue";
import DeleteAccount from "@/Pages/Profile/Partials/DeleteAccount.vue";

defineProps({
    bot: Object,
});
</script>
