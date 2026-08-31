import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import Components from 'unplugin-vue-components/vite'
import { VantResolver } from '@vant/auto-import-resolver'

import { fileURLToPath, URL } from 'node:url'
import postCssPxToRem from 'postcss-pxtorem'

export default defineConfig({
  base: '/',
  plugins: [
    vue(),
    Components({
      resolvers: [VantResolver()]
    })
  ],
  css: {
    postcss: {
      plugins: [
        postCssPxToRem({
          rootValue: 41,
          unitPrecision: 5,
          propList: ['*'],
          exclude: /(node_module)/,
          selectorBlackList: ['vant-'],
          mediaQuery: false,
          minPixelValue: 1
        })
      ]
    }
  },
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
      'vue-i18n': 'vue-i18n/dist/vue-i18n.cjs.js'
    }
  },
  server: {
    proxy: {
      // 代理 /api 请求 -> 本地 ThinkPHP 后端
      '/api': {
        target: 'http://127.0.0.1:8000/',
        changeOrigin: true,
        rewrite: (path) => path.replace(/^\/api/, ''),
        credentials: 'include'
      },
      // 代理 /index/、图片资源以及管理后台请求
      '^/(upload|static|static_new|static_new6|statics|static_indonesia|alllang|red|layer|p_static1|index|owe9j2|admin)': {
        target: 'http://127.0.0.1:8000/',
        changeOrigin: true
      }
    }
  }
})
