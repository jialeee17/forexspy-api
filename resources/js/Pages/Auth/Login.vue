<script setup>
import { onMounted } from "vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import ArgonInput from "@/Components/ArgonInput.vue";
import ArgonSwitch from "@/Components/ArgonSwitch.vue";
import ArgonButton from "@/Components/ArgonButton.vue";
import background from "@/assets/img/backgrounds/background.svg";
import logo from "@/assets/img/logo.png";

const props = defineProps({
    canResetPassword: Boolean,
    status: String,
    isAdminLogin: Boolean,
});

const form = useForm({
    username: "",
    password: "",
    remember: false,
    is_admin_login: false,
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        remember: form.remember ? "on" : "",
    })).post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};

const onSignUpButtonClicked = () => {
    router.visit(route("register"));
};

const onForgotPasswordClicked = () => {
    router.visit(route("password.request"));
};

onMounted(() => {
    if (props.isAdminLogin) {
        form.is_admin_login = props.isAdminLogin;
    }
});
</script>

<template>
    <Head title="Log in" />

    <main class="main-content main-content-bg mt-0">
        <img
            class="h-100 w-100 object-fill position-fixed"
            :src="background"
            alt="background"
        />
        <div class="page-header min-vh-100" style="">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-4 col-md-7">
                        <img class="mb-4" :src="logo" alt="logo" width="185" />
                        <div class="card border-0 mb-0">
                            <div class="card-header bg-transparent">
                                <h5 class="text-dark text-center mt-2 mb-3">
                                    Sign in
                                </h5>
                            </div>
                            <div class="card-body px-lg-5 pt-0">
                                <form
                                    role="form"
                                    class="text-start"
                                    @submit.prevent="submit"
                                >
                                    <input
                                        type="hidden"
                                        v-model="form.is_admin_login"
                                    />

                                    <div class="mb-3">
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
                                    </div>

                                    <div class="mb-3">
                                        <argon-input
                                            v-model="form.password"
                                            id="password"
                                            type="password"
                                            placeholder="Password"
                                            aria-label="Password"
                                            :error="form.errors.password"
                                            :message="form.errors.password"
                                            required
                                        />
                                    </div>

                                    <argon-switch
                                        v-model:checked="form.remember"
                                        id="rememberMe"
                                        name="rememberMe"
                                    >
                                        Remember me
                                    </argon-switch>

                                    <div class="text-center">
                                        <argon-button
                                            type="submit"
                                            color="success"
                                            full-width
                                            class="my-4 mb-2"
                                            :class="{
                                                'opacity-25': form.processing,
                                            }"
                                            :disabled="form.processing"
                                        >
                                            Sign in
                                        </argon-button>
                                    </div>

                                    <template v-if="!isAdminLogin">
                                        <div
                                            class="mb-2 position-relative text-center"
                                        >
                                            <p
                                                class="text-sm font-weight-bold mb-2 text-secondary text-border d-inline z-index-2 bg-white px-3"
                                            >
                                                or
                                            </p>
                                        </div>

                                        <div class="text-center">
                                            <argon-button
                                                type="button"
                                                color="dark"
                                                variant="gradient"
                                                full-width
                                                class="mt-2 mb-4"
                                                @click="onSignUpButtonClicked"
                                                >Sign up</argon-button
                                            >
                                        </div>
                                    </template>

                                    <div class="mb-2 position-relative">
                                        <p
                                            role="button"
                                            class="text-sm mb-2 text-danger"
                                            @click="onForgotPasswordClicked"
                                        >
                                            Forgot Password?
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
