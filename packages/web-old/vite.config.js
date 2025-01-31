import { svelte } from '@sveltejs/vite-plugin-svelte'
import laravel from 'laravel-vite-plugin'
import { defineConfig } from 'vite'
import { run } from 'vite-plugin-run'
import { watch } from 'vite-plugin-watch'
import path from 'path'

export default defineConfig({
    resolve: {
        alias: {
            $lib: path.resolve('./resources/js/Components')
        }
    },
    plugins: [
        laravel({
            input: 'resources/js/app.ts',
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        run([
            {
                name: 'trail generate routes',
                pattern: 'routes/*.php',
                run: ['php', 'artisan', 'trail:generate'],
            },
            {
                name: 'clear compiled views',
                pattern: 'routes/*.php',
                run: ['php', 'artisan', 'view:clear'],
            },
        ]),
        svelte(),

        watch({
            pattern: 'routes/*.php',
            command: 'php artisan trail:generate',
        }),
    ],
})
