import {defineConfig} from 'vite';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [vue(
        {
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }
    )],
    publicDir: false,
    build: {
        outDir: './build/',
        emptyOutDir: false,
        assetsDir: './public/themes/admin/Views/default/js/',
        manifest: true,
        rollupOptions: {
            input: {
                admin: `./admin/resources/main.js`,
            }
        }
    },
    server: {
        host: true,
        hmr: {
            host: 'cmsqlite.local'
        },
        origin: 'http://cmsqlite.local',
        port: 3000,
        strictPort: true
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, `./admin/resources`),
            vue: 'vue/dist/vue.esm-bundler.js',
        }
    },
    optimizeDeps: {
        include: ['axios', 'moment', 'sweetalert2', 'vue']
    }
});
