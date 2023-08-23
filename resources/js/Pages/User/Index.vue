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
    </AppLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({

})

function ajaxRequest(params) {
    $.ajax({
        url: route('users.list'),
        method: "GET",
        data: params.data,
        success: function(response) {
            params.success(response.data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Handle error
            console.error("Error: " + errorThrown);
        },
        complete: function(jqXHR, textStatus) {
            // Handle completion of the request (regardless of success or error)
            // console.log("Request completed with status: " + textStatus);
        }
    });
}

function columns() {
    return [
        {
            title: 'ID',
            formatter: idFormatter
        },
        {
            title: 'Name',
            field: 'name',
        },
        {
            title: 'Username',
            field: 'username',
        },
        {
            title: 'Email',
            field: 'email',
        },
        {
            title: 'Status',
            field: 'status',
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
        <a href="javascript:void(0)" class="btn-edit">Edit</a>
        <a href="javascript:void(0)" class="btn-link">Link</a>
    `;

    return buttons;
}

function actionEvents() {
    return {
        'click .btn-edit' :(event, value, row, index) => {
            console.log('Edit');
            return;
        },
        'click .btn-link' :(event, value, row, index) => {
            console.log('Link');
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
        paginationVAlign: 'both',
        pageSize: 25,
        pageList:"[25, 50, 75, 100]",
        queryParams: queryParams
    })
})
</script>