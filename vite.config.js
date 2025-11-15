import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // App files (auth, profile, dll)
                "resources/css/app.css",
                "resources/js/app.js",

                // Welcome page
                "resources/css/welcome.css",
                "resources/js/welcome.js",

                // Dashboard Admin files
                "resources/js/dashboard-admin.js",
                "resources/css/dashboard-admin-layout.css",
                "resources/css/dashboard-admin-components.css",
                "resources/css/dashboard-admin-responsive.css",
            ],
            refresh: true,
        }),
    ],
    build: {
        manifest: true,
        outDir: "public/build",
        emptyOutDir: true,
        rollupOptions: {
            output: {
                manualChunks: undefined,
                entryFileNames: "assets/[name]-[hash].js",
                chunkFileNames: "assets/[name]-[hash].js",
                assetFileNames: "assets/[name]-[hash].[ext]",
            },
        },
        chunkSizeWarningLimit: 1000,
        sourcemap: false, // Disable sourcemap untuk production
        minify: "esbuild",
    },
    optimizeDeps: {
        include: ["axios", "alpinejs"],
    },
    resolve: {
        alias: {
            "@": "/resources/js",
            "~": "/resources/css",
        },
    },
    server: {
        host: "localhost",
        port: 5173,
        strictPort: false,
        hmr: {
            host: "localhost",
        },
    },
});
