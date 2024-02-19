<template>
    <AppLayout title="Admin List">
        <div class="py-4 container-fluid">
            <div class="mt-4 row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Admin List</h5>
                        </div>
                        <div class="d-flex mx-4 justify-content-end">
                            <argon-button type="button" color="success" @click="onAddNewAdminButtonClicked">
                                Add New Admin
                            </argon-button>
                        </div>
                        <div class="table-responsive">
                            <table id="datatable-search" class="table table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr :key="admin.uuid" v-for="admin in admins.data">
                                        <td>{{ admin.id }}</td>
                                        <td class="text-lowercase">{{ admin.name }}</td>
                                        <td class="text-lowercase">{{ admin.email }}</td>
                                        <td class="text-lowercase">{{ admin.role }}</td>
                                        <td class="text-center">
                                            <Link :href="route('admin.admin.password', admin.uuid)" class="icon icon-shape">
                                                <i class="fas fa-lock"></i>
                                            </Link>
                                            <Link :href="route('admin.admin.edit', admin.uuid)" class="icon icon-shape mx-3">
                                                <i class="fas fa-edit"></i>
                                            </Link>
                                            <a class="icon icon-shape sweetalerts" :data-id="admin.uuid">
                                                <i class="fas fa-trash" :data-id="admin.uuid"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { onMounted } from "vue";
import { DataTable } from "simple-datatables";
import { Link, router } from "@inertiajs/vue3";
import swal from "sweetalert2";
import ArgonButton from "@/Components/ArgonButton.vue";
import AppLayout from "@/Layouts/Admin/AppLayout.vue";
import { useToast } from "vue-toastification";
import { useAttrs } from "vue";

defineProps({
    admins: {
        type: [Array, Object],
        default: () => ({})
    }
});

const onAddNewAdminButtonClicked = () => {
    router.visit(route('admin.admin.create'));
};

// Admin List Table //
onMounted(() => {
    // eslint-disable-next-line no-unused-vars
    const datatable = new DataTable("#datatable-search", {
        searchable: true,
        fixedHeight: true,
        perPage: 5,
    });

    datatable.on("datatable.init", function () {
        var sweetalerts = document.querySelectorAll(".sweetalerts");
        sweetalerts.forEach(function (sweetalert) {
            sweetalert.addEventListener("click", function (event) {
                onDeleteButtonClicked(event.target.getAttribute("data-id"));
            });
        });
    });
});

const onDeleteButtonClicked = (value) => {
    {
        new swal({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: "Cancel",
            confirmButtonText: "Yes, delete it!",
            customClass: {
                confirmButton: "btn bg-gradient-success",
                cancelButton: "btn bg-gradient-danger",
            },
            buttonsStyling: false,
        }).then((result) => {
            if (result.isConfirmed) {
                router.delete(route('admin.admin.destroy', value), {
                    onSuccess: () => {
                        new swal({
                            title: "Deleted!",
                            text: "Admin has been deleted.",
                            icon: "success",
                            customClass: {
                                confirmButton: "btn bg-gradient-success",
                            },
                            buttonsStyling: false,
                        });
                        setTimeout(() => {
                            location.reload() 
                        }, 500);
                    },
                    onError: (err) => {
                        console.error(err);
                    }
                });
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === swal.DismissReason.cancel
            ) {
                swal.dismiss;
            }
        });
    }
};

const attrs = useAttrs()
const toast = useToast();

onMounted(() => {
    if (attrs.flash.success !== null) {
        toast.success(attrs.flash.success)
    }
})

</script>

<style scoped>
table td {
    font-size: 0.875rem;
    line-height: 1.5;
    text-transform: capitalize;
}

.icon {
    background-color: #f8f9fa;
    border-radius: 50%;
}

.icon>i {
    color: #8392ab;
    font-size: 0.875rem;
    line-height: 1.5;
    opacity: 1;
}

.icon:hover>i {
    color: #5e72e4;
}
</style>
