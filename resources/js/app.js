import "./bootstrap";
import "../css/app.css";
import "../css/nucleo-icons.css";
import "../css/nucleo-svg.css";
import "../../node_modules/vue-select/dist/vue-select.css";
import "../../node_modules/vue-toastification/dist/index.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import vSelect from "vue-select";
import VueTilt from "vue-tilt.js";
import VueSweetalert2 from "vue-sweetalert2";
import ArgonDashboard from "./argon-dashboard";
import Toast, { POSITION } from "vue-toastification";
import VueClipboard from "vue3-clipboard";
import VueSocialSharing from "vue-social-sharing";
import * as filters from "./filters";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(VueTilt)
            .use(VueSweetalert2)
            .use(Toast, {
                position: POSITION.BOTTOM_RIGHT,
                timeout: 2000,
                closeOnClick: true,
                pauseOnFocusLoss: true,
                pauseOnHover: true,
                draggable: true,
                draggablePercent: 0.6,
                showCloseButtonOnHover: true,
                hideProgressBar: true,
                closeButton: "button",
                icon: true,
                rtl: false,
                transition: "Vue-Toastification__bounce",
                maxToasts: 20,
                newestOnTop: true,
            })
            .use(VueClipboard, {
                autoSetContainer: true,
                appendToBody: true,
            })
            .use(ArgonDashboard)
            .use(VueSocialSharing)
            .component("v-select", vSelect);

        app.config.globalProperties.$filters = {
            ...filters,
        };

        app.mount(el);
    },
    progress: {
        color: "#4B5563",
        showSpinner: true,
    },
});
