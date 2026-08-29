import en_US from './en_US' // 英文语言配置
import zh_CN from './zh_CN' // 中文语言配置
import es_GT from './es_GT' // 中文语言配置
import { createI18n } from 'vue-i18n'

const config = localStorage.getItem('lang') // 当前使用的语言类型
let lang = 'en_US'
if (config) {
  lang = config.toString()
}
export const i18n = createI18n({
  legacy: false, // componsition API需要设置为false
  locale: lang,
  globalInjection: true, // 可以在template模板中使用$t
  messages: {
    'en_US': en_US,
    'zh_CN': zh_CN,
    'es_GT': es_GT
  }
})

