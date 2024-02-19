<template>
    <div class="row">
        <div class="col-12 col-sm-3">
            <label>Start Date</label>
            <flat-pickr
                v-model="data.startDate"
                class="form-control datetimepicker"
                placeholder="yyyy-mm-dd"
                :config="data.config"
            />
        </div>
        <div class="col-12 col-sm-3">
            <label>End Date</label>
            <flat-pickr
                v-model="data.endDate"
                class="form-control datetimepicker"
                placeholder="yyyy-mm-dd"
                :config="data.config"
            />
        </div>
        <div
            class="col-12 col-sm-2 d-flex justify-content-end justify-content-md-start pt-2"
        >
            <argon-button
                type="button"
                color="success"
                class="mt-4"
                style="height: 40px"
                @click="onAddNewAdminButtonClicked"
                >Filter
            </argon-button>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from "vue";
import { router } from "@inertiajs/vue3";
import ArgonButton from "@/Components/ArgonButton.vue";
import flatPickr from "vue-flatpickr-component";

import "flatpickr/dist/flatpickr.css";

const date = ref(null);

// Test Data //
const data = reactive({
    startDate: "",
    endDate: "",
    config: {
        allowInput: true,
    },
});

const onAddNewAdminButtonClicked = () => {
    router.visit(route("admin.admin.create"));
};
</script>
