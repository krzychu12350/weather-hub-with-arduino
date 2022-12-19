import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    plugins: [
        vue({
            template: {
                compilerOptions: {
                    isCustomElement: (tag) => ['box-icon'].includes(tag),
                },
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            }
        }),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        https: false,
        host: 'localhost',
        hmr: {
            host: 'localhost'
        },
        proxy: {
            '/api': {
                target: [
                    'http://192.168.0.103:8000/',
                    'http://127.0.0.1:8000/'
                ],
                changeOrigin: true,
                secure: false,
                rewrite: (path) => path.replace(/^\/api/, '')
            },
            cors: false
        },
    },
});
