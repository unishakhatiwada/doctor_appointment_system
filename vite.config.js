import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/style.scss',
                'resources/js/app.js',
                'resources/sass/style.scss'
            ],
            refresh: true,
        }),
    ],
});
