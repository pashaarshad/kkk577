import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import Components from 'unplugin-vue-components/vite'
import { VantResolver } from '@vant/auto-import-resolver'

import { fileURLToPath, URL } from 'node:url'
import postCssPxToRem from 'postcss-pxtorem'


export default defineConfig({
  base: '/', // 访问路径/m/
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
          rootValue: 41,// (Number | Function) 表示根元素字体大小或根据[`input`](https://api.postcss.org/Input.html)参数返回根元素字体大小
          unitPrecision: 5, // 允许REM单位增长到的十进制数字,小数点后保留的位数。
          propList: ['*'],
          exclude: /(node_module)/, // 默认false，可以（reg）利用正则表达式排除某些文件夹的方法，例如/(node_module)/ 。如果想把前端UI框架内的px也转换成rem，请把此属性设为默认值
          selectorBlackList: ['vant-'], // 要忽略并保留为px的选择器，我使用的UI框架为vant 所以这里会配置vant-
          mediaQuery: false, // （布尔值）允许在媒体查询中转换px。
          minPixelValue: 1 // 设置要替换的最小像素值
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
      // 代理规则配置
      '/api': {
        target: 'http://127.0.0.1:8000/', // 本地接口地址 (原: https://api.kkk577.net/)
        changeOrigin: true,
        rewrite: (path) => path.replace(/^\/api/, ''),
        credentials: 'include' // 携带源请求的Cookie
      }
    }
  }
})
