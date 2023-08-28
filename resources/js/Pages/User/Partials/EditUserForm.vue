<template>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form @submit.prevent="submit">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" v-model="form.name" placeholder="Name" required>
                            <div v-if="form.errors.name" class="text-danger">{{ form.errors.name }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" v-model="form.username" placeholder="Username" required>
                            <div v-if="form.errors.username" class="text-danger">{{ form.errors.username }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" v-model="form.email" placeholder="Email" :class="{ 'is-invalid': !isValidEmail }" required>
                            <div v-if="form.errors.email" class="text-danger">{{ form.errors.email }}</div>
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
import { ref, reactive, watch, onMounted } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { showSuccessToast, showErrorToast } from '../../../../helpers/ToastHelper';

const props = defineProps({
    id: Number,
})

const emit = defineEmits(['updated'])

const page = usePage()

const form = useForm({
    name: '',
    username: '',
    email: '',
});

// const email = ref('');
const isValidEmail = ref(true);

// Watchers
watch(() => props.id, (newId, oldId) => {
    getUserDetails(newId);
}, { deep: true });

// Functions
function submit(event) {
    form.put(route('users.update', { id: props.id }), {
        data: {
            name: form.name,
            username: form.username,
            email: form.email
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

async function getUserDetails(id) {
    try {
        const response = await axios.get(route('users.details', { id: id }));

        if (!response.data.status) {
            throw new Error('Something went wrong...');
        }

        form.name = response.data.data.name;
        form.username = response.data.data.username;
        form.email = response.data.data.email;
    } catch (error) {
        showErrorToast(error.message);
        console.error(error);
    }
}
</script>

<style lang="scss">
.is-invalid {
    border-color: red;
}

.invalid-feedback {
    color: red;
}
</style>