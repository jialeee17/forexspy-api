<template>
    <AppLayout>
        <div class="container-fluid py-7">
            <div class="col-12 col-lg-8 mx-auto mb-4">
                <div class="card p-4 border-radius-xl bg-white">
                    <h5 class="font-weight-bolder mb-0">Edit Profile</h5>
                    <div class="row mt-3">
                        <div class="col">
                            <label>Name</label>
                            <argon-input id="name" type="text" placeholder="eg. Michael" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Country</label>
                            <argon-input id="company" type="text" placeholder="eg. England" />
                        </div>
                        <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                            <label>Email</label>
                            <argon-input id="email" type="email" placeholder="eg. argon@dashboard.com" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Date of Birth</label>
                            <argon-input id="dateOfBirth" type="date" />
                        </div>
                        <div class="col-12 col-sm-6 mt-sm-0">
                            <label>Referral Code (If any)</label>
                            <argon-input id="referralCode" type="text" placeholder="eg. A4564G" />
                        </div>
                    </div>
                    <div class="d-flex mt-2 justify-content-end">
                        <argon-button type="button" color="success" class="border w-30">Submit</argon-button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/User/AppLayout.vue";
import ArgonInput from "@/Components/ArgonInput.vue";
import ArgonButton from "@/Components/ArgonButton.vue";
</script>
