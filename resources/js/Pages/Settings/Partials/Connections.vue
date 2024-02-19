<template>
    <div id="connections" class="card my-4 slide-up-on-hover">
        <div class="card-header">
            <h5>Connections</h5>
            <p class="text-sm mb-0">
                Connect to receive live trade updates.
            </p>
        </div>
        <div class="card-body d-sm-flex pt-0">
            <div class="d-flex align-items-center mb-sm-0 mb-4">
                <i class="fa fa-telegram h3 my-auto" aria-hidden="true" style="color: #0088cc;"></i>
                <div class="ms-3">
                    <span class="text-dark font-weight-bold d-block text-sm">Telegram
                    </span>
                    <span class="text-xs d-block">Get the latest updates via Telegram.</span>
                </div>
            </div>
            <argon-button color="primary" variant="gradient" class="mb-0 ms-auto" type="button" name="button"
                data-toggle="modal" data-target="#telegramConnectModal" v-if="!$page.props.auth.user.is_telegram_connected">
                Connect
            </argon-button>
            <argon-button color="secondary" variant="gradient" class="mb-0 ms-auto" type="button" name="button"
                data-toggle="modal" v-if="$page.props.auth.user.is_telegram_connected">
                Connected
            </argon-button>
        </div>
    </div>

    <div class="modal fade" id="telegramConnectModal" tabindex="-1" role="dialog" aria-labelledby="telegramConnectModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content py-2 px-3">
                <h5 class="modal-title pt-3 px-3">Connect your Telegram</h5>
                <div class="modal-body" style="color: black !important;">

                    <div class="text-center my-3">
                        <img src="@/assets/img/qrcode/cotrade_qrcode.png" alt="qrcode" class="border rounded" width="200">
                    </div>

                    <div class="text-center my-3">
                        <a class="nav-link" href="https://t.me/cotrade_bot">https://t.me/cotrade_bot</a>
                    </div>

                    <div class="mt-2">
                        <p>1. Scan <strong>QR code</strong> or click the <strong>Link</strong> to connect your telegram
                            account.</p>
                        <p>2. Press <strong>Start</strong> and <strong>Copy</strong> below 8-digi code.</p>

                        <div role="button" class="border rounded mb-3 d-flex justify-content-center">
                            <p @click="copyClipboard()" class="text-center my-1 font-weight-bold">
                                <span ref="code">{{ code }}</span>
                                <CopyIcon class="ms-2" />
                            </p>
                        </div>

                        <p>3. Press <strong>Send</strong></p>
                    </div>

                    <!-- <div class="input-group mb-3 border"></div> -->
                    <!-- <p class="text-danger small fw-bold">Final warning: This action is permanent and cannot be reversed.</p> -->
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import ArgonButton from "@/Components/ArgonButton.vue";
import CopyIcon from "@/Components/Icons/Copy.vue";
import { copyText } from 'vue3-clipboard';
import { useToast } from "vue-toastification";

const toast = useToast();

const props = defineProps({
    code: String
});

const copyClipboard = async () => {
    // only work at https
    try {
        await navigator.clipboard.writeText(props.code);
    } catch (e) {
        console.log(e);
    }

    // bug: not working at modal
    // copyText(props.code, undefined, () => {
    //     console.log(props.code);
    //     toast.success("Copied")
    // });
}
</script>