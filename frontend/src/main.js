import { createApp } from 'vue'
import App from './App.vue'
import router from "./router";
import './index.css'  // <--- importar o Tailwind

createApp(App).use(router).mount("#app");