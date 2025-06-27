import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';


export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/css/components/login.css', 'resources/css/components/welcome.css'],
            refresh: true,
        }),
    ],
});
