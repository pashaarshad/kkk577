<template>
  <div class="recharge-detail-page">
    <!-- Header -->
    <header class="header">
      <van-icon name="arrow-left" size="20" color="#fff" @click="router.back()" class="back-btn" />
      <h3 class="title">Recharge</h3>
    </header>

    <!-- Main Card -->
    <main class="card-container" v-if="payInfo">
      <div class="channel-title">
        <img :src="payInfo.ico || defaultCoinIcon" alt="Coin" class="channel-icon">
        <span>{{ payInfo.name }}</span>
      </div>

      <div v-if="amount && Number(amount) > 0" style="text-align:center; margin: 4px 0 16px; font-size:16px; font-weight:700; color:#B83A2E;">
        Deposit Amount: ${{ amount }}
      </div>

      <!-- QR Code Container -->
      <div class="qr-box">
        <img :src="payInfo.ewm || generateQrUrl(payInfo.usercode || '0x4f85459F610376Ee6Ad77216785582c55817d5bc')" alt="QR Code" class="qr-img">
      </div>

      <div class="address-section">
        <span class="address-label">Address / UPI ID</span>
        <div class="address-bar">
          <input type="text" readonly :value="payInfo.usercode || '0x4f85459F610376Ee6Ad77216785582c55817d5bc'" class="address-input">
          <button class="copy-btn" @click="copyAddress">Copy</button>
        </div>
      </div>
    </main>

    <!-- Loading -->
    <div class="loading-box" v-else>
      <van-loading type="spinner" color="#00b983">Loading payment details...</van-loading>
    </div>

    <!-- Recharge Completed Action Button -->
    <div class="action-footer" v-if="payInfo">
      <div class="footer-notice">
        <van-icon name="clock-o" /> Funds will be credited within 24 hours after verification
      </div>
      <button class="completed-btn" @click="onComplete">Recharge completed</button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { showToast, showSuccessToast, showDialog } from 'vant'
import request from '@/services/index.js'

const router = useRouter()
const route = useRoute()

const payInfo = ref(null)
const payId = route.query.id
const amount = route.query.amount || 0
const defaultCoinIcon = 'https://cdn-icons-png.flaticon.com/512/6001/6001368.png'

const fetchPayDetail = async () => {
  try {
    const res = await request.get('/index/pay/get_pay_list')
    if (res && res.code === 0 && res.data) {
      const match = res.data.find(item => String(item.id) === String(payId))
      payInfo.value = match || res.data[0] || null
    }
  } catch (e) {
    console.error('Failed to load payment detail:', e)
  }
}

const generateQrUrl = (text) => {
  return `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(text)}`
}

const fallbackCopy = (text, successMsg) => {
  try {
    const textArea = document.createElement('textarea')
    textArea.value = text
    textArea.style.position = 'fixed'
    textArea.style.top = '0'
    textArea.style.left = '0'
    textArea.style.width = '2em'
    textArea.style.height = '2em'
    textArea.style.padding = '0'
    textArea.style.border = 'none'
    textArea.style.outline = 'none'
    textArea.style.boxShadow = 'none'
    textArea.style.background = 'transparent'
    textArea.setAttribute('readonly', '')
    document.body.appendChild(textArea)
    textArea.focus()
    textArea.select()
    textArea.setSelectionRange(0, 99999)
    const successful = document.execCommand('copy')
    document.body.removeChild(textArea)
    if (successful) {
      showSuccessToast(successMsg)
    } else {
      window.prompt('Copy address:', text)
    }
  } catch (err) {
    window.prompt('Copy address:', text)
  }
}

const copyAddress = () => {
  const text = payInfo.value?.usercode || '0x4f85459F610376Ee6Ad77216785582c55817d5bc'
  if (navigator.clipboard && window.isSecureContext) {
    navigator.clipboard.writeText(text).then(() => {
      showSuccessToast('Address copied to clipboard!')
    }).catch(() => {
      fallbackCopy(text, 'Address copied to clipboard!')
    })
  } else {
    fallbackCopy(text, 'Address copied to clipboard!')
  }
}

const onComplete = async () => {
  try {
    await request.post('/index/pay/submit_recharge', {
      pay_id: payInfo.value?.id || payId,
      amount: amount
    })
  } catch (e) {
    // Continue smoothly
  }

  showDialog({
    title: 'Recharge Submitted',
    message: 'Your recharge has been submitted successfully! The funds will be credited to your account within 24 hours after verification.',
    theme: 'round-button',
    confirmButtonText: 'Understood'
  }).then(() => {
    router.push('/mine')
  })
}

onMounted(() => {
  fetchPayDetail()
})
</script>

<style lang="less" scoped>
.recharge-detail-page {
  min-height: 100vh;
  background-color: #fff9f8;
  padding-bottom: 90px;

  .header {
    background-color: #B83A2E;
    color: #ffffff;
    display: flex;
    align-items: center;
    padding: 14px 16px;
    position: relative;

    .back-btn {
      cursor: pointer;
      z-index: 10;
    }

    .title {
      position: absolute;
      left: 0;
      right: 0;
      text-align: center;
      font-size: 16px;
      font-weight: 600;
      margin: 0;
    }
  }

  .card-container {
    margin: 16px;
    background: #ffffff;
    border: 1.5px solid #E86C3F;
    border-radius: 12px;
    padding: 24px 16px;
    text-align: center;

    .channel-title {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      font-size: 16px;
      font-weight: 700;
      color: #1f1a1a;
      margin-bottom: 20px;

      .channel-icon {
        width: 24px;
        height: 24px;
      }
    }

    .qr-box {
      margin: 0 auto 24px;
      width: 180px;
      height: 180px;
      padding: 10px;
      background: #ffffff;
      border: 1px solid #fdece8;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(184, 58, 46, 0.08);

      .qr-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
      }
    }

    .address-section {
      text-align: center;

      .address-label {
        font-size: 14px;
        font-weight: 700;
        color: #1f1a1a;
        display: block;
        margin-bottom: 10px;
      }

      .address-bar {
        display: flex;
        align-items: center;
        border: 1.5px solid #E86C3F;
        border-radius: 20px;
        padding: 4px 6px 4px 14px;
        background: #fff5f3;

        .address-input {
          flex: 1;
          border: none;
          background: transparent;
          font-size: 12px;
          color: #1f1a1a;
          font-family: monospace;
          outline: none;
        }

        .copy-btn {
          background: #1f1a1a;
          color: #ffffff;
          border: none;
          border-radius: 16px;
          padding: 6px 18px;
          font-size: 12px;
          font-weight: 600;
          cursor: pointer;

          &:active {
            opacity: 0.85;
          }
        }
      }
    }
  }

  .loading-box {
    display: flex;
    justify-content: center;
    padding: 40px 0;
  }

  .action-footer {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: calc(100% - 32px);
    max-width: 448px;

    .footer-notice {
      text-align: center;
      font-size: 13px;
      font-weight: 600;
      color: #B83A2E;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
    }

    .completed-btn {
      width: 100%;
      background-color: #B83A2E;
      color: #ffffff;
      border: none;
      border-radius: 8px;
      height: 48px;
      line-height: 48px;
      font-size: 16px;
      font-weight: 700;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(184, 58, 46, 0.3);

      &:active {
        background-color: #962d23;
      }
    }
  }
}
</style>
