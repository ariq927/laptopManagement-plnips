import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.jsx',

        'resources/assets/vendor/scss/theme-default.scss',
        'resources/assets/vendor/libs/apex-charts/apex-charts.scss',
        'resources/assets/vendor/libs/apex-charts/apexcharts.js',

        // 'resources/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js',
        // 'resources/assets/vendor/libs/boxicons/css/boxicons.css',
      ],
      refresh: true,
    }),
    react(),
  ],

  // Biar path relatif tetap aman di Railway
  build: {
    manifest: true,
    outDir: 'public/build',
    emptyOutDir: true,
  },
});
