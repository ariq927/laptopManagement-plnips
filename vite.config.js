import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.jsx',

        // 🟢 Tambahin semua SCSS yang dibutuhkan
        'resources/assets/vendor/scss/theme-default.scss',
        'resources/assets/vendor/scss/_theme/_theme.scss',
      ],
      refresh: true,
      buildDirectory: 'build',
    }),
    react(),
  ],

  build: {
    outDir: path.resolve(__dirname, 'public/build'),
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: [
        'resources/css/app.css',
        'resources/js/app.jsx',

        // 🟢 Tambahin di sini juga (biar aman waktu build)
        'resources/assets/vendor/scss/theme-default.scss',
        'resources/assets/vendor/scss/_theme/_theme.scss',
      ],
      output: {
        entryFileNames: 'assets/[name].[hash].js',
        chunkFileNames: 'assets/[name].[hash].js',
        assetFileNames: 'assets/[name].[hash].[ext]',
      },
    },
  },

  resolve: {
    alias: {
      '@': '/resources/js',
    },
  },
});
