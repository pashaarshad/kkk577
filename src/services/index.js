import axios from 'axios'
import { useMainStore } from '@/store/modules/main'
import { baseURL, TIMEOUT } from './config'
import { showFailToast } from 'vant'

const mainStore = useMainStore()

class Request {
  constructor(baseURL) {
    this.instance = axios.create({
      baseURL,
      timeout: TIMEOUT,
      withCredentials: true
    })

    this.instance.interceptors.request.use(config => {
      if (config.showLoading) {
        mainStore.isLoading = true
      }
      const token = localStorage.getItem('token') || sessionStorage.getItem('token')
      const userId = localStorage.getItem('user_id') || sessionStorage.getItem('user_id')
      if (token) {
        config.headers = config.headers || {}
        config.headers['token'] = token
      }
      if (userId) {
        config.headers = config.headers || {}
        config.headers['user-id'] = userId
      }
      return config
    }, err => {
      return err
    })
    this.instance.interceptors.response.use(res => {
      mainStore.isLoading = false
      return res
    }, err => {
      mainStore.isLoading = false
      return Promise.reject(err)
    })
  }

  request(config) {
    return new Promise((resolve, reject) => {
      this.instance
        .request(config)
        .then((res) => {
          if (res?.data?.code !== 0) {
            const infoMsg = String(res?.data?.info || '')
            if (infoMsg.includes('login') || infoMsg.includes('no_login') || infoMsg.includes('登录')) {
              sessionStorage.clear()
              localStorage.clear()
              const currentHash = window.location.hash || ''
              if (!currentHash.includes('#/login') && !currentHash.includes('#/register') && !currentHash.includes('#/home')) {
                window.location.hash = '#/login'
              }
            }
            if (config.showToast && res?.data?.info) {
              showFailToast(res.data.info)
            }
            reject(res?.data || { info: 'Operation failed' })
          } else {
            resolve(res.data)
          }
        })
        .catch((err) => {
          console.log('request err:', err)
          const errStatus = err?.response?.status
          if (errStatus === 401 || errStatus === 403) {
            sessionStorage.clear()
            localStorage.clear()
            const currentHash = window.location.hash || ''
            if (!currentHash.includes('#/login') && !currentHash.includes('#/register') && !currentHash.includes('#/home')) {
              window.location.hash = '#/login'
            }
          }
          const errData = err?.response?.data || err?.data || err || {}
          reject(errData.info ? errData : { info: errData.message || err?.message || 'Network request failed' })
        })
    })
  }

  get(config, params) {
    if (typeof config === 'string') {
      return this.request({ url: config, params, method: 'get' })
    }
    return this.request({ ...config, method: 'get' })
  }

  post(config, postData) {
    if (typeof config === 'string') {
      config = { url: config, data: postData }
    }
    let data = config.data
    if (data && typeof data === 'object' && !(data instanceof FormData) && !(data instanceof URLSearchParams)) {
      const params = new URLSearchParams()
      for (const key in data) {
        if (data[key] !== undefined && data[key] !== null) {
          params.append(key, data[key])
        }
      }
      data = params
    }
    return this.request({ ...config, data, method: 'post' })
  }

  formData(config) {
    let data = config.data
    let url = config.url
    return this.request(
      { url, data, method: 'post' },
      {
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
      }
    )
  }
}

export default new Request(baseURL)
