<template>
    <AppLayout title="Users">
        <template #header>
            <h2 class="fw-semibold fs-5 line-height-sm">
                Create User
            </h2>
        </template>

        <div class="py-12">
            <div class="bg-white rounded p-5 shadow">
                <form @submit.prevent="submit" class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" class="form-control" placeholder="Name" aria-label="Name"
                            required v-model="form.name">
                        <div v-if="form.errors.name" class="text-danger">{{ form.errors.name }}</div>
                    </div>
                    <div class="col-md-6">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" class="form-control" placeholder="Username" aria-label="Username" required v-model="form.username">
                        <div v-if="form.errors.username" class="text-danger">{{ form.errors.username }}</div>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" class="form-control" placeholder="Email" aria-label="Email" required v-model="form.email">
                        <div v-if="form.errors.email" class="text-danger">{{ form.errors.email }}</div>
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" class="form-control" placeholder="Password" aria-label="Password" required>
                        <div v-if="form.errors.password" class="text-danger">{{ form.errors.password }}</div>
                    </div>
                    <div class="col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ capitalizeFLetter(form.status) }}
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" @click="onChange('active')">Active</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" @click="onChange('suspended')">Suspended</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { capitalizeFLetter } from '../../../helpers/UtilitiesHelper'
import { showSuccessToast, showErrorToast } from '../../../helpers/ToastHelper'


const form = useForm({
    name: '',
    username: '',
    email: '',
    password: '',
    status: 'active',
});

const onChange = (stat) => {
    form.status = stat;
}

function submit() {
    form.post(route('users.store'), {
        data: {
            name: form.name,
            username: form.username,
            email: form.email,
            password: form.password,
            status: form.status,
        },
        onSuccess: (page) => {
            showSuccessToast(page.props.flash.success);
        },
        onError: (page) => {
            showErrorToast(page.props.flash.error);
        }
    })
}
</script>

<style lang="scss" scoped>
//
</style>