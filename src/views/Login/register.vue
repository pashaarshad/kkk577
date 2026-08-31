<!-- Register -->
<template>
  <div class='Login'>
    <div class='top'>
      <div class='logo'></div>
      <div>{{ $t('login.title') }}</div>
    </div>
    <div class='btns'>
      <van-form>
        <van-field
          v-model='invite_code'
          :name="$t('register.invite_code')"
          :placeholder="$t('register.invite_code')"
          :rules="[{ required: true, message: $t('register.inviteCodeError') }]"
          class='btn'
        />
        <van-field
          v-model='tel'
          :name="$t('login.Phone')"
          :placeholder="$t('login.Phone')"
          :rules="[{ required: true, message: $t('register.telError') }]"
          type="number"
          class='btn'
        />
        <van-field
          v-model='pwd'
          :name="$t('login.Password')"
          :placeholder="$t('login.Password')"
          :rules="[{ required: true, message: $t('login.PasswordMsg') }]"
          class='btn'
          type='password'
        />
        <van-field
          v-model='confirm_pwd'
          :name="$t('password.confirmpwd')"
          :placeholder="$t('password.confirmpwd')"
          :rules="[{ required: true, message: $t('login.PasswordMsg') }]"
          class='btn'
          type='password'
        />
        <van-field
          v-model='deposit_pwd'
          :name="$t('register.withdraw_pwd')"
          :placeholder="$t('register.withdraw_pwd')"
          :rules="[{ required: true, message: $t('register.withdrawPwdError') }]"
          class='btn'
          type='password'
        />
        <van-button :loading='loginShow'
                    :loading-text="$t('login.Sign')"
                    class='register-submit-btn' type='primary' @click='onSubmit'>
          {{ $t('login.Sign') }}
        </van-button>
        
        <div class='login-link-wrapper'>
          <span class='login-link' @click="goLogin">Already have an account? Log in</span>
        </div>
      </van-form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { i18n } from '@/lang/index.js'
import Request from '@/services/index.js'
import { showSuccessToast, showFailToast } from 'vant'

const invite_code = ref('')
const tel = ref('')
const pwd = ref('')
const confirm_pwd = ref('')
const deposit_pwd = ref('')
const loginShow = ref(false)

const router = useRouter()
const route = useRoute()
const { t } = i18n.global

// Auto-fill invite code from URL query param (?invite_code=XXXX)
onMounted(() => {
  if (route.query.invite_code) {
    invite_code.value = route.query.invite_code
  }
})

const onSubmit = () => {
  if (tel.value === '' || pwd.value === '' || invite_code.value === '' || deposit_pwd.value === '') {
    showFailToast(t('utils.paramError'))
    return
  }
  if (pwd.value !== confirm_pwd.value) {
    showFailToast(t('password.pwdDiff'))
    return
  }
  loginShow.value = true
  let param = new FormData()
  param.append('tel', tel.value)
  param.append('pwd', pwd.value)
  param.append('invite_code', invite_code.value)
  param.append('deposit_pwd', deposit_pwd.value)

  Request.post({ url: '/index/user/do_register', data: param, withCredentials: true }).then(res => {
    showSuccessToast(res.info || 'Registration successful!')
    loginShow.value = false
    setTimeout(() => {
      router.push('/login')
    }, 500)
  }).catch((err) => {
    loginShow.value = false
    if (err?.info) {
      showFailToast(err.info)
    }
  })
}

const goLogin = () => {
  router.push('/login')
}
</script>

<style lang='less' scoped>
.Login {
  width: 100%;
  min-height: 100vh;
  background: #ffffff;
  padding: 20px 0 35px;
  overflow: hidden;

  .top {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 20px;

    div {
      font-weight: 700 !important;
      font-size: 18px;
      margin-top: 10px;
      color: #333333;
    }
  }

  .logo {
    background: url("../../assets/img/main/fbdb7d08a0b0413fb4d95f214770967b_.jpg") 100%/contain no-repeat;
    width: 60px;
    height: 60px;
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
    padding: 13px 20px !important;
    margin-bottom: 14px;

    :deep(.van-field__control) {
      font-size: 14px;
      color: #1a202c;
    }
  }

  .register-submit-btn {
    width: 100%;
    background: linear-gradient(135deg, #f6ad55 0%, #ed8936 100%);
    border: none;
    color: #ffffff;
    font-weight: 700;
    font-size: 15px;
    border-radius: 25px;
    height: 48px;
    margin-top: 10px;
    box-shadow: 0 4px 12px rgba(237, 137, 54, 0.35);
  }

  .login-link-wrapper {
    width: 100%;
    text-align: center;
    margin-top: 20px;

    .login-link {
      font-size: 13.5px;
      color: #3182ce;
      font-weight: 600;
      cursor: pointer;
      text-decoration: underline;

      &:hover {
        color: #2b6cb0;
      }
    }
  }
}
</style>
