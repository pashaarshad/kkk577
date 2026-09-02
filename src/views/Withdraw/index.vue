<!-- Withdraw Page matching reference mockup with Red Theme and Address Popup -->
<template>
  <div class="withdraw-page">
    <!-- Top Header in Brand Red -->
    <header class="page-header">
      <van-icon name="arrow-left" class="back-icon" @click="router.back()" />
      <h1 class="header-title">Withdraw</h1>
      <van-icon name="records" class="history-icon" @click="router.push('/withdrawRecord')" />
    </header>

    <div class="main-content">
      <!-- Card Container in Red Theme -->
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
          <div class="method-title-row">
            <label class="section-label">Withdrawal method:</label>
            <span class="tap-hint" @click="openAddressModal">Tap to set address &gt;</span>
          </div>
          <div class="method-pills">
            <div 
              v-for="m in methods" 
              :key="m.id"
              class="method-pill"
              :class="{ 'pill-active': selectedMethod === m.id }"
              @click="handleMethodClick(m.id)"
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

          <!-- Withdrawal Address Display / Input -->
          <div class="input-wrapper address-input-wrap">
            <input 
              v-model="address" 
              type="text" 
              placeholder="Withdrawal Receiver Address" 
              class="styled-input"
            />
            <button class="paste-btn" type="button" @click="openAddressModal">Set</button>
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

      <!-- Action Button in Brand Red -->
      <div class="action-wrap">
        <button class="confirm-btn" :disabled="submitting" @click="handleConfirm">
          {{ submitting ? 'Submitting...' : 'Confirm' }}
        </button>
      </div>

      <!-- Bottom Notice -->
      <div class="bottom-policy-notice">
        <van-icon name="info-o" /> Withdrawals will be verified and received within 24 hours.
      </div>
    </div>

    <!-- Receiver Address Popup Modal -->
    <van-popup
      v-model:show="showAddressPopup"
      position="bottom"
      round
      :style="{ padding: '24px 20px', maxHeight: '70%' }"
    >
      <div class="address-popup-content">
        <div class="popup-top">
          <h3 class="popup-title">Set {{ selectedMethod }} Address</h3>
          <van-icon name="cross" class="close-icon" @click="showAddressPopup = false" />
        </div>
        <p class="popup-subtitle">
          Please enter your unique <strong>{{ selectedMethod }}</strong> receiver address for withdrawal payout:
        </p>
        <div class="popup-input-box">
          <input 
            v-model="tempAddress" 
            type="text" 
            :placeholder="`Enter or paste your ${selectedMethod} address`" 
            class="popup-input"
          />
        </div>
        <div class="popup-actions">
          <button class="popup-confirm-btn" @click="saveAddress">
            Confirm & Save Address
          </button>
        </div>
      </div>
    </van-popup>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { showToast, showDialog, showNotify, showSuccessToast } from 'vant'
import Request from '@/services/index.js'

const router = useRouter()

const userBalance = ref('0')
const amount = ref('')
const address = ref('')
const tempAddress = ref('')
const password = ref('')
const showPassword = ref(false)
const submitting = ref(false)
const showAddressPopup = ref(false)

const quotaMin = ref('1.000')
const quotaMax = ref('100000.000')
const feeRate = ref(0.05) // 5% fee rate

const methods = [
  { id: 'TRC20-USDT', label: 'TRC20-USDT', icon: 'https://cdn-icons-png.flaticon.com/512/6001/6001368.png' },
  { id: 'TRX', label: 'TRX', icon: 'https://cdn-icons-png.flaticon.com/512/12114/12114250.png' },
  { id: 'BEP20-USDT', label: 'BEP20-USDT', icon: 'https://cdn-icons-png.flaticon.com/512/6001/6001368.png' },
  { id: 'BEP20-USDC', label: 'BEP20-USDC', icon: 'https://cdn-icons-png.flaticon.com/512/14446/14446187.png' }
]
const selectedMethod = ref('TRC20-USDT')

const handleMethodClick = (id) => {
  selectedMethod.value = id
  tempAddress.value = address.value || ''
  showAddressPopup.value = true
}

const openAddressModal = () => {
  tempAddress.value = address.value || ''
  showAddressPopup.value = true
}

const saveAddress = () => {
  if (!tempAddress.value || tempAddress.value.trim() === '') {
    showToast('Please enter an address')
    return
  }
  address.value = tempAddress.value.trim()
  showAddressPopup.value = false
  showSuccessToast(`${selectedMethod.value} address saved!`)
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
        tempAddress.value = b.cardnum
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
    openAddressModal()
    showNotify({ type: 'warning', message: 'Please set your withdrawal receiver address' })
    return
  }
  if (!password.value) {
    showNotify({ type: 'warning', message: 'Please enter your security password' })
    return
  }

  submitting.value = true
  try {
    const res = await Request.post({ 
      url: 'index/ctrl/do_deposit', 
      data: {
        num: amount.value,
        paypassword: password.value,
        address: address.value.trim(),
        USDT_code: address.value.trim(),
        type: 'USDT',
        method: selectedMethod.value
      }
    })

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
    const errorMsg = e?.info || e?.message || (typeof e === 'string' ? e : 'Withdrawal submission failed')
    showNotify({ type: 'danger', message: errorMsg })
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
  background-color: #fff9f8;
  padding-bottom: 40px;
}

.page-header {
  background: #B83A2E;
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
    font-weight: 700;
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
  border: 1.5px solid #f2c7c2;
  padding: 18px 16px;
  box-shadow: 0 4px 16px rgba(184, 58, 46, 0.08);

  .card-header {
    margin-bottom: 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;

    .card-title {
      font-size: 18px;
      font-weight: 700;
      color: #1a202c;
      margin: 0;
    }

    .notice-badge {
      color: #B83A2E;
      font-size: 13px;
      font-weight: 600;
    }
  }

  .balance-banner {
    background: #fdf3f2;
    border-radius: 8px;
    padding: 14px 16px;
    margin-bottom: 18px;
    border: 1px solid #f8dad7;

    .balance-label {
      font-size: 13px;
      color: #64748b;
      font-weight: 500;
      margin-bottom: 4px;
    }

    .balance-amount {
      font-size: 22px;
      font-weight: 800;
      color: #B83A2E;
    }
  }

  .method-section {
    margin-bottom: 18px;

    .method-title-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 8px;

      .section-label {
        font-size: 13px;
        font-weight: 600;
        color: #2d3748;
      }

      .tap-hint {
        font-size: 11px;
        color: #B83A2E;
        font-weight: 600;
        cursor: pointer;
      }
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
        padding: 8px 4px;
        background: #fef8f7;
        border: 1.5px solid #f1dedc;
        border-radius: 8px;
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
          background: #B83A2E;
          border-color: #B83A2E;

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
        background: #faf4f3;
        border: 1px solid #ebd3d0;
        border-radius: 8px;
        padding: 0 14px;
        font-size: 14px;
        font-weight: 600;
        color: #1a202c;
        outline: none;
        transition: border 0.2s;

        &:focus {
          border-color: #B83A2E;
          background: #ffffff;
        }

        &::placeholder {
          color: #94a3b8;
          font-weight: 500;
        }
      }

      &.address-input-wrap {
        .styled-input {
          padding-right: 60px;
        }

        .paste-btn {
          position: absolute;
          right: 8px;
          top: 50%;
          transform: translateY(-50%);
          background: #B83A2E;
          color: #ffffff;
          border: none;
          padding: 5px 12px;
          border-radius: 6px;
          font-size: 12px;
          font-weight: 700;
          cursor: pointer;
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
        color: #B83A2E;
        font-weight: 800;
      }
    }
  }
}

.action-wrap {
  margin-top: 24px;

  .confirm-btn {
    width: 100%;
    height: 50px;
    background: linear-gradient(135deg, #B83A2E 0%, #E86C3F 100%);
    border: none;
    border-radius: 10px;
    color: #ffffff;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(184, 58, 46, 0.3);
    transition: transform 0.1s ease;

    &:active {
      transform: scale(0.98);
    }

    &:disabled {
      background: #e2a6a0;
      cursor: not-allowed;
    }
  }
}

.bottom-policy-notice {
  text-align: center;
  font-size: 12px;
  color: #8c7370;
  margin-top: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 4px;
}

.address-popup-content {
  .popup-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;

    .popup-title {
      font-size: 18px;
      font-weight: 700;
      color: #1a202c;
      margin: 0;
    }

    .close-icon {
      font-size: 20px;
      color: #64748b;
      cursor: pointer;
    }
  }

  .popup-subtitle {
    font-size: 13px;
    color: #4a5568;
    line-height: 1.5;
    margin-bottom: 16px;
  }

  .popup-input-box {
    margin-bottom: 20px;

    .popup-input {
      width: 100%;
      box-sizing: border-box;
      height: 48px;
      background: #f8f1f0;
      border: 1.5px solid #eecfcc;
      border-radius: 8px;
      padding: 0 14px;
      font-size: 14px;
      font-weight: 600;
      color: #1a202c;
      outline: none;

      &:focus {
        border-color: #B83A2E;
        background: #ffffff;
      }
    }
  }

  .popup-actions {
    .popup-confirm-btn {
      width: 100%;
      height: 48px;
      background: #B83A2E;
      color: #ffffff;
      border: none;
      border-radius: 8px;
      font-size: 15px;
      font-weight: 700;
      cursor: pointer;

      &:active {
        background: #9a2b20;
      }
    }
  }
}
</style>
