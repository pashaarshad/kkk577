<!-- Login  -->
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
			<van-button :loading='loginShow'
			            :loading-text="$t('login.Logging')"
			            class='save-btn' type='success' @click='onSubmit'>
			  {{ $t('login.Login') }}
			</van-button>
			<div class='sign' @click="goRegister">{{ $t('login.Sign') }}</div>
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
	  return;
  }
  loginShow.value = true
  let param = new FormData()
  param.append('tel', username.value)
  param.append('pwd', password.value)

  Request.post({ url: '/index/user/do_login', data: param, withCredentials: true }).then(res => {
    sessionStorage.setItem('token', '111111')
    router.push('/home')
    showSuccessToast(res.info)
    loginShow.value = false
  }).catch(err => {
    loginShow.value = false
  })
}
const goRegister = () => {
	router.push('/register')
}
</script>

<style lang='less' scoped>
.Login {
  width: 100%;
  height: 86vh;
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
  }
}
</style>
