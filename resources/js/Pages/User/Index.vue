<template>
    <AppLayout title="Users">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-5">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                    <table id="table"></table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form @submit="onSubmit">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="validationCustom03" class="form-label">Name</label>
                                <input type="text" class="form-control" id="validationCustom03" v-model="formData.name"
                                    :placeholder="formData.name" required>
                                <div class="invalid-feedback">
                                    Please provide a valid Name.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" v-model="formData.username"
                                    :placeholder="formData.username" required>
                                <div class="invalid-feedback">
                                    Please choose a Username.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" v-model="formData.email"
                                    :placeholder="formData.email" :class="{ 'is-invalid': !isValidEmail }" required>
                                <p v-if="!isValidEmail" class="invalid-feedback">Please enter a valid email address.</p>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Apply</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <div id="liveAlertPlaceholder"></div>
        <button type="button" class="btn btn-primary" id="liveAlertBtn">Show live alert</button>
    </AppLayout>
</template>

<script setup>
import { ref, onMounted, reactive, } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios';

defineProps({

})

const email = ref('');
const isValidEmail = ref(true);

const validateEmail = () => {
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    isValidEmail.value = emailPattern.test(formData.email);
    return emailPattern.test(formData.email);
};

const formData = reactive({
    username: '',
    name: '',
    email: '',
});

function onSubmit(e) {
    console.log(formData);
    if (validateEmail()) {
        axios.get(route('users.details', { id: 2 })).then((res) => {
            console.log(res.data.data)
        }).catch((error) => {
            console.log(error.message)
        })
    }
    else {
        e.preventDefault();
        return;
    }

}


function ajaxRequest(params) {
    $.ajax({
        url: route('users.list'),
        method: "GET",
        data: params.data,
        success: function (response) {
            params.success(response.data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Handle error
            console.error("Error: " + errorThrown);
        },
        complete: function (jqXHR, textStatus) {
            // Handle completion of the request (regardless of success or error)
            // console.log("Request completed with status: " + textStatus);
        }
    });
}

function columns() {
    return [
        {
            title: 'ID',
            formatter: idFormatter,
            sortable: true,
        },
        {
            title: 'Name',
            field: 'name',
            sortable: true,
        },
        {
            title: 'Username',
            field: 'username',
            sortable: true,
        },
        {
            title: 'Email',
            field: 'email',
        },
        {
            title: 'Action',
            formatter: actionFormatter,
            events: actionEvents()
        },
    ]
}

function queryParams(params) {
    return {
        ...params,
    }
}

function idFormatter(value, row, index, field) {
    return index + 1;
}

function actionFormatter(value, row, index, field) {
    const buttons = `
        <div class="flex justify-evenly">
            <a href="javascript:void(0)" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editModal" @click="openModal" style="font-size: 22px; "><i class="bi bi-pencil-square"></i></a>
            <a href="javascript:void(0)" class="btn-link" style="font-size: 22px; color: #2AABEE;"><i class="bi bi-telegram"></i></a>
            <a href="javascript:void(0)" class="btn-delete" style="font-size: 22px; color: red;"><i class="bi bi-trash3-fill"></i></a>
        </div>
    `;

    return buttons;
}

function actionEvents() {
    return {
        'click .btn-edit': (event, value, row, index) => {
            console.log()
            axios.get(route('users.details', { id: row.id })).then((res) => {
                console.log(res.data.data)
                formData.name = res.data.data.name;
                formData.username = res.data.data.username;
                formData.email = res.data.data.email;
            }).catch((error) => {
                console.log(error.message)
            })
            return;
        },
        'click .btn-link': (event, value, row, index) => {
            console.log('Link Telegram Account');
            return;
        },
        'click .btn-delete': (event, value, row, index) => {
            console.log('Delete User');
            return;
        },
    }
}


onMounted(() => {
    $('#table').bootstrapTable({
        ajax: ajaxRequest,
        columns: columns(),
        pagination: true,
        sidePagination: 'server',
        paginationVAlign: 'bottom',
        pageSize: 25,
        pageList: "[25, 50, 75, 100]",
        queryParams: queryParams,

    })
    const alertPlaceholder = document.getElementById('liveAlertPlaceholder')
    const appendAlert = (message, type) => {
        const wrapper = document.createElement('div')
        wrapper.innerHTML = [
            `<div class="alert alert-${type} alert-dismissible" role="alert">`,
            `   <div>${message}</div>`,
            '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
            '</div>'
        ].join('')

        alertPlaceholder.append(wrapper)
    }

    const alertTrigger = document.getElementById('liveAlertBtn')
    if (alertTrigger) {
        alertTrigger.addEventListener('click', () => {
            appendAlert('Nice, you triggered this alert message!', 'success')
        })
    }
})
</script>

<style>
.is-invalid {
    border-color: red;
}

.invalid-feedback {
    color: red;
}
</style>
