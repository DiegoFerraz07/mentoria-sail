import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/utils/sweet-alert.js',
                'resources/js/utils/cnpj-verify.js'
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@sweetAlert': 'resources/js/utils/sweet-alert.js'
        }
    }
});
