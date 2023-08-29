<template>
    <AppLayout title="Members">
        <template #header>
            <h2 class="fw-semibold fs-5 line-height-sm">
                Members
            </h2>
        </template>

        <div class="py-12 px-4">
            <div class="bg-white rounded shadow p-5">
                <div class="d-flex justify-content-end mb-3">
                    <Link class="btn btn-primary" :href="route('members.create')" method="get" as="button">Create</Link>
                </div>
                <table id="table"></table>
            </div>
        </div>

        <EditMemberForm :id="memberId" @updated="refreshTable" />
    </AppLayout>
</template>

<script setup>
import { ref, onMounted, reactive, } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import EditMemberForm from '@/Pages/Member/Partials/EditMemberForm.vue'
import { capitalizeFLetter } from '../../../helpers/UtilitiesHelper'
import { showSuccessToast, showErrorToast } from '../../../helpers/ToastHelper'

const memberId = ref(null)
const table = ref(null)

function ajaxRequest(params) {
    $.ajax({
        url: route('members.list'),
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
        },
        {
            title: 'Username',
            field: 'username',
            sortable: true,
        },
        {
            title: 'First Name',
            field: 'first_name',
            sortable: true,
        },
        {
            title: 'Last Name',
            field: 'last_name',
            sortable: true,
        },
        {
            title: 'Email',
            field: 'email',
            sortable: true,
        },
        {
            title: 'Phone Number',
            field: 'phone_number',
        },
        {
            title: 'Date of Birth',
            field: 'date_of_birth',
            sortable: true,
        },
        {
            title: 'Gender',
            field: 'gender',
            align: 'center',
            sortable: true,
            formatter: genderFormatter,
        },
        {
            title: 'Status',
            field: 'status',
            align: 'center',
            sortable: true,
            formatter: statusFormatter,
        },
        {
            title: 'Action',
            align: 'center',
            formatter: actionFormatter,
            events: actionEvents(),
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
        <div class="d-flex justify-content-evenly align-items-center">
            <a href="javascript:void(0)" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editModal" style="font-size: 20px;" data-toggle="tooltip" title="Edit Member"><i class="bi bi-pencil-square"></i></a>
            <a href="javascript:void(0)" class="btn-delete" style="font-size: 20px; color: red;" data-toggle="tooltip" title="Delete Member"><i class="bi bi-trash3-fill"></i></a>
        </div>
    `;

    return buttons;
}

function actionEvents() {
    return {
        'click .btn-edit': async (event, value, row, index) => {
            memberId.value = row.id;
        },
        'click .btn-delete': (event, value, row, index) => {
            deleteMember(row.id);
        },
    }
}

function genderFormatter(value, row, index, field) {
    return capitalizeFLetter(value);
}

function statusFormatter(value, row, index, field) {
    const className = row.status === 'active' ? 'text-green-500' : 'text-red-500';
    return `<div class="fw-bold ${className}">${capitalizeFLetter(value)}</div>`
}

function deleteMember(id) {
    router.delete(route('members.destroy', { id: id }), {
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

function rowStyle(row, index) {
    return {
        css: {
            'background-color': index % 2 === 0 ? '#f2f2f2' : '#fff'
        }
    }
}

function refreshTable() {
    table.value.bootstrapTable('refresh', { silent: true });
}

onMounted(() => {
    table.value = $('#table').bootstrapTable({
        ajax: ajaxRequest,
        columns: columns(),
        rowStyle: rowStyle,
        pagination: true,
        sidePagination: 'server',
        paginationVAlign: 'bottom',
        pageSize: 25,
        pageList: "[10, 25, 50, 100]",
        queryParams: queryParams,

    })
})
</script>

<style lang="scss" scoped>
//
</style>