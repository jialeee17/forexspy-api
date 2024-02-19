import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/js/app.js",
                "resources/scss/app.scss"
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    ssr: {
        noExternal: ["@inertiajs/server"],
    },
    server: {
        https: process.env.APP_ENV === "production",
        host: "0.0.0.0",
        hmr: {
            host: "localhost",
        },
    },
});
