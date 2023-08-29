<template>
    <AppLayout title="Users">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create User
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-5 flex justify-end items-end">
                <div class="bg-white rounded-[24px] max-w-7xl mx-auto flex justify-center items-center p-5 shadow-md">
                    <div class="w-[700px]">
                        <form @submit.prevent="submit">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-5">
                                        <label for="exampleInputPassword1" class="form-label">Username</label>
                                        <input type="text" class="form-control" placeholder="Username" aria-label="Username"
                                            required v-model="form.username">
                                        <div v-if="form.errors.username" class="text-danger">{{ form.errors.username }}
                                        </div>
                                    </div>
                                    <div class="mb-5">
                                        <label for="exampleInputPassword1" class="form-label">Email</label>
                                        <input type="email" class="form-control" placeholder="Email" aria-label="Email"
                                            required v-model="form.email">
                                        <div v-if="form.errors.username" class="text-danger">{{ form.errors.email }}</div>
                                    </div>
                                    <div class="mb-5">
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
                                                    <a class="dropdown-item" @click="onChange('inactive')">Inactive</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-5">
                                        <label for="exampleInputPassword1" class="form-label">Name</label>
                                        <input type="text" class="form-control" placeholder="Name" aria-label="Name"
                                            required v-model="form.name">
                                        <div v-if="form.errors.username" class="text-danger">{{ form.errors.name }}</div>
                                    </div>
                                    <div class="mb-5">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" class="form-control" placeholder="Password"
                                            aria-label="Password" required>
                                        <div v-if="form.errors.username" class="text-danger">{{ form.errors.password }}
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="w-full flex justify-end">
                                <button class="btn btn-primary" type="submit">
                                    Create
                                </button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3';
import { capitalizeFLetter } from '../../../helpers/UtilitiesHelper';


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
            emit('updated')
            showSuccessToast(page.props.flash.success);
        },
        onError: (page) => {
            showErrorToast(page.props.flash.error);
        }
    })
}


</script>

<style scoped></style>