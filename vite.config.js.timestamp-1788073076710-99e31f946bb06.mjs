// vite.config.js
import { defineConfig } from "file:///D:/freelance/kkk577/node_modules/vite/dist/node/index.js";
import vue from "file:///D:/freelance/kkk577/node_modules/@vitejs/plugin-vue/dist/index.mjs";
import Components from "file:///D:/freelance/kkk577/node_modules/unplugin-vue-components/dist/vite.js";
import { VantResolver } from "file:///D:/freelance/kkk577/node_modules/@vant/auto-import-resolver/dist/index.esm.mjs";
import { fileURLToPath, URL } from "node:url";
import postCssPxToRem from "file:///D:/freelance/kkk577/node_modules/postcss-pxtorem/index.js";
var __vite_injected_original_import_meta_url = "file:///D:/freelance/kkk577/vite.config.js";
var vite_config_default = defineConfig({
  base: "/",
  // 访问路径/m/
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
          // (Number | Function) 表示根元素字体大小或根据[`input`](https://api.postcss.org/Input.html)参数返回根元素字体大小
          unitPrecision: 5,
          // 允许REM单位增长到的十进制数字,小数点后保留的位数。
          propList: ["*"],
          exclude: /(node_module)/,
          // 默认false，可以（reg）利用正则表达式排除某些文件夹的方法，例如/(node_module)/ 。如果想把前端UI框架内的px也转换成rem，请把此属性设为默认值
          selectorBlackList: ["vant-"],
          // 要忽略并保留为px的选择器，我使用的UI框架为vant 所以这里会配置vant-
          mediaQuery: false,
          // （布尔值）允许在媒体查询中转换px。
          minPixelValue: 1
          // 设置要替换的最小像素值
        })
      ]
    }
  },
  resolve: {
    alias: {
      "@": fileURLToPath(new URL("./src", __vite_injected_original_import_meta_url)),
      "vue-i18n": "vue-i18n/dist/vue-i18n.cjs.js"
    }
  },
  server: {
    proxy: {
      // 代理规则配置
      "/api": {
        target: "http://127.0.0.1:8000/",
        // 本地接口地址 (原: https://api.kkk577.net/)
        changeOrigin: true,
        rewrite: (path) => path.replace(/^\/api/, ""),
        credentials: "include"
        // 携带源请求的Cookie
      },
      // 静态图片和资源代理到本地 ThinkPHP 服务
      "^/(upload|static|static_new|static_new6|statics|static_indonesia|alllang|red|layer|p_static1)": {
        target: "http://127.0.0.1:8000/",
        changeOrigin: true
      }
    }
  }
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJEOlxcXFxmcmVlbGFuY2VcXFxca2trNTc3XCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ZpbGVuYW1lID0gXCJEOlxcXFxmcmVlbGFuY2VcXFxca2trNTc3XFxcXHZpdGUuY29uZmlnLmpzXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ltcG9ydF9tZXRhX3VybCA9IFwiZmlsZTovLy9EOi9mcmVlbGFuY2Uva2trNTc3L3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSdcclxuaW1wb3J0IHZ1ZSBmcm9tICdAdml0ZWpzL3BsdWdpbi12dWUnXHJcbmltcG9ydCBDb21wb25lbnRzIGZyb20gJ3VucGx1Z2luLXZ1ZS1jb21wb25lbnRzL3ZpdGUnXHJcbmltcG9ydCB7IFZhbnRSZXNvbHZlciB9IGZyb20gJ0B2YW50L2F1dG8taW1wb3J0LXJlc29sdmVyJ1xyXG5cclxuaW1wb3J0IHsgZmlsZVVSTFRvUGF0aCwgVVJMIH0gZnJvbSAnbm9kZTp1cmwnXHJcbmltcG9ydCBwb3N0Q3NzUHhUb1JlbSBmcm9tICdwb3N0Y3NzLXB4dG9yZW0nXHJcblxyXG5cclxuZXhwb3J0IGRlZmF1bHQgZGVmaW5lQ29uZmlnKHtcclxuICBiYXNlOiAnLycsIC8vIFx1OEJCRlx1OTVFRVx1OERFRlx1NUY4NC9tL1xyXG4gIHBsdWdpbnM6IFtcclxuICAgIHZ1ZSgpLFxyXG4gICAgQ29tcG9uZW50cyh7XHJcbiAgICAgIHJlc29sdmVyczogW1ZhbnRSZXNvbHZlcigpXVxyXG4gICAgfSlcclxuICBdLFxyXG4gIGNzczoge1xyXG4gICAgcG9zdGNzczoge1xyXG4gICAgICBwbHVnaW5zOiBbXHJcbiAgICAgICAgcG9zdENzc1B4VG9SZW0oe1xyXG4gICAgICAgICAgcm9vdFZhbHVlOiA0MSwvLyAoTnVtYmVyIHwgRnVuY3Rpb24pIFx1ODg2OFx1NzkzQVx1NjgzOVx1NTE0M1x1N0QyMFx1NUI1N1x1NEY1M1x1NTkyN1x1NUMwRlx1NjIxNlx1NjgzOVx1NjM2RVtgaW5wdXRgXShodHRwczovL2FwaS5wb3N0Y3NzLm9yZy9JbnB1dC5odG1sKVx1NTNDMlx1NjU3MFx1OEZENFx1NTZERVx1NjgzOVx1NTE0M1x1N0QyMFx1NUI1N1x1NEY1M1x1NTkyN1x1NUMwRlxyXG4gICAgICAgICAgdW5pdFByZWNpc2lvbjogNSwgLy8gXHU1MTQxXHU4QkI4UkVNXHU1MzU1XHU0RjREXHU1ODlFXHU5NTdGXHU1MjMwXHU3Njg0XHU1MzQxXHU4RkRCXHU1MjM2XHU2NTcwXHU1QjU3LFx1NUMwRlx1NjU3MFx1NzBCOVx1NTQwRVx1NEZERFx1NzU1OVx1NzY4NFx1NEY0RFx1NjU3MFx1MzAwMlxyXG4gICAgICAgICAgcHJvcExpc3Q6IFsnKiddLFxyXG4gICAgICAgICAgZXhjbHVkZTogLyhub2RlX21vZHVsZSkvLCAvLyBcdTlFRDhcdThCQTRmYWxzZVx1RkYwQ1x1NTNFRlx1NEVFNVx1RkYwOHJlZ1x1RkYwOVx1NTIyOVx1NzUyOFx1NkI2M1x1NTIxOVx1ODg2OFx1OEZCRVx1NUYwRlx1NjM5Mlx1OTY2NFx1NjdEMFx1NEU5Qlx1NjU4N1x1NEVGNlx1NTkzOVx1NzY4NFx1NjVCOVx1NkNENVx1RkYwQ1x1NEY4Qlx1NTk4Mi8obm9kZV9tb2R1bGUpLyBcdTMwMDJcdTU5ODJcdTY3OUNcdTYwRjNcdTYyOEFcdTUyNERcdTdBRUZVSVx1Njg0Nlx1NjdCNlx1NTE4NVx1NzY4NHB4XHU0RTVGXHU4RjZDXHU2MzYyXHU2MjEwcmVtXHVGRjBDXHU4QkY3XHU2MjhBXHU2QjY0XHU1QzVFXHU2MDI3XHU4QkJFXHU0RTNBXHU5RUQ4XHU4QkE0XHU1MDNDXHJcbiAgICAgICAgICBzZWxlY3RvckJsYWNrTGlzdDogWyd2YW50LSddLCAvLyBcdTg5ODFcdTVGRkRcdTc1NjVcdTVFNzZcdTRGRERcdTc1NTlcdTRFM0FweFx1NzY4NFx1OTAwOVx1NjJFOVx1NTY2OFx1RkYwQ1x1NjIxMVx1NEY3Rlx1NzUyOFx1NzY4NFVJXHU2ODQ2XHU2N0I2XHU0RTNBdmFudCBcdTYyNDBcdTRFRTVcdThGRDlcdTkxQ0NcdTRGMUFcdTkxNERcdTdGNkV2YW50LVxyXG4gICAgICAgICAgbWVkaWFRdWVyeTogZmFsc2UsIC8vIFx1RkYwOFx1NUUwM1x1NUMxNFx1NTAzQ1x1RkYwOVx1NTE0MVx1OEJCOFx1NTcyOFx1NUE5Mlx1NEY1M1x1NjdFNVx1OEJFMlx1NEUyRFx1OEY2Q1x1NjM2MnB4XHUzMDAyXHJcbiAgICAgICAgICBtaW5QaXhlbFZhbHVlOiAxIC8vIFx1OEJCRVx1N0Y2RVx1ODk4MVx1NjZGRlx1NjM2Mlx1NzY4NFx1NjcwMFx1NUMwRlx1NTBDRlx1N0QyMFx1NTAzQ1xyXG4gICAgICAgIH0pXHJcbiAgICAgIF1cclxuICAgIH1cclxuICB9LFxyXG4gIHJlc29sdmU6IHtcclxuICAgIGFsaWFzOiB7XHJcbiAgICAgICdAJzogZmlsZVVSTFRvUGF0aChuZXcgVVJMKCcuL3NyYycsIGltcG9ydC5tZXRhLnVybCkpLFxyXG4gICAgICAndnVlLWkxOG4nOiAndnVlLWkxOG4vZGlzdC92dWUtaTE4bi5janMuanMnXHJcbiAgICB9XHJcbiAgfSxcclxuICBzZXJ2ZXI6IHtcclxuICAgIHByb3h5OiB7XHJcbiAgICAgIC8vIFx1NEVFM1x1NzQwNlx1ODlDNFx1NTIxOVx1OTE0RFx1N0Y2RVxyXG4gICAgICAnL2FwaSc6IHtcclxuICAgICAgICB0YXJnZXQ6ICdodHRwOi8vMTI3LjAuMC4xOjgwMDAvJywgLy8gXHU2NzJDXHU1NzMwXHU2M0E1XHU1M0UzXHU1NzMwXHU1NzQwIChcdTUzOUY6IGh0dHBzOi8vYXBpLmtrazU3Ny5uZXQvKVxyXG4gICAgICAgIGNoYW5nZU9yaWdpbjogdHJ1ZSxcclxuICAgICAgICByZXdyaXRlOiAocGF0aCkgPT4gcGF0aC5yZXBsYWNlKC9eXFwvYXBpLywgJycpLFxyXG4gICAgICAgIGNyZWRlbnRpYWxzOiAnaW5jbHVkZScgLy8gXHU2NDNBXHU1RTI2XHU2RTkwXHU4QkY3XHU2QzQyXHU3Njg0Q29va2llXHJcbiAgICAgIH0sXHJcbiAgICAgIC8vIFx1OTc1OVx1NjAwMVx1NTZGRVx1NzI0N1x1NTQ4Q1x1OEQ0NFx1NkU5MFx1NEVFM1x1NzQwNlx1NTIzMFx1NjcyQ1x1NTczMCBUaGlua1BIUCBcdTY3MERcdTUyQTFcclxuICAgICAgJ14vKHVwbG9hZHxzdGF0aWN8c3RhdGljX25ld3xzdGF0aWNfbmV3NnxzdGF0aWNzfHN0YXRpY19pbmRvbmVzaWF8YWxsbGFuZ3xyZWR8bGF5ZXJ8cF9zdGF0aWMxKSc6IHtcclxuICAgICAgICB0YXJnZXQ6ICdodHRwOi8vMTI3LjAuMC4xOjgwMDAvJyxcclxuICAgICAgICBjaGFuZ2VPcmlnaW46IHRydWVcclxuICAgICAgfVxyXG4gICAgfVxyXG4gIH1cclxufSlcbiJdLAogICJtYXBwaW5ncyI6ICI7QUFBaVAsU0FBUyxvQkFBb0I7QUFDOVEsT0FBTyxTQUFTO0FBQ2hCLE9BQU8sZ0JBQWdCO0FBQ3ZCLFNBQVMsb0JBQW9CO0FBRTdCLFNBQVMsZUFBZSxXQUFXO0FBQ25DLE9BQU8sb0JBQW9CO0FBTndILElBQU0sMkNBQTJDO0FBU3BNLElBQU8sc0JBQVEsYUFBYTtBQUFBLEVBQzFCLE1BQU07QUFBQTtBQUFBLEVBQ04sU0FBUztBQUFBLElBQ1AsSUFBSTtBQUFBLElBQ0osV0FBVztBQUFBLE1BQ1QsV0FBVyxDQUFDLGFBQWEsQ0FBQztBQUFBLElBQzVCLENBQUM7QUFBQSxFQUNIO0FBQUEsRUFDQSxLQUFLO0FBQUEsSUFDSCxTQUFTO0FBQUEsTUFDUCxTQUFTO0FBQUEsUUFDUCxlQUFlO0FBQUEsVUFDYixXQUFXO0FBQUE7QUFBQSxVQUNYLGVBQWU7QUFBQTtBQUFBLFVBQ2YsVUFBVSxDQUFDLEdBQUc7QUFBQSxVQUNkLFNBQVM7QUFBQTtBQUFBLFVBQ1QsbUJBQW1CLENBQUMsT0FBTztBQUFBO0FBQUEsVUFDM0IsWUFBWTtBQUFBO0FBQUEsVUFDWixlQUFlO0FBQUE7QUFBQSxRQUNqQixDQUFDO0FBQUEsTUFDSDtBQUFBLElBQ0Y7QUFBQSxFQUNGO0FBQUEsRUFDQSxTQUFTO0FBQUEsSUFDUCxPQUFPO0FBQUEsTUFDTCxLQUFLLGNBQWMsSUFBSSxJQUFJLFNBQVMsd0NBQWUsQ0FBQztBQUFBLE1BQ3BELFlBQVk7QUFBQSxJQUNkO0FBQUEsRUFDRjtBQUFBLEVBQ0EsUUFBUTtBQUFBLElBQ04sT0FBTztBQUFBO0FBQUEsTUFFTCxRQUFRO0FBQUEsUUFDTixRQUFRO0FBQUE7QUFBQSxRQUNSLGNBQWM7QUFBQSxRQUNkLFNBQVMsQ0FBQyxTQUFTLEtBQUssUUFBUSxVQUFVLEVBQUU7QUFBQSxRQUM1QyxhQUFhO0FBQUE7QUFBQSxNQUNmO0FBQUE7QUFBQSxNQUVBLGlHQUFpRztBQUFBLFFBQy9GLFFBQVE7QUFBQSxRQUNSLGNBQWM7QUFBQSxNQUNoQjtBQUFBLElBQ0Y7QUFBQSxFQUNGO0FBQ0YsQ0FBQzsiLAogICJuYW1lcyI6IFtdCn0K
