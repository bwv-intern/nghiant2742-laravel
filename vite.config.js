import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/css/screens', 'resources/css/screens/*.css','resources/js/app.js', 'resources/js/screens/*.js'],
            refresh: true,
        }),
    ],
});
