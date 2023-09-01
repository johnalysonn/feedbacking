import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import Toast, {POSITION} from 'vue-toastification'

import 'animate.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap/dist/js/bootstrap.js'
import 'vue-toastification/dist/index.css'


createApp(App)
.use(router)
.use(Toast, {position: POSITION.BOTTOM_RIGHT})
.mount('#app')
