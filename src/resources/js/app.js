import { createApp } from 'vue';
import router from "./router/index";

import App from "./componentes/App.vue";

createApp(App).use(router).mount("#app");