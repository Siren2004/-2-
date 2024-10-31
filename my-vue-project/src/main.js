import { createApp } from 'vue'
import App from './App.vue'
import router from '@/components/router.js'

const app = createApp(App)  // Определение переменной app
app.use(router)
app.mount('#app')  // Использование переменной app для монтирования приложения
