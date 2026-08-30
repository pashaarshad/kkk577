import Cookie from 'js-cookie'

export function setCookie(key, value) {
  Cookie.set(key, value)
}

//默认ts是天，可以传时间戳
export function setCookieTs(key, value, ts) {
  Cookie.set(key, value, { expires: ts })
}

export function getCookie(key) {
  return Cookie.get(key)
}

export function removeCookie(key) {
  Cookie.remove(key)
}

