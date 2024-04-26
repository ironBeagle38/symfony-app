import { createApp } from 'vue';
import App from './App.vue';  // Assurez-vous que le chemin est correct
import router from './router'; // Assurez-vous que le chemin est correct
console.log('eheheheh')
const app = createApp(App);
app.use(router);
app.mount('#app');