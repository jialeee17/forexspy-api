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
                            <label for="name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="name" v-model="form.first_name" placeholder="Name"
                                required>
                            <div v-if="form.errors.name" class="text-danger">{{ form.errors.first_name }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="name" v-model="form.last_name" placeholder="Name"
                                required>
                            <div v-if="form.errors.name" class="text-danger">{{ form.errors.last_name }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" v-model="form.username"
                                placeholder="Username" required>
                            <div v-if="form.errors.username" class="text-danger">{{ form.errors.username }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Gender</label>
                            <input type="text" class="form-control" id="name" v-model="form.gender" placeholder="Name"
                                required>
                            <div v-if="form.errors.name" class="text-danger">{{ form.errors.gender }}</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" v-model="form.email" placeholder="Email"
                                :class="{ 'is-invalid': !isValidEmail }" required>
                            <div v-if="form.errors.email" class="text-danger">{{ form.errors.email }}</div>
                            <!-- <p v-if="!isValidEmail" class="invalid-feedback">Please enter a valid email address.</p> -->
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

const props = defineProps({
    id: Number,
})

const form = useForm({
    first_name: '',
    last_name: '',
    username: '',
    gender: '',
    email: '',
});

// const email = ref('');
const isValidEmail = ref(true);

// Watchers
watch(() => props.id, (newId, oldId) => {
    getUserDetails(newId);
}, { deep: true });

// Functions
// const validateEmail = () => {
//     const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
//     isValidEmail.value = emailPattern.test(form.email);
//     return emailPattern.test(form.email);
// };

function submit(event) {
    form.put(route('users.update', { id: 2 }), {
        data: {
            name: form.name,
            username: form.username,
            email: form.email
        },
        onSuccess: () => {
            console.log('onSuccess');
        }
    })
    // if (isValidEmail) {
    //     axios.get(route('users.details', { id: 2 })).then((res) => {
    //         console.log(res.data.data)
    //     }).catch((error) => {
    //         console.log(error.message)
    //     })
    // }
    // else {
    //     e.preventDefault();
    //     return;
    // }
}

async function getUserDetails(id) {
    //TODO change logic for updating edit form.
    try {
        const response = await axios.get(route('members.details', { id: id }));

        if (!response.data.status) {
            throw new Error('Something went wrong...');
        }

        form.first_name = response.data.data.first_name;
        form.last_name = response.data.data.last_name;
        form.username = response.data.data.username;
        form.email = response.data.data.email;
        form.gender = response.data.data.gender;
    } catch (error) {
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