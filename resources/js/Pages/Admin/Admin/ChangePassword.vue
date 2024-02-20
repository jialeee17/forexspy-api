<template>
    <AppLayout>
        <div class="container-fluid py-7">
            <div class="col-12 col-lg-8 mx-auto mb-4">
                <div class="card p-4 border-radius-xl">
                    <h5 class="font-weight-bolder mb-0">Change Password</h5>
                    <form @submit.prevent="submit">
                        <div class="my-3">
                            <div class="row mt-3">
                                <div class="col">
                                    <label>Current Password</label>
                                    <argon-input id="currentPassword" type="password" placeholder="Current Password"
                                        v-model="form.current_password" :error="form.errors.current_password"
                                        :message="form.errors.current_password" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>New Password</label>
                                    <argon-input id="New Password" type="password" placeholder="New Password"
                                        v-model="form.password" :error="form.errors.password"
                                        :message="form.errors.password" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Confirm New Password</label>
                                    <argon-input id="confirmNewPasword" type="password"
                                        placeholder="Confirm New Password" />
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end bottom-0 w-100">
                            <argon-button type="submit" color="dark" variant="gradient" class="border w-30">
                                Update Password
                            </argon-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ArgonInput from "@/Components/ArgonInput.vue";
import ArgonButton from "@/Components/ArgonButton.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    'admin': {
        type: Object,
        default: () => ({})
    }
});

const form = useForm({
    'current_password': '',
    'password': '',
});

const submit = () => {
    form.put(route('admin.admin.update_password', props.admin.uuid), {
        onFinish: () => {
            form.reset();
        },
        onError: (error) => {
            console.error(error);
        }
    });
};

</script>