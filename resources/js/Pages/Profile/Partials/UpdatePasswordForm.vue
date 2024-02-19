<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ArgonInput from "@/Components/ArgonInput.vue";
import ArgonButton from "@/Components/ArgonButton.vue";
import ActionMessage from '@/Components/Jetstream/ActionMessage.vue';
import FormSection from '@/Components/Jetstream/FormSection.vue';
import InputError from '@/Components/Jetstream/InputError.vue';
import InputLabel from '@/Components/Jetstream/InputLabel.vue';
import PrimaryButton from '@/Components/Jetstream/PrimaryButton.vue';
import TextInput from '@/Components/Jetstream/TextInput.vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('user-password.update'), {
        errorBag: 'updatePassword',
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }

            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <form @submit.prevent="updatePassword">
        <div class="container-fluid py-7">
            <div class="col-12 col-lg-8 mx-auto mb-4">
                <div class="card p-4 border-radius-xl bg-white slide-up-on-hover">
                    <h5 class="font-weight-bolder mb-0">Change Password</h5>
                    <div class="my-3">
                        <div class="row mt-3">
                            <div class="col">
                                <label>Current Password</label>
                                <argon-input ref="currentPasswordInput" v-model="form.current_password" id="currentPassword"
                                    type="text" placeholder="Current Password" :error="form.errors.current_password"
                                    :message="form.errors.current_password" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label>New Password</label>
                                <argon-input ref="passwordInput" v-model="form.password" id="New Password" type="text"
                                    placeholder="New Password" :error="form.errors.password"
                                    :message="form.errors.password" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label>Confirm New Password</label>
                                <argon-input v-model="form.password_confirmation" id="confirmNewPasword" type="text"
                                    placeholder="Confirm New Password" :error="form.errors.password_confirmation"
                                    :message="form.errors.password_confirmation" />
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="position-relative mb-0">
                            <h5 class="font-weight-bolder mb-0">Password requirements</h5>
                            <p class="small">Please follow this guide for a strong password:</p>
                            <ul class="small mb-0">
                                <li>Has a length of minimum six (8) characters.</li>
                                <li>Contains at least one (1) number.</li>
                                <li>Contains at least one (1) special character.</li>
                            </ul>
                            <div class="d-flex justify-content-end position-absolute bottom-0 w-100">
                                <argon-button type="submit" color="dark" variant="gradient" class="border w-30"
                                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Update
                                    Password</argon-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form></template>
