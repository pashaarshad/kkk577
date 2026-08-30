<template>
  <div class='Login'>
    <div class='top'>
      <div>{{ $t('password.title') }}</div>
    </div>
    <div class='btns'>
		<div class="btn-group">
			<van-button 
			  :class="{ 'tab-btn': activeButton !== 1, 'tab-btn tab-btn-active': activeButton === 1 }" 
			  @click="handleButtonClick(1)"
			>
			  {{ $t('password.type1')}}
			</van-button>
			<van-button 
			  :class="{ 'tab-btn': activeButton !== 2, 'tab-btn tab-btn-active': activeButton === 2 }" 
			  @click="handleButtonClick(2)"
			  style="margin-left: 4%;"
			>
			  {{ $t('password.type2')}}
			</van-button>
		</div>
		<van-form>
			<van-field
			  v-model='old_pwd'
			  :name="$t('password.oldpwd')"
			  :placeholder="$t('password.oldpwd')"
			  :rules="[{ required: true, message: $t('password.oldpwdError') }]"
			  class='btn'
					type='password'
			/>
			<van-field
			  v-model='new_pwd'
			  :name="$t('password.newpwd')"
			  :placeholder="$t('password.newpwd')"
			  :rules="[{ required: true, message: $t('password.newpwdError') }]"
			  class='btn'
			  type='password'
			/>
			<van-field
			  v-model='confirm_pwd'
			  :name="$t('password.confirmpwd')"
			  :placeholder="$t('password.confirmpwd')"
			  :rules="[{ required: true, message: $t('password.confirmpwdError') }]"
			  class='btn'
			  type='password'
			/>
			<van-button :loading='loadShow'
			            :loading-text="$t('login.Logging')"
			            class='save-btn' type='success' @click='onSubmit'>
			  {{ $t('main.submit') }}
			</van-button>
		</van-form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { i18n } from '@/lang/index.js'
import Request from '@/services/index.js'
import { showSuccessToast,showFailToast } from 'vant'

let activeButton = ref(1);

const handleButtonClick = (buttonIndex) => {
  activeButton.value = buttonIndex;
  old_pwd.value = new_pwd.value = confirm_pwd.value = '';
};

const old_pwd = ref('')
const new_pwd = ref('')
const confirm_pwd = ref('')
const loadShow = ref(false)

const router = useRouter()
const { t } = i18n.global
const onSubmit = () => {
	if (old_pwd.value === '' || new_pwd.value === '' || confirm_pwd.value === '') {
	  showFailToast(t('utils.paramError'))
	  return;
	}
	if (new_pwd.value !== confirm_pwd.value) {
		showFailToast(t('password.pwdDiff'))
		return;
	}
  loadShow.value = true

  let param = new FormData()
  param.append('old_pwd', old_pwd.value)
  param.append('new_pwd', new_pwd.value)
  param.append('type', activeButton.value)
  param.append('confirm_pwd', confirm_pwd.value)
  let url = activeButton.value === 1 ? '/index/ctrl/set_pwd' : '/index/ctrl/set_pwd2';
  
  Request.post({ url: url, data: param, withCredentials: true }).then(res => {
    router.push('/mine')
    showSuccessToast(res.info)
    loadShow.value = false
  }).catch(err => {
    loadShow.value = false
  })
}
</script>

<style lang='less' scoped>
	.btn-group {
	  display: flex;
	  margin: .53333rem 0;
	}
	
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
 .tab-btn {
    width: 48%;
	height: .6rem;
    border: 0.05px solid var(--main-color);
    color: var(--main-color);
    border-radius: 30px;
  }
  .tab-btn-active {
    background-color: var(--second-color);
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
