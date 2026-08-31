<!-- Login -->
<template>
  <div class='Login'>
    <div class='top'>
      <div class='logo'></div>
      <div>{{ $t('login.title') }}</div>
    </div>
    <div class='btns'>
      <van-form>
        <van-field
          v-model='username'
          :name="$t('login.Phone')"
          :placeholder="$t('login.Phone')"
          :rules="[{ required: true, message: $t('login.PhoneMsg') }]"
          type="number"
          class='btn'
        />
        <van-field
          v-model='password'
          :name="$t('login.Password')"
          :placeholder="$t('login.Password')"
          :rules="[{ required: true, message: $t('login.PasswordMsg') }]"
          class='btn'
          type='password'
        />
        
        <!-- Login Button -->
        <van-button :loading='loginShow'
                    :loading-text="$t('login.Logging')"
                    class='login-submit-btn' type='primary' @click='onSubmit'>
          {{ $t('login.Login') }}
        </van-button>

        <!-- Register Button (Distinct, Colorful & High Contrast) -->
        <van-button class='register-btn' type='default' @click='goRegister'>
          Register New Account
        </van-button>

        <!-- Forgot Password Link -->
        <div class='forgot-wrapper'>
          <span class='forgot-link' @click="goForgot">Forgot Password?</span>
        </div>
      </van-form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { i18n } from '@/lang/index.js'
import Request from '@/services/index.js'
import { showSuccessToast, showFailToast } from 'vant'

const username = ref('')
const password = ref('')
const loginShow = ref(false)

const router = useRouter()
const { t } = i18n.global

const onSubmit = () => {
  if (username.value === '' || password.value === '') {
    showFailToast(t('utils.paramError'))
    return
  }
  loginShow.value = true
  let param = new FormData()
  param.append('tel', username.value)
  param.append('pwd', password.value)

  Request.post({ url: '/index/user/do_login', data: param, withCredentials: true }).then(res => {
    sessionStorage.setItem('token', '111111')
    showSuccessToast(res.info || 'Login successful!')
    loginShow.value = false
    setTimeout(() => {
      router.push('/home')
    }, 400)
  }).catch((err) => {
    loginShow.value = false
    if (err?.info) {
      showFailToast(err.info)
    }
  })
}

const goRegister = () => {
  router.push('/register')
}

const goForgot = () => {
  router.push('/forgot-password')
}
</script>

<style lang='less' scoped>
.Login {
  width: 100%;
  min-height: 100vh;
  background: #ffffff;
  padding: 35px 0;
  overflow: hidden;

  .top {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 30px;

    div {
      font-weight: 700 !important;
      font-size: 18px;
      margin-top: 10px;
      color: #333333;
    }
  }

  .logo {
    background: url("../../assets/img/main/fbdb7d08a0b0413fb4d95f214770967b_.jpg") 100%/contain no-repeat;
    width: 70px;
    height: 70px;
    border-radius: 12px;
  }

  .btns {
    width: 90%;
    margin: 0 auto;
  }

  .btn {
    width: 100%;
    background: #f4f6f8;
    border: 1px solid #e2e8f0;
    border-radius: 25px;
    padding: 14px 20px !important;
    margin-bottom: 16px;

    :deep(.van-field__control) {
      font-size: 14px;
      color: #1a202c;
    }
  }

  .login-submit-btn {
    width: 100%;
    background: linear-gradient(135deg, #108ee9 0%, #0066cc 100%);
    border: none;
    color: #ffffff;
    font-weight: 700;
    font-size: 15px;
    border-radius: 25px;
    height: 48px;
    margin-top: 10px;
    box-shadow: 0 4px 12px rgba(16, 142, 233, 0.35);
  }

  .register-btn {
    width: 100%;
    background: linear-gradient(135deg, #f6ad55 0%, #ed8936 100%);
    border: none;
    color: #ffffff;
    font-weight: 700;
    font-size: 15px;
    border-radius: 25px;
    height: 48px;
    margin-top: 14px;
    box-shadow: 0 4px 12px rgba(237, 137, 54, 0.35);
  }

  .forgot-wrapper {
    width: 100%;
    text-align: center;
    margin-top: 20px;

    .forgot-link {
      font-size: 13.5px;
      color: #4a5568;
      font-weight: 600;
      cursor: pointer;
      text-decoration: underline;
      transition: color 0.2s;

      &:hover {
        color: #108ee9;
      }
    }
  }
}
</style>
