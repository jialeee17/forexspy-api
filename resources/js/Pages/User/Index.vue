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

        <EditUserForm :id="userId" @updated="refreshTable" />
    </AppLayout>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import EditUserForm from './Partials/EditUserForm.vue'
import { showSuccessToast, showErrorToast } from '../../../helpers/ToastHelper'
import { capitalizeFLetter } from '../../../helpers/utilitiesHelper'

const userId = ref(null)
const table = ref(null)

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
            showErrorToast(errorThrown);
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
            title: 'Status',
            field: 'status',
            formatter: statusFormatter
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
            <a href="javascript:void(0)" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editModal" style="font-size: 22px; "><i class="bi bi-pencil-square"></i></a>
            <a href="javascript:void(0)" class="btn-link" style="font-size: 22px; color: #2AABEE;"><i class="bi bi-telegram"></i></a>
            <a href="javascript:void(0)" class="btn-delete" style="font-size: 22px; color: red;"><i class="bi bi-trash3-fill"></i></a>
        </div>
    `;

    return buttons;
}

function actionEvents() {
    return {
        'click .btn-edit': async (event, value, row, index) => {
            userId.value = row.id;
        },
        'click .btn-link': (event, value, row, index) => {
            console.log('Link Telegram Account');
            return;
        },
        'click .btn-delete': (event, value, row, index) => {
            deleteUser(row.id);
            return;
        },
    }
}

function statusFormatter(value, row, index, field) {
    return capitalizeFLetter(value);
}

function refreshTable() {
    table.value.bootstrapTable('refresh', { silent: true });
}

function deleteUser(id) {
    router.delete(route('users.destroy', { id: id }), {
        preserveScroll: true,
        onSuccess: (page) => {
            showSuccessToast(page.props.flash.success);
            table.value.bootstrapTable('refresh');
        },
        onError: (page) => {
            showErrorToast(page.props.flash.error);
        }
    })
}

onMounted(() => {
    table.value = $('#table').bootstrapTable({
        ajax: ajaxRequest,
        columns: columns(),
        pagination: true,
        sidePagination: 'server',
        paginationVAlign: 'bottom',
        pageSize: 25,
        pageList: "[25, 50, 75, 100]",
        queryParams: queryParams,
    })
})
</script>

<style lang="scss">
    //
</style>
