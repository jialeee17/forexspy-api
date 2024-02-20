<template>
    <AppLayout>
        <div class="container-fluid py-7">
            <div class="col-12 col-lg-8 mx-auto mb-4">
                <div class="card p-4 border-radius-xl bg-white">
                    <form method="post" @submit.prevent="submit">
                        <h5 class="font-weight-bolder mb-0">Edit Admin</h5>
                        <div class="row mt-3">
                            <div class="col">
                                <label>Email</label>
                                <argon-input id="email" type="email" placeholder="Email address" v-model="form.email"
                                    :error="form.errors.email" :message="form.errors.email" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-8">
                                <label>Name</label>
                                <argon-input id="name" type="text" placeholder="Name" v-model="form.name"
                                    :error="form.errors.name" :message="form.errors.name" />
                            </div>
                            <div class="col-12 col-sm-4 mt-sm-0">
                                <label>Role</label>
                                <select id="choices-roles" class="form-control" name="choices-roles" v-model="form.role">
                                    <option :value="item.name" v-for="item in roles" :key="item.id">{{item.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex mt-2 justify-content-end">
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
import AppLayout from '@/Layouts/AppLayout.vue';
import ArgonInput from "@/Components/ArgonInput.vue";
import ArgonButton from "@/Components/ArgonButton.vue";
import { onMounted } from "vue";
import Choices from "choices.js";
import { useForm } from "@inertiajs/vue3";;

const props = defineProps({
    admin: {
        type: Object,
        default: () => ({})
    },
    roles: {
        type: [Array, Object],
        default: () => ({})
    }
});

const form = new useForm({
    'name': props.admin.name,
    'email': props.admin.email,
    'role': props.admin.roles[0].name
});

const submit = () => {
    form.put(route('admin.admin.update', props.admin.uuid), {
        onFinish: () => {
            form.reset();
        },
        onError: (error) => {
            console.error(error);
        }
    });
}

// Roles Dropdown //
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
  