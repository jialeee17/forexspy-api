<template>
    <div id="delete" class="card my-4 slide-up-on-hover">
        <div class="card-header">
            <h5>Delete Account</h5>
            <p class="text-sm mb-0">
                Once you delete your account, there is no going back. Please be
                certain.
            </p>
        </div>
        <div class="card-body d-sm-flex pt-0">
            <argon-button
                @click="toggleUserStatus()"
                :color="
                    $page.props.auth.user.status === 'active'
                        ? 'secondary'
                        : 'primary'
                "
                variant="outline"
                class="mb-0 ms-auto"
                type="button"
                name="button"
            >
                <span v-if="$page.props.auth.user.status === 'active'"
                    >Deactivate</span
                >
                <span v-else>Activate</span>
            </argon-button>
            <argon-button
                color="danger"
                variant="gradient"
                class="mb-0 ms-2"
                type="button"
                name="button"
                data-toggle="modal"
                data-target="#deleteAccountModal"
            >
                Delete Account
            </argon-button>
        </div>
    </div>

    <div
        class="modal fade"
        id="deleteAccountModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="deleteAccountModal"
        aria-hidden="true"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content py-2 px-3">
                <h5 class="modal-title pt-3 px-3">Account Deletion</h5>
                <div class="modal-body" style="color: black !important">
                    <div class="mt-2">
                        <p>Are you absolutely sure?</p>
                        <p>
                            Are you sure you want to delete your account? Once
                            your account is deleted, all of its resources and
                            data will be permanently deleted. Please enter your
                            password to confirm you would like to permanently
                            delete your account.
                        </p>
                    </div>
                    <p>Please type your password below to confirm.</p>

                    <div class="input-group mb-3 border">
                        <input
                            v-model="form.password"
                            type="password"
                            class="form-control ps-2"
                            placeholder="Password"
                            aria-label="password"
                            aria-describedby="basic-addon1"
                            required
                        />
                    </div>
                    <p class="text-danger small fw-bold">
                        Final warning: This action is permanent and cannot be
                        reversed.
                    </p>
                </div>

                <div class="d-flex justify-content-end">
                    <button
                        type="button"
                        class="btn btn-danger mx-1"
                        @click="deleteUser"
                        data-dismiss="modal"
                    >
                        Delete Account
                    </button>
                    <button
                        type="button"
                        class="btn btn-secondary mx-1"
                        data-dismiss="modal"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import ArgonButton from "@/Components/ArgonButton.vue";
import { ref } from "@vue/reactivity";
import { usePage, useForm, router } from "@inertiajs/vue3";
import swal from "sweetalert2";

const page = usePage();
const passwordInput = ref(null);

const form = useForm({
    password: "",
});

const deleteUser = () => {
    form.delete(route("current-user.destroy"), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

function toggleUserStatus() {
    router.put(
        route("user.toggleStatus", { id: page.props.auth.user.uuid }),
        {},
        {
            onSuccess: (page) => {
                new swal({
                    title: "Deleted!",
                    text: page.props.flash.success ?? "",
                    icon: "success",
                    customClass: {
                        confirmButton: "btn bg-gradient-success",
                    },
                    buttonsStyling: false,
                });
            },
            onError: (error) => {
                console.error(error);
            },
        }
    );
}
</script>
