<template>
    <AppLayout>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row mb-3">
                        <h3 class="text-white">Dashboard</h3>
                    </div>

                    <!-- Customers -->
                    <div class="card mt-2">
                        <div class="card-header pb-0">
                            <h5 class="">Customers</h5>
                        </div>
                        <div class="card-body pt-0">
                            <DateRange />
                            <div class="row mt-4">
                                <div class="col-xl-12">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <mini-statistics-card
                                                title="Deposit"
                                                :value="
                                                    $filters.currency(53000)
                                                "
                                                :percentage="50.05"
                                                :icon="{
                                                    component:
                                                        'ni ni-money-coins',
                                                    background:
                                                        'bg-gradient-primary',
                                                    shape: 'rounded-circle',
                                                }"
                                            />
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <mini-statistics-card
                                                title="Invested"
                                                :value="$filters.currency(2300)"
                                                :percentage="50.05"
                                                :icon="{
                                                    component: 'ni ni-world',
                                                    background:
                                                        'bg-gradient-danger',
                                                    shape: 'rounded-circle',
                                                }"
                                            />
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <mini-statistics-card
                                                title="Withdraw"
                                                :value="$filters.currency(3462)"
                                                :percentage="50.05"
                                                :icon="{
                                                    component:
                                                        'ni ni-paper-diploma',
                                                    background:
                                                        'bg-gradient-success',
                                                    shape: 'rounded-circle',
                                                }"
                                            />
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <mini-statistics-card
                                                title="Register"
                                                :value="
                                                    $filters.currency(15000)
                                                "
                                                :percentage="50.05"
                                                :icon="{
                                                    component: 'ni ni-cart',
                                                    background:
                                                        'bg-gradient-warning',
                                                    shape: 'rounded-circle',
                                                }"
                                            />
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <mini-statistics-card
                                                title="Lorem"
                                                :value="
                                                    $filters.currency(150330)
                                                "
                                                :percentage="50.05"
                                                :icon="{
                                                    component: 'ni ni-cart',
                                                    background:
                                                        'bg-gradient-warning',
                                                    shape: 'rounded-circle',
                                                }"
                                            />
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <mini-statistics-card
                                                title="Lorem"
                                                :value="
                                                    $filters.currency(150330)
                                                "
                                                :percentage="50.05"
                                                :icon="{
                                                    component: 'ni ni-cart',
                                                    background:
                                                        'bg-gradient-warning',
                                                    shape: 'rounded-circle',
                                                }"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/Admin/AppLayout.vue";
import MiniStatisticsCard from "@/Components/Cards/MiniStatisticsCard.vue";
import DateRange from "@/Components/DateRange.vue";
import { Link } from "@inertiajs/vue3";
</script>
