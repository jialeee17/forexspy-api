<template>
    <AppLayout title="Members">
        <template #header>
            <h2 class="fw-semibold fs-5 line-height-sm">
                Create Member
            </h2>
        </template>

        <div class="py-12">
            <div class="bg-white rounded p-5 shadow">
                <form @submit.prevent="submit" class="row g-3">
                    <div class="col-md-6">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" class="form-control" placeholder="Username" aria-label="Username" v-model="form.username" required>
                        <div v-if="form.errors.username" class="text-danger">{{ form.errors.username }}</div>
                    </div>
                    <div class="col-md-6">
                        <label for="first-name" class="form-label">First Name</label>
                        <input type="text" id="first-name" class="form-control" placeholder="First Name" aria-label="First Name" v-model="form.first_name" required>
                        <div v-if="form.errors.first_name" class="text-danger">{{ form.errors.first_name }}</div>
                    </div>
                    <div class="col-md-6">
                        <label for="last-name" class="form-label">Last Name</label>
                        <input type="text" id="last-name" class="form-control" placeholder="Last Name" aria-label="Last Name" v-model="form.last_name" required>
                        <div v-if="form.errors.last_name" class="text-danger">{{ form.errors.last_name }}</div>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" class="form-control" placeholder="Email Address" aria-label="Email" v-model="form.email" required>
                        <div v-if="form.errors.email" class="text-danger">{{ form.errors.email }}</div>
                    </div>
                    <div class="col-md-6">
                        <label for="phone-number" class="form-label">Phone Number</label>
                        <input type="text" id="phone-number" class="form-control" placeholder="Phone Number" aria-label="Phone Number" v-model="form.phone_number" required>
                        <div v-if="form.errors.phone_number" class="text-danger">{{ form.errors.phone_number }}</div>
                    </div>
                    <div class="col-md-6">
                        <label for="date-of-birth" class="form-label">Date of Birth</label>
                        <input type="date" id="date-of-birth" class="form-control" placeholder="Date of Birth" aria-label="Date of Birth" v-model="form.date_of_birth" required>
                        <div v-if="form.errors.date_of_birth" class="text-danger">{{ form.errors.date_of_birth }}</div>
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" class="form-control" placeholder="Password" aria-label="Password" v-model="form.password" required>
                        <div v-if="form.errors.password" class="text-danger">{{ form.errors.password }}</div>
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-md-2">
                        <label for="gender" class="form-label">Gender</label>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ capitalizeFLetter(form.gender) }}
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" @click="onGenderChange('male')">Male</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" @click="onGenderChange('female')">Female</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="status" class="form-label">Status</label>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ capitalizeFLetter(form.status) }}
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" @click="onStatusChange('active')">Active</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" @click="onStatusChange('suspended')">Suspended</a>
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
    username: '',
    first_name: '',
    last_name: '',
    email: '',
    phone_number: '',
    date_of_birth: '',
    password: '',
    gender: 'male',
    status: 'active',
});

const onGenderChange = (gender) => {
    form.gender = gender;
}

const onStatusChange = (stat) => {
    form.status = stat;
}

function submit() {
    form.post(route('members.store'), {
        data: {
            username: form.username,
            first_name: form.first_name,
            last_name: form.last_name,
            email: form.email,
            phone_number: form.phone_number,
            date_of_birth: form.date_of_birth,
            password: form.password,
            gender: form.gender,
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