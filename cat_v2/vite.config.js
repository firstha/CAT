import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base:null,
                    includeAbsolute: false
                },
                compilerOptions: {
                    // Define the feature flags
                    isCustomElement: (tag) => tag.startsWith('my-'),
                  },
                  define: {
                    __VUE_PROD_DEVTOOLS__: false, // Matikan devtools di production
                    __VUE_OPTIONS_API__: true, // Jika menggunakan Options API
                    __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: false, // Sesuaikan dengan kebutuhan Anda
                },
            }
        })
    ],
});
