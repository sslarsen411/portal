import { defineConfig } from 'vite'
import laravel, { refreshPaths } from 'laravel-vite-plugin'
 
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/css/stripe.css',  'resources/css/main.css', 'resources/js/app.js', 'resources/js/main.js'],
            refresh: [
                ...refreshPaths,
                'app/Livewire/**',
            ],
        }),
    ],
    resolve: {
    alias: {
        '/images': '/public/images',
    },
},
})
