import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks: undefined,
            },
            external: (id) => {
                // Excluir archivos Vue para evitar errores de compilación
                return id.includes('.vue');
            }
        },
        commonjsOptions: {
            include: [/node_modules/],
        },
    },
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
});
