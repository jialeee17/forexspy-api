<script setup>
import { ref, onMounted } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import ArgonInput from "@/Components/ArgonInput.vue";
import ArgonButton from "@/Components/ArgonButton.vue";

import ActionMessage from "@/Components/Jetstream/ActionMessage.vue";
import FormSection from "@/Components/Jetstream/FormSection.vue";
import InputError from "@/Components/Jetstream/InputError.vue";
import InputLabel from "@/Components/Jetstream/InputLabel.vue";
import PrimaryButton from "@/Components/Jetstream/PrimaryButton.vue";
import SecondaryButton from "@/Components/Jetstream/SecondaryButton.vue";
import TextInput from "@/Components/Jetstream/TextInput.vue";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

const date = ref(new Date());
const format = (date) => {
    const day = date.getDate();
    const month = date.getMonth() + 1;
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
};

const props = defineProps({
    user: Object,
});

const form = useForm({
    _method: "PUT",
    name: props.user.name,
    email: props.user.email,
    photo: null,
});

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);

const updateProfileInformation = () => {
    if (photoInput.value) {
        form.photo = photoInput.value.files[0];
    }

    form.post(route("user-profile-information.update"), {
        errorBag: "updateProfileInformation",
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
    });
};

const sendEmailVerification = () => {
    verificationLinkSent.value = true;
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (!photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);
};

const deletePhoto = () => {
    router.delete(route("current-user-photo.destroy"), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null;
            clearPhotoFileInput();
        },
    });
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};
</script>

<template>
    <form @submit.prevent="updateProfileInformation">
        <div class="container-fluid py-7">
            <div class="col-12 col-lg-8 mx-auto mb-4">
                <div
                    class="card p-4 border-radius-xl bg-white slide-up-on-hover"
                >
                    <h5 class="font-weight-bolder mb-0">Edit Profile</h5>
                    <div class="row mt-3">
                        <div class="col-12 col-sm-6">
                            <label>Name</label>
                            <argon-input
                                v-model="form.name"
                                id="name"
                                type="text"
                                placeholder="eg. James Smith"
                                :error="form.errors.name"
                                :message="form.errors.name"
                            />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Email</label>
                            <argon-input
                                v-model="form.email"
                                id="email"
                                type="email"
                                placeholder="eg. example@email.com"
                                :error="form.errors.email"
                                :message="form.errors.email"
                            />
                        </div>
                    </div>

                    <!-- <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Country</label>
                            <v-select
                                :options="$page.props.countries"
                                :reduce="(country) => country.code"
                                label="country"
                                value="code"
                                v-model="form.country"
                            />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Date of Birth</label>
                            <argon-input
                                v-model="form.dob"
                                id="dateOfBirth"
                                type="date"
                                :error="form.errors.dob"
                                :message="form.errors.dob"
                            />
                        </div>
                    </div> -->

                    <div class="d-flex mt-2 justify-content-end">
                        <argon-button
                            type="submit"
                            color="success"
                            class="border w-30"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            >Submit</argon-button
                        >
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>
