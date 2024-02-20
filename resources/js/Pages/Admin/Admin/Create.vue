<template>
    <AppLayout title="Admin Add">
        <div class="container-fluid py-7">
            <div class="col-12 col-lg-8 mx-auto mb-4">
                <div class="card p-4 border-radius-xl">
                    <form @submit.prevent="submit">
                        <h5 class="font-weight-bolder mb-0">Add New Admin</h5>
                        <div class="row mt-3">
                            <div class="col">
                                <label>Email</label>
                                <argon-input id="email" type="email" placeholder="Email address" v-model="form.email"
                                :error="form.errors.email" :message="form.errors.email" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label>Password</label>
                                <argon-input id="password" type="password" placeholder="Password" v-model="form.password"
                                :error="form.errors.password" :message="form.errors.password" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label>Confirm Password</label>
                                <argon-input id="confirmpassword" type="password" placeholder="Confirm Password" v-model="form.password_confirmation"
                                :error="form.errors.password_confirmation" :message="form.errors.password_confirmation" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-8">
                                <label>Name</label>
                                <argon-input id="name" type="text" placeholder="Name" v-model="form.name"
                                :error="form.errors.name" :message="form.errors.name" />
                            </div>
                            <div class="col-12 col-sm-4 mb-sm-0">
                                <label>Role</label>
                                <select id="choices-roles" class="form-control" name="choices-roles" v-model="form.role">
                                    <option disabled value="">Select</option>
                                    <option :value="item.name" v-for="item in roles" :key="item.id">{{ item.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex mt-4 mt-sm-2 justify-content-end">
                            <argon-button type="submit" color="success" class="border w-30" :disabled="form.processing">
                                Submit
                            </argon-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
  
<script setup>
import ArgonInput from "@/Components/ArgonInput.vue";
import ArgonButton from "@/Components/ArgonButton.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { onMounted, ref } from "vue";
import Choices from "choices.js";
import { useForm } from "@inertiajs/vue3";

const date = ref(new Date());
const format = (date) => {
    const day = date.getDate();
    const month = date.getMonth() + 1;
    const year = date.getFullYear();
    return `${day}/${month}/${year}`;
}

const props = defineProps({
    countries: Array,
    roles: {
        type: [Array, Object],
        default: () => ({})
    }
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: '',
    terms: false,
});

const submit = () => {
    form.post(route('admin.admin.store'), {
        onFinish: () => form.reset(),
    });
};

// Role Dropdown //
onMounted(() => {
    if (document.getElementById("choices-roles")) {
        var role = document.getElementById("choices-roles");
        new Choices(role, {
            searchEnabled: false,
            allowHTML: true,
        });
    }
});
</script>
  