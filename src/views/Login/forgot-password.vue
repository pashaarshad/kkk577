<!-- Forgot Password -->
<template>
  <div class='Login'>
    <div class='top'>
      <div class='logo'></div>
      <div>Forgot Password</div>
    </div>
    <div class='btns'>
      <van-form>
        <van-field
          v-model='tel'
          name="Phone Number"
          placeholder="Enter your phone number"
          type="number"
          class='btn'
        />
        <van-field
          v-model='new_pwd'
          name="New Password"
          placeholder="New Password"
          class='btn'
          type='password'
        />
        <van-field
          v-model='deposit_pwd'
          name="Withdrawal Password"
          placeholder="Withdrawal Password (to verify identity)"
          class='btn'
          type='password'
        />
        <van-button :loading='loading'
                    loading-text="Resetting..."
                    class='save-btn' type='success' @click='onSubmit'>
          Reset Password
        </van-button>
        <div class='sign' @click="goLogin">Back to Login</div>
      </van-form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import Request from '@/services/index.js'
import { showSuccessToast, showFailToast } from 'vant'

const tel = ref('')
const new_pwd = ref('')
const deposit_pwd = ref('')
const loading = ref(false)

const router = useRouter()

const onSubmit = () => {
  if (tel.value === '' || new_pwd.value === '' || deposit_pwd.value === '') {
    showFailToast('Please fill in all fields')
    return
  }
  loading.value = true
  let param = new FormData()
  param.append('tel', tel.value)
  param.append('new_pwd', new_pwd.value)
  param.append('deposit_pwd', deposit_pwd.value)

  Request.post({ url: '/index/user/forget_pwd', data: param, withCredentials: true }).then(res => {
    showSuccessToast(res.info || 'Password reset successfully!')
    router.push('/login')
    loading.value = false
  }).catch(() => {
    loading.value = false
  })
}

const goLogin = () => {
  router.push('/login')
}
</script>

<style lang='less' scoped>
.Login {
  width: 100%;
  min-height: 86vh;
  background: #ffffff;
  padding: 35px 0;
  overflow: hidden;

  .top {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 40px;

    div {
      font-weight: 700 !important;
      font-size: 17px;
      margin-top: 10px;
    }
  }

  .logo {
    background: url("../../assets/img/main/fbdb7d08a0b0413fb4d95f214770967b_.jpg") 100%/contain;
    width: 80px;
    height: 80px;
  }

  .btns {
    width: 92%;
    margin: 0 auto;
  }

  .btn {
    width: 100%;
    background: #f7f8fa;
    border-radius: 30px;
    padding: 16px !important;
    margin-bottom: 20px;

    :deep(.van-cell) {
      padding: 20px !important;
    }
  }

  .save-btn {
    width: 100%;
    background-color: var(--second-color);
    border: 0.05px solid var(--main-color);
    color: var(--main-color);
    border-radius: 30px;
  }

  .sign {
    width: 100%;
    text-align: center;
    font-weight: 700 !important;
    margin-top: 20px;
    font-size: 13.2px;
    cursor: pointer;
  }
}
</style>
