import { defineConfig } from "vite";
import symfonyPlugin from "vite-plugin-symfony";
import vue from '@vitejs/plugin-vue'; // Importez le plugin Vue

/* if you're using React */
// import react from '@vitejs/plugin-react';

export default defineConfig({
  plugins: [
    vue(),
    /* react(), // if you're using React */
    symfonyPlugin(),
    ],
    build: {
      rollupOptions: {
        input: {
          app: "./assets/app.js"
        },
      }
    },
});
