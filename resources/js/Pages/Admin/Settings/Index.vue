<template>
    <AppLayout>
        <div class="container-fluid py-4">
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Settings</h5>
                </div>
                <div class="card-body pt-0">
                    <form @submit.prevent="submit">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-12">
                                <label class="form-label">Site Name</label>
                                <argon-input id="numberOfTrades" type="text" placeholder="CoTrade"
                                    v-model="form.site_name" :error="form.errors.site_name"
                                    :message="form.errors.site_name" />
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <label class="form-label"></label>
                                <argon-switch v-model:checked="form.site_active" id="site_active" name="site_active">
                                    Site Active
                                </argon-switch>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-12">
                                <label class="form-label">Affiliate Distribution Frequency</label>
                                <argon-input id="numberOfTrades" type="number" placeholder="100"
                                    v-model="form.affiliate_distribution_frequency"
                                    :error="form.errors.affiliate_distribution_frequency"
                                    :message="form.errors.affiliate_distribution_frequency" />
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <label class="form-label">Affiliate Percentage Rate</label>
                                <argon-input id="numberOfTrades" type="number" placeholder="100"
                                    v-model="form.affiliate_distribution_percentage"
                                    :error="form.errors.affiliate_distribution_percentage"
                                    :message="form.errors.affiliate_distribution_percentage" />
                            </div>

                            <div class="col-md-3 col-sm-6 col-12">
                                <label class="form-label">Affiliate Transaction Distribution (%)</label>
                                <argon-input id="numberOfTrades" type="number" placeholder="100"
                                    v-model="form.affiliate_transaction_distribution_percentage"
                                    :error="form.errors.affiliate_transaction_distribution_percentage"
                                    :message="form.errors.affiliate_transaction_distribution_percentage" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-12">
                                <label class="form-label">Customer Over Withdrawal Amount Manual Transfer</label>
                                <argon-input id="numberOfTrades" type="number" placeholder="100"
                                    v-model="form.customer_over_withdraw_amount_manual_transfer"
                                    :error="form.errors.customer_over_withdraw_amount_manual_transfer"
                                    :message="form.errors.customer_over_withdraw_amount_manual_transfer" />
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <label class="form-label">Customer Within Withdrawal Amount Instant API Transfer</label>
                                <argon-input id="numberOfTrades" type="number" placeholder="100"
                                    v-model="form.customer_within_withdraw_amount_instant_api_transfer"
                                    :error="form.errors.customer_within_withdraw_amount_instant_api_transfer"
                                    :message="form.errors.customer_within_withdraw_amount_instant_api_transfer" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col align-self-center">
                                <div class="button-row d-flex mt-3">
                                    <argon-button type="submit" color="success" class="ms-auto"
                                        :disabled="form.processing">
                                        Submit
                                    </argon-button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
  
<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ArgonInput from "@/Components/ArgonInput.vue";
import ArgonButton from "@/Components/ArgonButton.vue";
import ArgonSwitch from "@/Components/ArgonSwitch.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    'settings': {
        type: Object,
        default: () => ({})
    }
});

const form = new useForm({
    'site_name': props.settings.site_name,
    'site_active': props.settings.site_active,
    'affiliate_distribution_frequency': props.settings.affiliate_distribution_frequency,
    'affiliate_distribution_percentage': props.settings.affiliate_distribution_percentage,
    'affiliate_transaction_distribution_percentage': props.settings.affiliate_transaction_distribution_percentage,
    'customer_over_withdraw_amount_manual_transfer': props.settings.customer_over_withdraw_amount_manual_transfer,
    'customer_within_withdraw_amount_instant_api_transfer': props.settings.customer_within_withdraw_amount_instant_api_transfer,
});

const submit = () => {
    form.put(route('admin.settings.update'), {
        onSuccess: () => {
            
        },
        onFailed: (err) => {
            console.error(err);
        }
    });
};
</script>
  