<!-- Register / Sign Up -->
<template>
  <div class="register-page-container">
    <!-- Top Bar with Logo & Language Switcher -->
    <div class="top-header">
      <div class="brand-logo-row">
        <div class="brand-logo"></div>
        <span class="brand-name">Global Task</span>
      </div>

      <!-- Language Selector -->
      <div class="lang-selector" @click="toggleLang">
        <span class="globe-icon">🌐</span>
        <span class="lang-text">{{ currentLangName }} ∨</span>
      </div>
    </div>

    <!-- Title Below Header -->
    <h2 class="platform-title">Global Task Marketing Platform</h2>

    <!-- White Auth Card -->
    <div class="auth-card">
      <div class="card-header-title">Create New Account</div>

      <!-- Register Form -->
      <form class="auth-form" @submit.prevent="onSubmit">
        <!-- Invite Code -->
        <div class="form-group">
          <label class="field-label">Invitation Code</label>
          <div class="input-wrapper">
            <input 
              v-model="invite_code" 
              type="text" 
              placeholder="Please enter invitation code"
              class="underline-input"
              required
            />
          </div>
        </div>

        <!-- Account Input Field -->
        <div class="form-group">
          <label class="field-label">Phone Number</label>
          <div class="input-wrapper">
            <input 
              v-model="tel" 
              type="tel" 
              placeholder="Please enter phone number"
              class="underline-input"
              required
            />
          </div>
        </div>

        <!-- Password Field -->
        <div class="form-group">
          <label class="field-label">Password</label>
          <div class="input-wrapper">
            <input 
              v-model="pwd" 
              :type="showPwd ? 'text' : 'password'" 
              placeholder="Please enter password"
              class="underline-input"
              required
            />
            <span class="eye-toggle" @click="showPwd = !showPwd">
              <svg v-if="!showPwd" viewBox="0 0 24 24" width="20" height="20"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" fill="#7a6652"/></svg>
              <svg v-else viewBox="0 0 24 24" width="20" height="20"><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.44-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.17c0-1.66-1.34-3-3-3l-.17.02z" fill="#7a6652"/></svg>
            </span>
          </div>
        </div>

        <!-- Confirm Password Field -->
        <div class="form-group">
          <label class="field-label">Confirm Password</label>
          <div class="input-wrapper">
            <input 
              v-model="confirm_pwd" 
              :type="showPwd ? 'text' : 'password'" 
              placeholder="Confirm new password"
              class="underline-input"
              required
            />
          </div>
        </div>

        <!-- Withdrawal Password -->
        <div class="form-group">
          <label class="field-label">Withdrawal Password</label>
          <div class="input-wrapper">
            <input 
              v-model="deposit_pwd" 
              type="password" 
              placeholder="Set withdrawal password"
              class="underline-input"
              required
            />
          </div>
        </div>

        <!-- Agreement Checkbox -->
        <div class="agree-row" @click="agreed = !agreed">
          <div :class="['custom-checkbox', agreed ? 'checked' : '']">
            <span v-if="agreed">✓</span>
          </div>
          <span class="agree-text">
            Agree with our <a href="#" @click.stop.prevent>Terms of use</a> And <a href="#" @click.stop.prevent>Privacy agreement</a>
          </span>
        </div>

        <!-- Primary Sign Up Button -->
        <button type="submit" class="submit-btn" :disabled="regLoading">
          {{ regLoading ? 'Signing Up...' : 'Sign Up' }}
        </button>

        <!-- Secondary Sign In Link -->
        <div class="signin-link-container">
          <span class="signin-link" @click="goLogin">Sign In</span>
        </div>
      </form>
    </div>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/553588236216?text=Hello" target="_blank" class="whatsapp-float-btn">
      <svg viewBox="0 0 24 24" width="28" height="28">
        <circle cx="12" cy="12" r="12" fill="#25d366" />
        <path d="M12.012 5.5a6.5 6.5 0 0 0-5.635 9.757l-.76 2.775 2.84-.745a6.5 6.5 0 1 0 3.555-11.787zm3.178 9.176c-.13.364-.753.694-1.037.738-.28.044-.564.07-.852.078a4.935 4.935 0 0 1-2.92-1.077c-1.12-.907-1.858-2.222-1.858-3.328 0-.58.175-1.01.503-1.328a.5.5 0 0 1 .373-.175c.088 0 .175.008.254.017.08.01.12.02.176.136.216.52.54 1.306.588 1.402a.25.25 0 0 1 .01.233c-.05.105-.1.17-.184.262-.07.088-.166.193-.245.27-.088.08-.184.167-.08.347.106.18.474.78.966 1.217.63.56 1.164.735 1.33.823.167.088.263.08.36-.032.096-.114.41-.482.525-.648a.25.25 0 0 1 .237-.097c.105.027.675.316.79.377.114.06.193.088.22.132.026.044.026.254-.105.618z" fill="white" />
      </svg>
    </a>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import Request from '@/services/index.js'
import { showSuccessToast, showFailToast } from 'vant'

const router = useRouter()
const route = useRoute()

const invite_code = ref('')
const tel = ref('')
const pwd = ref('')
const confirm_pwd = ref('')
const deposit_pwd = ref('')
const showPwd = ref(false)
const agreed = ref(true)
const regLoading = ref(false)

const currentLangName = ref('English')

const toggleLang = () => {
  if (currentLangName.value === 'English') {
    currentLangName.value = 'Español'
  } else {
    currentLangName.value = 'English'
  }
}

// Auto-fill invite code from URL query param (?invite_code=XXXX)
onMounted(() => {
  if (route.query.invite_code) {
    invite_code.value = route.query.invite_code
  }
})

const onSubmit = () => {
  if (!tel.value || !pwd.value || !invite_code.value || !deposit_pwd.value) {
    showFailToast('Please fill in all required fields')
    return
  }
  if (pwd.value !== confirm_pwd.value) {
    showFailToast('Passwords do not match')
    return
  }
  if (!agreed.value) {
    showFailToast('Please agree to the Terms of use and Privacy agreement')
    return
  }

  regLoading.value = true
  let param = new FormData()
  param.append('tel', tel.value)
  param.append('pwd', pwd.value)
  param.append('invite_code', invite_code.value)
  param.append('deposit_pwd', deposit_pwd.value)

  Request.post({ url: '/index/user/do_register', data: param, withCredentials: true }).then(res => {
    showSuccessToast(res.info || 'Registration successful!')
    regLoading.value = false
    setTimeout(() => {
      router.push('/login')
    }, 500)
  }).catch((err) => {
    regLoading.value = false
    if (err?.info) {
      showFailToast(err.info)
    }
  })
}

const goLogin = () => {
  router.push('/login')
}
</script>

<style lang="less" scoped>
.register-page-container {
  min-height: 100vh;
  width: 100%;
  background: linear-gradient(180deg, #f5e3c3 0%, #e8cb9b 50%, #d8b47e 100%);
  padding: 16px 16px 40px;
  box-sizing: border-box;
  position: relative;

  /* Top Bar */
  .top-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 6px 0;

    .brand-logo-row {
      display: flex;
      align-items: center;
      gap: 8px;

      .brand-logo {
        width: 32px;
        height: 32px;
        background: url("../../assets/img/main/fbdb7d08a0b0413fb4d95f214770967b_.jpg") center/cover no-repeat;
        border-radius: 8px;
      }

      .brand-name {
        font-size: 15px;
        font-weight: 700;
        color: #543415;
      }
    }

    .lang-selector {
      background: rgba(255, 255, 255, 0.7);
      padding: 5px 12px;
      border-radius: 20px;
      display: flex;
      align-items: center;
      gap: 5px;
      font-size: 12.5px;
      font-weight: 600;
      color: #543415;
      cursor: pointer;
      backdrop-filter: blur(4px);
    }
  }

  /* Subtitle */
  .platform-title {
    font-size: 18px;
    font-weight: 800;
    color: #543415;
    text-align: center;
    margin: 20px 0 18px;
    letter-spacing: 0.3px;
  }

  /* White Auth Card */
  .auth-card {
    background: #ffffff;
    border-radius: 18px;
    width: 100%;
    max-width: 400px;
    margin: 0 auto;
    padding: 24px 22px 28px;
    box-shadow: 0 10px 30px rgba(84, 52, 21, 0.12);
    box-sizing: border-box;

    .card-header-title {
      font-size: 16px;
      font-weight: 800;
      color: #543415;
      text-align: center;
      margin-bottom: 20px;
    }
  }

  /* Form Fields */
  .form-group {
    margin-bottom: 18px;

    .field-label {
      display: block;
      font-size: 13px;
      font-weight: 600;
      color: #543415;
      margin-bottom: 4px;
    }

    .input-wrapper {
      position: relative;
      display: flex;
      align-items: center;

      .underline-input {
        width: 100%;
        border: none;
        border-bottom: 1.5px solid #e5d7c4;
        padding: 8px 0;
        font-size: 14px;
        color: #2a1a0a;
        background: transparent;
        outline: none;

        &::placeholder {
          color: #b5a491;
          font-size: 13px;
        }

        &:focus {
          border-bottom-color: #543415;
        }
      }

      .eye-toggle {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        padding: 4px;
      }
    }
  }

  /* Agreement Row */
  .agree-row {
    display: flex;
    align-items: center;
    gap: 9px;
    margin: 18px 0 22px;
    cursor: pointer;

    .custom-checkbox {
      width: 18px;
      height: 18px;
      border-radius: 50%;
      border: 1.5px solid #543415;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;

      &.checked {
        background: #543415;
        color: #ffffff;
        font-size: 11px;
        font-weight: bold;
      }
    }

    .agree-text {
      font-size: 12px;
      color: #6e5843;

      a {
        color: #c09159;
        text-decoration: underline;
      }
    }
  }

  /* Primary Button */
  .submit-btn {
    width: 100%;
    height: 48px;
    background: #543415;
    color: #ffffff;
    font-size: 16px;
    font-weight: 700;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(84, 52, 21, 0.25);

    &:disabled {
      opacity: 0.7;
    }
  }

  /* Secondary Link */
  .signin-link-container {
    text-align: center;
    margin-top: 16px;

    .signin-link {
      font-size: 14px;
      font-weight: 700;
      color: #543415;
      cursor: pointer;
      text-decoration: underline;
    }
  }

  /* WhatsApp Float */
  .whatsapp-float-btn {
    position: fixed;
    top: 60px;
    right: 16px;
    z-index: 100;
    background: #25d366;
    border-radius: 50%;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
  }
}
</style>
