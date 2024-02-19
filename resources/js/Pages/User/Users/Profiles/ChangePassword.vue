<script setup>
import AppLayout from "@/Layouts/User/AppLayout.vue";
import ArgonInput from "@/Components/ArgonInput.vue";
import ArgonButton from "@/Components/ArgonButton.vue";
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue';
</script>

<template>
    <AppLayout title="Change Password">
    <UpdatePasswordForm></UpdatePasswordForm>

    <!-- <div class="container-fluid py-7">
            <div class="col-12 col-lg-8 mx-auto mb-4">
                <div class="card p-4 border-radius-xl bg-white">
                    <h5 class="font-weight-bolder mb-0">Change Password</h5>
                    <div class="my-3">
                        <div class="row mt-3">
                            <div class="col">
                                <label>Current Password</label>
                                <argon-input id="currentPassword" type="text" placeholder="Current Password" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label>New Password</label>
                                <argon-input id="New Password" type="text" placeholder="New Password" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label>Confirm New Password</label>
                                <argon-input id="confirmNewPasword" type="text" placeholder="Confirm New Password" />
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="position-relative mb-0">
                            <h5 class="font-weight-bolder mb-0">Password requirements</h5>
                            <p class="small">Please follow this guide for a strong password:</p>
                            <ul class="small mb-0">
                                <li>Has a length of minimum six (6) characters.</li>
                                <li>Contains at least one (1) number.</li>
                                <li>Contains at least one (1) special character.</li>
                            </ul>
                            <div class="d-flex justify-content-end position-absolute bottom-0 w-100">
                                <argon-button type="button" color="dark" variant="gradient" class="border w-30">Update
                                        Password</argon-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
    </AppLayout>
</template>
