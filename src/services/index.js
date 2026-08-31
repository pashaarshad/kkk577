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
      return config
    }, err => {
      return err
    })
    this.instance.interceptors.response.use(res => {
      mainStore.isLoading = false
      return res
    }, err => {
      mainStore.isLoading = false
      return err
    })
  }

  request(config) {
    return new Promise((resolve, reject) => {
      this.instance
        .request(config)
        .then((res) => {
          if (res?.data?.code !== 0) {
            // Only show toast if explicitly requested via config or non-empty user-facing error
            if (config.showToast && res?.data?.info) {
              showFailToast(res.data.info)
            }
            reject(res.data)
          } else {
            resolve(res.data)
          }
        })
        .catch((err) => {
          console.log('request err:', err)
          reject(err)
        })
    })
  }

  get(config) {
    return this.request({ ...config, method: 'get' })
  }

  post(config) {
    return this.request({ ...config, method: 'post' })
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
