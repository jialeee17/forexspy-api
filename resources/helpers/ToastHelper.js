import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

export function showSuccessToast(message, options = {}) {
    toast.success(message, {
        position: toast.POSITION.BOTTOM_RIGHT,
        ...options
    });
}

export function showErrorToast(message, options = {}) {
    toast.error(message, {
        position: toast.POSITION.BOTTOM_RIGHT,
        ...options
    });
}