import { createApp } from 'vue'
import App from './App.vue'
import router from '@/router/index.js'
import store from '@/store/index.js'
import 'normalize.css'
import '@/assets/css/index.css'
import { i18n } from '@/lang/index'
import 'vant/es/image-preview/style'
import 'vant/es/notify/style'
import 'vant/es/dialog/style'
import 'vant/es/toast/style'
import '@/utils/rem.js'


createApp(App).use(i18n).use(router).use(store).mount('#app')
