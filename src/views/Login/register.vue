<!-- Register / Sign Up -->
<template>
  <div class="register-page-container">
    <!-- Top Bar with Logo & Language Switcher -->
    <div class="top-header">
      <div class="brand-logo-row">
        <img src="../../assets/img/main/official_logo.png" alt="Logo" class="brand-logo-img">
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
              <svg v-if="!showPwd" viewBox="0 0 24 24" width="20" height="20"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" fill="#B83A2E"/></svg>
              <svg v-else viewBox="0 0 24 24" width="20" height="20"><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.44-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.17c0-1.66-1.34-3-3-3l-.17.02z" fill="#B83A2E"/></svg>
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
        <button type="submit" class="submit-btn" :disabled="loading">
          {{ loading ? 'Creating Account...' : 'Sign Up' }}
        </button>

        <!-- Secondary Sign In Link -->
        <div class="signup-link-container">
          <span class="signup-link" @click="goLogin">Already have an account? Sign In</span>
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

// Extract referral/invite code from route query or raw URL
const extractInviteCode = () => {
  if (route.query && (route.query.invite_code || route.query.code)) {
    return String(route.query.invite_code || route.query.code).trim()
  }
  const href = window.location.href
  const m = href.match(/[?&](invite_code|code)=([^&#]+)/i)
  if (m && m[2]) {
    return decodeURIComponent(m[2]).trim()
  }
  return ''
}

onMounted(() => {
  const code = extractInviteCode()
  if (code) {
    invite_code.value = code
  }
})
const tel = ref('')
const pwd = ref('')
const confirm_pwd = ref('')
const deposit_pwd = ref('')
const showPwd = ref(false)
const agreed = ref(true)
const loading = ref(false)

const currentLangName = ref('English')

const toggleLang = () => {
  showSuccessToast('Language selected')
}

const onSubmit = async () => {
  if (!agreed.value) {
    showFailToast('Please agree to terms')
    return
  }
  if (pwd.value !== confirm_pwd.value) {
    showFailToast('Passwords do not match')
    return
  }

  loading.value = true
  try {
    const res = await Request.post({
      url: 'index/user/do_register',
      data: {
        invite_code: invite_code.value,
        tel: tel.value,
        pwd: pwd.value,
        deposit_pwd: deposit_pwd.value
      }
    })

    if (res && res.code === 0) {
      showSuccessToast('Account created successfully!')
      setTimeout(() => {
        router.push('/login')
      }, 1000)
    } else {
      showFailToast(res.info || 'Registration failed')
    }
  } catch (e) {
    showFailToast('Network error')
  } finally {
    loading.value = false
  }
}

const goLogin = () => {
  router.push('/login')
}
</script>

<style lang="less" scoped>
.register-page-container {
  min-height: 100vh;
  max-width: 480px;
  margin: 0 auto;
  position: relative;
  background: #fff9f8;
  padding: 16px 20px 40px;
  box-sizing: border-box;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;

  .top-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;

    .brand-logo-row {
      display: flex;
      align-items: center;
      gap: 8px;

      .brand-logo-img {
        width: 32px;
        height: 32px;
        object-fit: contain;
      }

      .brand-name {
        font-size: 17px;
        font-weight: 800;
        color: #1f1a1a;
      }
    }

    .lang-selector {
      display: flex;
      align-items: center;
      gap: 4px;
      padding: 6px 12px;
      background: #ffffff;
      border: 1px solid #fdece8;
      border-radius: 20px;
      font-size: 12.5px;
      color: #1f1a1a;
      cursor: pointer;
      box-shadow: 0 2px 6px rgba(184, 58, 46, 0.06);
    }
  }

  .platform-title {
    font-size: 20px;
    font-weight: 800;
    color: #1f1a1a;
    text-align: center;
    margin: 10px 0 24px;
  }

  .auth-card {
    background: #ffffff;
    border: 1.5px solid #E86C3F;
    border-radius: 16px;
    padding: 28px 22px 24px;
    box-shadow: 0 4px 16px rgba(184, 58, 46, 0.12);
    box-sizing: border-box;

    .card-header-title {
      font-size: 18px;
      font-weight: 800;
      color: #B83A2E;
      text-align: center;
      margin-bottom: 26px;
    }

    .form-group {
      margin-bottom: 20px;

      .field-label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #1f1a1a;
        margin-bottom: 6px;
      }

      .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;

        .underline-input {
          width: 100%;
          border: none;
          border-bottom: 2px solid #fdece8;
          padding: 10px 0;
          font-size: 15px;
          color: #1f1a1a;
          background: transparent;
          outline: none;
          transition: border-color 0.2s;

          &::placeholder {
            color: #86909c;
            font-size: 13.5px;
          }

          &:focus {
            border-bottom-color: #B83A2E;
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

    .agree-row {
      display: flex;
      align-items: center;
      gap: 9px;
      margin: 22px 0 26px;
      cursor: pointer;

      .custom-checkbox {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 1.5px solid #B83A2E;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;

        &.checked {
          background: #B83A2E;
          color: #ffffff;
          font-size: 11px;
          font-weight: bold;
        }
      }

      .agree-text {
        font-size: 12px;
        color: #4e5969;

        a {
          color: #E86C3F;
          text-decoration: underline;
        }
      }
    }

    .submit-btn {
      width: 100%;
      height: 48px;
      background: linear-gradient(135deg, #B83A2E, #E86C3F);
      color: #ffffff;
      font-size: 16px;
      font-weight: 700;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      box-shadow: 0 4px 14px rgba(184, 58, 46, 0.25);
      transition: transform 0.1s;

      &:active {
        transform: scale(0.98);
      }

      &:disabled {
        opacity: 0.7;
      }
    }

    .signup-link-container {
      text-align: center;
      margin-top: 20px;

      .signup-link {
        font-size: 14px;
        font-weight: 700;
        color: #B83A2E;
        cursor: pointer;
        text-decoration: underline;
      }
    }
  }

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
