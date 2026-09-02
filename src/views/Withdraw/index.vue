<!-- Withdraw Page matching reference mockup -->
<template>
  <div class="withdraw-page">
    <!-- Top Header -->
    <header class="page-header">
      <van-icon name="arrow-left" class="back-icon" @click="router.back()" />
      <h1 class="header-title">Withdraw</h1>
      <van-icon name="records" class="history-icon" @click="router.push('/withdrawRecord')" />
    </header>

    <div class="main-content">
      <!-- Card Container -->
      <div class="withdraw-card">
        <!-- Title & 24h Notice -->
        <div class="card-header">
          <h2 class="card-title">Withdrawal account</h2>
          <span class="notice-badge">24 hours withdrawal</span>
        </div>

        <!-- Total Balance Banner -->
        <div class="balance-banner">
          <div class="balance-label">Total balance</div>
          <div class="balance-amount">{{ userBalance }} USDT</div>
        </div>

        <!-- Withdrawal Method Selector -->
        <div class="method-section">
          <label class="section-label">Withdrawal method:</label>
          <div class="method-pills">
            <div 
              v-for="m in methods" 
              :key="m.id"
              class="method-pill"
              :class="{ 'pill-active': selectedMethod === m.id }"
              @click="selectMethod(m.id)"
            >
              <img :src="m.icon" :alt="m.label" class="method-icon" />
              <span class="method-name">{{ m.label }}</span>
            </div>
          </div>
        </div>

        <!-- Form Inputs -->
        <div class="form-section">
          <!-- Amount Input -->
          <div class="input-wrapper">
            <input 
              v-model="amount" 
              type="number" 
              step="any"
              :placeholder="`Quota ${quotaMin} - ${quotaMax}`" 
              class="styled-input"
            />
          </div>

          <!-- Withdrawal Address Input -->
          <div class="input-wrapper">
            <input 
              v-model="address" 
              type="text" 
              placeholder="Withdrawal Address" 
              class="styled-input"
            />
          </div>

          <!-- Fund / Transaction Password Input -->
          <div class="input-wrapper password-wrapper">
            <input 
              v-model="password" 
              :type="showPassword ? 'text' : 'password'" 
              placeholder="Security Password" 
              class="styled-input"
            />
            <van-icon 
              :name="showPassword ? 'eye-o' : 'closed-eye'" 
              class="eye-icon"
              @click="showPassword = !showPassword"
            />
          </div>

          <!-- Actually Received Summary -->
          <div class="receive-row">
            <span class="receive-label">Actually received</span>
            <span class="receive-value">{{ actuallyReceived }} USDT</span>
          </div>
        </div>
      </div>

      <!-- Action Button -->
      <div class="action-wrap">
        <button class="confirm-btn" :disabled="submitting" @click="handleConfirm">
          {{ submitting ? 'Submitting...' : 'Confirm' }}
        </button>
      </div>

      <!-- Bottom Notice -->
      <div class="bottom-policy-notice">
        <van-icon name="info-o" /> Withdrawals are processed and verified within 24 hours.
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { showToast, showDialog, showNotify } from 'vant'
import Request from '@/services/index.js'

const router = useRouter()

const userBalance = ref('0')
const amount = ref('')
const address = ref('')
const password = ref('')
const showPassword = ref(false)
const submitting = ref(false)

const quotaMin = ref('1.000')
const quotaMax = ref('100000.000')
const feeRate = ref(0.05) // 5% standard fee or from config

const methods = [
  { id: 'TRC20-USDT', label: 'TRC20-USDT', icon: 'https://cdn-icons-png.flaticon.com/512/6001/6001368.png' },
  { id: 'TRX', label: 'TRX', icon: 'https://cdn-icons-png.flaticon.com/512/12114/12114250.png' },
  { id: 'BEP20-USDT', label: 'BEP20-USDT', icon: 'https://cdn-icons-png.flaticon.com/512/6001/6001368.png' },
  { id: 'BEP20-USDC', label: 'BEP20-USDC', icon: 'https://cdn-icons-png.flaticon.com/512/14446/14446187.png' }
]
const selectedMethod = ref('TRC20-USDT')

const selectMethod = (id) => {
  selectedMethod.value = id
}

// Calculate actual received amount
const actuallyReceived = computed(() => {
  const val = parseFloat(amount.value)
  if (!val || isNaN(val) || val <= 0) return '0'
  const net = val - (val * feeRate.value)
  return net > 0 ? net.toFixed(3) : '0'
})

const fetchUserData = async () => {
  try {
    const res = await Request.get({ url: 'index/user/info' })
    if (res && res.code === 0 && res.info) {
      userBalance.value = parseFloat(res.info.balance || 0).toFixed(2)
    }
  } catch (e) {
    console.error('Failed to load user balance', e)
  }

  try {
    const bankRes = await Request.get({ url: 'index/ctrl/bankinfo' })
    if (bankRes && bankRes.code === 0 && bankRes.data && bankRes.data[0]) {
      const b = bankRes.data[0]
      if (b.cardnum) {
        address.value = b.cardnum
      }
      if (b.bankname) {
        selectedMethod.value = b.bankname
      }
    }
  } catch (e) {
    // optional
  }
}

const handleConfirm = async () => {
  if (!amount.value || parseFloat(amount.value) <= 0) {
    showNotify({ type: 'warning', message: 'Please enter a valid withdrawal amount' })
    return
  }
  if (parseFloat(amount.value) > parseFloat(userBalance.value)) {
    showNotify({ type: 'warning', message: 'Withdrawal amount exceeds available balance' })
    return
  }
  if (!address.value || address.value.trim() === '') {
    showNotify({ type: 'warning', message: 'Please enter your withdrawal wallet address' })
    return
  }
  if (!password.value) {
    showNotify({ type: 'warning', message: 'Please enter your security password' })
    return
  }

  submitting.value = true
  try {
    const param = new FormData()
    param.append('num', amount.value)
    param.append('paypassword', password.value)
    param.append('address', address.value.trim())
    param.append('USDT_code', address.value.trim())
    param.append('type', 'USDT')
    param.append('method', selectedMethod.value)

    const res = await Request.post({ url: 'index/ctrl/do_deposit', data: param })

    if (res && res.code === 0) {
      showDialog({
        title: 'Withdrawal Submitted',
        message: 'Your withdrawal request has been submitted successfully! You will receive your funds within 24 hours.',
        theme: 'round-button',
        confirmButtonText: 'Understood'
      }).then(() => {
        router.push('/withdrawRecord')
      })
    } else {
      showDialog({
        title: 'Notice',
        message: res?.info || 'Withdrawal submission failed. Please check your credentials.',
        theme: 'round-button',
        confirmButtonText: 'OK'
      })
    }
  } catch (e) {
    showNotify({ type: 'danger', message: e?.info || 'Network connection failed' })
  } finally {
    submitting.value = false
  }
}

onMounted(() => {
  fetchUserData()
})
</script>

<style lang="less" scoped>
.withdraw-page {
  min-height: 100vh;
  background-color: #f2f7f5;
  padding-bottom: 40px;
}

.page-header {
  background: #00b983;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 14px 16px;
  color: #ffffff;

  .back-icon, .history-icon {
    font-size: 20px;
    cursor: pointer;
  }

  .header-title {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
  }
}

.main-content {
  padding: 16px;
  max-width: 480px;
  margin: 0 auto;
}

.withdraw-card {
  background: #ffffff;
  border-radius: 12px;
  border: 1.5px solid #a8e5ce;
  padding: 18px 16px;
  box-shadow: 0 4px 16px rgba(0, 185, 131, 0.08);
  background-image: radial-gradient(#e6f8f1 1px, transparent 1px);
  background-size: 16px 16px;

  .card-header {
    margin-bottom: 14px;

    .card-title {
      font-size: 18px;
      font-weight: 700;
      color: #1a202c;
      margin: 0 0 4px 0;
    }

    .notice-badge {
      color: #ff4d4f;
      font-size: 13px;
      font-weight: 600;
    }
  }

  .balance-banner {
    background: #eef8f4;
    border-radius: 8px;
    padding: 14px 16px;
    margin-bottom: 18px;
    border: 1px solid #d5f0e4;

    .balance-label {
      font-size: 13px;
      color: #4a5568;
      font-weight: 500;
      margin-bottom: 4px;
    }

    .balance-amount {
      font-size: 22px;
      font-weight: 800;
      color: #00b983;
    }
  }

  .method-section {
    margin-bottom: 18px;

    .section-label {
      display: block;
      font-size: 13px;
      font-weight: 600;
      color: #2d3748;
      margin-bottom: 8px;
    }

    .method-pills {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 8px;

      @media (min-width: 380px) {
        grid-template-columns: repeat(4, 1fr);
      }

      .method-pill {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 7px 4px;
        background: #f7faf9;
        border: 1px solid #d2eade;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s ease;

        .method-icon {
          width: 18px;
          height: 18px;
          object-fit: contain;
        }

        .method-name {
          font-size: 11px;
          font-weight: 700;
          color: #4a5568;
          white-space: nowrap;
        }

        &.pill-active {
          background: #00b983;
          border-color: #00b983;

          .method-name {
            color: #ffffff;
          }
        }
      }
    }
  }

  .form-section {
    display: flex;
    flex-direction: column;
    gap: 12px;

    .input-wrapper {
      position: relative;

      .styled-input {
        width: 100%;
        box-sizing: border-box;
        height: 48px;
        background: #f0f6f4;
        border: 1px solid #d0e7dc;
        border-radius: 8px;
        padding: 0 14px;
        font-size: 14px;
        font-weight: 600;
        color: #1a202c;
        outline: none;
        transition: border 0.2s;

        &:focus {
          border-color: #00b983;
          background: #ffffff;
        }

        &::placeholder {
          color: #94a3b8;
          font-weight: 500;
        }
      }

      &.password-wrapper {
        .styled-input {
          padding-right: 44px;
        }

        .eye-icon {
          position: absolute;
          right: 14px;
          top: 50%;
          transform: translateY(-50%);
          font-size: 18px;
          color: #64748b;
          cursor: pointer;
        }
      }
    }

    .receive-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 6px 2px 0;
      font-size: 13px;

      .receive-label {
        color: #64748b;
        font-weight: 500;
      }

      .receive-value {
        color: #1e293b;
        font-weight: 700;
      }
    }
  }
}

.action-wrap {
  margin-top: 24px;

  .confirm-btn {
    width: 100%;
    height: 50px;
    background: #00b983;
    border: none;
    border-radius: 10px;
    color: #ffffff;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(0, 185, 131, 0.3);
    transition: transform 0.1s ease, background 0.2s ease;

    &:active {
      transform: scale(0.98);
      background: #00966a;
    }

    &:disabled {
      background: #93d6c1;
      cursor: not-allowed;
    }
  }
}

.bottom-policy-notice {
  text-align: center;
  font-size: 12px;
  color: #64748b;
  margin-top: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 4px;
}
</style>
