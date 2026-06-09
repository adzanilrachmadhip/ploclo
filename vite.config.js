import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/compass_nw.css',
                'resources/css/login.css',
                'resources/css/dashboard.css',
                'resources/css/mata_kuliah.css',
                'resources/css/nilai.css',
                'resources/css/nilai_detail.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
