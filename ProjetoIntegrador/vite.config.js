import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import tailwindcss from 'tailwindcss';  // Import ESM do Tailwind
import autoprefixer from 'autoprefixer';  // Import ESM do Autoprefixer

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue(),
    ],

    css: {
        postcss: {
            plugins: [tailwindcss, autoprefixer],  // Usando import ESM
        },
    },
    
    server: {
        host: 'localhost',
        port: 3000,
    },
});

