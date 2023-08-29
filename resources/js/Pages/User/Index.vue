<template>
    <AppLayout title="Users">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>

        <div class="py-12">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                <div class="pb-3 w-full flex justify-end">
                    <Link class="btn btn-primary" :href="route('users.create')" method="get" as="button">Create</Link>
                </div>
                <table id="table"></table>
            </div>
        </div>

        <EditUserForm :id="userId" @updated="refreshTable" />
    </AppLayout>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import EditUserForm from '@/Pages/User/Partials/EditUserForm.vue'
import { showSuccessToast, showErrorToast } from '../../../helpers/ToastHelper'
import { capitalizeFLetter } from '../../../helpers/UtilitiesHelper'

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
            width: "20",
            formatter: idFormatter
        },
        {
            title: 'Name',
            field: 'name',
            sortable: true,
            width: "270"
        },
        {
            title: 'Username',
            field: 'username',
            sortable: true,
        },
        {
            title: 'Email',
            field: 'email',
            width: "270"
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

function statusFormatter(value, row, index, field) {
    const className = row.status === 'active' ? 'text-green-500' : 'text-red-500';
    return `<div class="${className}">${capitalizeFLetter(value)}</div>`;
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

<style lang="scss" scoped>
//
</style>
