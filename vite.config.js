import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/assets/vendor/scss/core.scss',
        'resources/assets/vendor/scss/theme-default.scss',
        'resources/assets/vendor/scss/_theme/_theme.scss',
        'resources/assets/vendor/scss/custom-override.scss',
        'resources/js/app.jsx',
      ],
      refresh: true,
    }),
    react(),
  ],
  build: {
    outDir: 'public/build',
    emptyOutDir: true,
    manifest: true,
  },
});
