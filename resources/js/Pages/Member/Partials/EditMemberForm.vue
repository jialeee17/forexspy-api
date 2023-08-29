<template>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Member</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form @submit.prevent="submit">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" v-model="form.username" placeholder="Username" required>
                            <div v-if="form.errors.username" class="text-danger">{{ form.errors.username }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="first-name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first-name" v-model="form.first_name" placeholder="Name" required>
                            <div v-if="form.errors.first_name" class="text-danger">{{ form.errors.first_name }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="last-name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last-name" v-model="form.last_name" placeholder="Name" required>
                            <div v-if="form.errors.last_name" class="text-danger">{{ form.errors.last_name }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="email-address" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email-address" v-model="form.email" placeholder="Email" required>
                            <div v-if="form.errors.email" class="text-danger">{{ form.errors.email }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="phone-number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone-number" v-model="form.phone_number" placeholder="Phone Number" required>
                            <div v-if="form.errors.phone_number" class="text-danger">{{ form.errors.phone_number }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="date-of-birth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="date-of-birth" v-model="form.date_of_birth" placeholder="Date of Birth" required>
                            <div v-if="form.errors.date_of_birth" class="text-danger">{{ form.errors.date_of_birth }}</div>
                        </div>
                        <div class="mb-3 flex flex-col">
                            <label for="gender" class="form-label">Gender</label>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    {{ capitalizeFLetter(form.gender) }}
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" @click="onGenderChange('male')">Male</a></li>
                                    <li><a class="dropdown-item" @click="onGenderChange('female')">Female</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <label for="status" class="form-label">Status</label>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    {{ capitalizeFLetter(form.status) }}
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" @click="onStatusChange('active')">Active</a></li>
                                    <li><a class="dropdown-item" @click="onStatusChange('suspended')">Suspended</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" :disabled="form.processing">Update</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</template>

<script setup>
import { ref, reactive, watch } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { capitalizeFLetter } from '../../../../helpers/utilitiesHelper'
import { showSuccessToast, showErrorToast } from '../../../../helpers/ToastHelper'

const props = defineProps({
    id: Number,
})

const emit = defineEmits(['updated'])

const form = useForm({
    username: '',
    first_name: '',
    last_name: '',
    username: '',
    email: '',
    phone_number: '',
    date_of_birth: '',
    gender: '',
    status: '',
});

// Watchers
watch(() => props.id, (newId, oldId) => {
    getMemberDetails(newId);
}, { deep: true });

// Functions
function submit(event) {
    form.put(route('members.update', { id: props.id }), {
        data: {
            username: form.username,
            first_name: form.first_name,
            last_name: form.last_name,
            email: form.email,
            phone_number: form.phone_number,
            date_of_birth: form.date_of_birth,
            gender: form.gender,
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

async function getMemberDetails(id) {
    try {
        const response = await axios.get(route('members.details', { id: id }));

        if (!response.data.status) {
            throw new Error('Something went wrong...');
        }

        form.username = response.data.data.username;
        form.first_name = response.data.data.first_name;
        form.last_name = response.data.data.last_name;
        form.email = response.data.data.email;
        form.phone_number = response.data.data.phone_number;
        form.date_of_birth = response.data.data.date_of_birth;
        form.gender = response.data.data.gender;
        form.status = response.data.data.status;
    } catch (error) {
        showErrorToast(error.message);
        console.error(error);
    }
}

const onGenderChange = (gender) => {
    form.gender = gender;
}

const onStatusChange = (stat) => {
    form.status = stat;
}
</script>

<style lang="scss" scoped>
//
</style>