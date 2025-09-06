import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { resolve } from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/css/admin.css',
                'resources/js/admin.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            '@': resolve(__dirname, 'resources'),
            '@js': resolve(__dirname, 'resources/js'),
            '@css': resolve(__dirname, 'resources/css'),
            '@image': resolve(__dirname, 'resources/image'),
        },
    },
    build: {
        // Enable minification
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true, // Remove console.log in production
                drop_debugger: true,
                pure_funcs: ['console.log', 'console.info', 'console.debug'],
                passes: 2,
            },
            mangle: {
                safari10: true,
            },
            format: {
                comments: false,
            },
        },
        // Enable CSS code splitting
        cssCodeSplit: true,
        // CSS minification
        cssMinify: 'lightningcss',
        // Chunk size warnings
        chunkSizeWarningLimit: 1000,
        // Enable source maps for production debugging (optional)
        sourcemap: false,
        // Target modern browsers for better optimization
        target: ['es2020', 'chrome80', 'firefox78', 'safari14'],
        // Enable tree shaking
        treeshake: {
            moduleSideEffects: false,
            propertyReadSideEffects: false,
            tryCatchDeoptimization: false,
        },
        rollupOptions: {
            output: {
                // Manual chunks for better caching
                manualChunks(id) {
                    // Vendor chunks
                    if (id.includes('node_modules')) {
                        // Separate large libraries
                        if (id.includes('bootstrap')) {
                            return 'bootstrap';
                        }
                        if (id.includes('jquery')) {
                            return 'jquery';
                        }
                        if (id.includes('fontawesome')) {
                            return 'fontawesome';
                        }
                        // Other vendor libraries
                        return 'vendor';
                    }
                    // Admin-specific chunks
                    if (id.includes('resources/js/admin')) {
                        return 'admin';
                    }
                },
                // Asset file naming
                assetFileNames: (assetInfo) => {
                    const info = assetInfo.name.split('.');
                    const ext = info[info.length - 1];
                    if (/png|jpe?g|svg|gif|tiff|bmp|ico/i.test(ext)) {
                        return `image/[name]-[hash][extname]`;
                    }
                    if (/css/i.test(ext)) {
                        return `css/[name]-[hash][extname]`;
                    }
                    return `assets/[name]-[hash][extname]`;
                },
                chunkFileNames: 'js/[name]-[hash].js',
                entryFileNames: 'js/[name]-[hash].js',
            },
        },
    },
    // Development server configuration
    server: {
        compress: true,
        cors: true,
        hmr: {
            overlay: true,
        },
        // Enable HTTP/2 for better performance
        https: false,
    },
    // Preview server configuration (for production builds)
    preview: {
        compress: true,
        cors: true,
    },
    // Optimization settings
    optimizeDeps: {
        include: [
            'bootstrap',
            'jquery',
        ],
        exclude: [
            // Exclude large dependencies that should be loaded separately
        ],
    },
    // Enable experimental features
    experimental: {
        renderBuiltUrl(filename, { hostType }) {
            if (hostType === 'js') {
                return { js: `/${filename}` };
            } else {
                return { relative: true };
            }
        },
    },
    // CSS preprocessing options
    css: {
        devSourcemap: true,
        preprocessorOptions: {
            scss: {
                additionalData: `@import "@css/variables.scss";`,
            },
        },
    },
});
