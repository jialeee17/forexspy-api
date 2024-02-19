<script setup>
import { onMounted, ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import ArgonInput from "@/Components/ArgonInput.vue";
import ArgonRadio from "@/Components/ArgonRadio.vue";
import ArgonCheckbox from "@/Components/ArgonCheckbox.vue";
import ArgonButton from "@/Components/ArgonButton.vue";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import background from "@/assets/img/backgrounds/background.svg";
import logo from "@/assets/img/logo.png";

const date = ref(new Date());
const format = (date) => {
    const day = date.getDate();
    const month = date.getMonth() + 1;
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
};

const props = defineProps({
    countries: Array,
});

const form = useForm({
    name: "",
    username: "",
    email: "",
    password: "",
    password_confirmation: "",
    // country: "",
    // dob: date,
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Head title="Register" />

    <main class="main-content main-content-bg mt-0">
        <img
            class="h-100 w-100 object-fill position-fixed"
            :src="background"
            alt="background"
        />
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-7">
                        <div class="text-center">
                            <img
                                class="mb-4"
                                :src="logo"
                                alt="logo"
                                width="185"
                            />
                        </div>
                        <div class="card z-index-0">
                            <div class="card-body">
                                <h5 class="card-header text-center">
                                    Sign Up Now
                                </h5>
                                <form role="form" @submit.prevent="submit">
                                    <argon-input
                                        v-model="form.name"
                                        id="name"
                                        type="text"
                                        placeholder="Name"
                                        aria-label="Name"
                                        :error="form.errors.name"
                                        :message="form.errors.name"
                                        required
                                    />

                                    <argon-input
                                        v-model="form.username"
                                        id="username"
                                        type="text"
                                        placeholder="Username"
                                        aria-label="Username"
                                        :error="form.errors.username"
                                        :message="form.errors.username"
                                        required
                                    />

                                    <argon-input
                                        v-model="form.email"
                                        id="email"
                                        type="email"
                                        placeholder="Email"
                                        aria-label="Email"
                                        :error="form.errors.email"
                                        :message="form.errors.email"
                                        required
                                    />

                                    <argon-input
                                        v-model="form.password"
                                        id="password"
                                        type="password"
                                        placeholder="Password"
                                        aria-label="Password"
                                        :error="form.errors.password"
                                        :message="form.errors.password"
                                    />

                                    <argon-input
                                        v-model="form.password_confirmation"
                                        id="passwordConfirmation"
                                        type="password"
                                        required
                                        placeholder="Password Confirmation"
                                        aria-label="Password Confirmation"
                                        :error="
                                            form.errors.password_confirmation
                                        "
                                        :message="
                                            form.errors.password_confirmation
                                        "
                                    />

                                    <!-- <argon-input
                                        v-model="form.dob"
                                        id="dateOfBirth"
                                        type="date"
                                        placeholder="Date of Birth"
                                        aria-label="Date of Birth"
                                        :error="form.errors.dob"
                                        :message="form.errors.dob"
                                        required
                                    /> -->

                                    <!-- <v-select
                                        class="mb-3"
                                        placeholder="Country"
                                        :options="$page.props.countries"
                                        :reduce="(country) => country.code"
                                        label="country"
                                        value="code"
                                        v-model="form.country"
                                    /> -->

                                    <div class="text-center">
                                        <argon-button
                                            type="submit"
                                            full-width
                                            color="success"
                                            class="mb-2"
                                            >Sign up</argon-button
                                        >
                                    </div>

                                    <p class="text-sm mt-3 mb-4 text-center">
                                        Already have an account?
                                        <Link
                                            :href="route('login')"
                                            class="text-success font-weight-bolder"
                                        >
                                            Sign in
                                        </Link>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
