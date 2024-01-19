import { defineConfig, splitVendorChunkPlugin } from 'vite';
import laravel from 'laravel-vite-plugin';
import { ViteMinifyPlugin } from 'vite-plugin-minify'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/tracker.js'],
            refresh: true,
        }),
        ViteMinifyPlugin(),
        splitVendorChunkPlugin()
    ],
    build: {
        outDir: 'public',
        assetsDir: 'js'
    },
    esbuild: {
        minifyIdentifiers: false
    }
});
