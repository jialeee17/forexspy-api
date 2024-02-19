import { useToast } from "vue-toastification";
import { useAttrs, onMounted, onBeforeUpdate } from "vue";

export function useFlashToast() {
    const attrs = useAttrs();
    const toast = useToast();

    const checkAttrs = () => {
        if (attrs.flash) {
            if (attrs.flash.success !== null) {
                toast.success(attrs.flash.success);
            } else if (attrs.flash.error !== null) {
                toast.error(attrs.flash.error);
            }
        }
    };

    onMounted(() => {
        checkAttrs();
    });

    onBeforeUpdate(() => {
        checkAttrs();
    });
}
