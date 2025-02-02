import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import { svelte } from '@sveltejs/vite-plugin-svelte'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [
    laravel({
      input: 'resources/js/app.js',
      ssr: 'resources/js/ssr.js',
      refresh: true,
    }),
    svelte({
      prebundleSvelteLibraries: true,
    }),
    tailwindcss(),
  ],
})
