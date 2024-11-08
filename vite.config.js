import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
  plugins: [vue()],
  server: {
    host: '0.0.0.0', // Aggiungi questa riga per esporre Vite su tutte le interfacce di rete
    port: 5173,
    proxy: {
      '/api': {
        target: 'http://localhost', // Modifica qui se il backend ha una porta diversa
        changeOrigin: true,
      },
    },
  },
});
