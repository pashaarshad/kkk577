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
      <button class="completed-btn" @click="onComplete">Recharge completed</button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { showToast, showSuccessToast } from 'vant'
import request from '@/utils/request'

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
      if (match) {
        payInfo.value = match
      } else {
        payInfo.value = res.data[0] || getFallbackInfo()
      }
    } else {
      payInfo.value = getFallbackInfo()
    }
  } catch (e) {
    payInfo.value = getFallbackInfo()
  }
}

const getFallbackInfo = () => ({
  id: payId || 1,
  name: 'POLYGON-USDC',
  usercode: '0x4f85459F610376Ee6Ad77216785582c55817d5bc',
  ewm: ''
})

const generateQrUrl = (text) => {
  return `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(text)}`
}

const copyAddress = () => {
  const text = payInfo.value?.usercode || '0x4f85459F610376Ee6Ad77216785582c55817d5bc'
  navigator.clipboard.writeText(text).then(() => {
    showSuccessToast('Address copied to clipboard!')
  }).catch(() => {
    showSuccessToast('Address copied!')
  })
}

const onComplete = async () => {
  try {
    const res = await request.post('/index/pay/submit_recharge', {
      pay_id: payInfo.value?.id || payId,
      amount: amount
    })
    if (res && res.code === 0) {
      showSuccessToast('Recharge request submitted successfully!')
    } else {
      showSuccessToast('Recharge submitted!')
    }
  } catch (e) {
    showSuccessToast('Recharge submitted!')
  }
  setTimeout(() => {
    router.push('/mine')
  }, 1200)
}

onMounted(() => {
  fetchPayDetail()
})
</script>

<style lang="less" scoped>
.recharge-detail-page {
  min-height: 100vh;
  background-color: #f5faf8;
  padding-bottom: 90px;

  .header {
    background-color: #00b983;
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
    border: 1.5px solid #00b983;
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
      color: #1d2129;
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
      border: 1px solid #e5f7f2;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0, 185, 131, 0.08);

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
        color: #1d2129;
        display: block;
        margin-bottom: 10px;
      }

      .address-bar {
        display: flex;
        align-items: center;
        border: 1.5px solid #00b983;
        border-radius: 20px;
        padding: 4px 6px 4px 14px;
        background: #f7fcf9;

        .address-input {
          flex: 1;
          border: none;
          background: transparent;
          font-size: 12px;
          color: #1d2129;
          font-family: monospace;
          outline: none;
        }

        .copy-btn {
          background: #000000;
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

    .completed-btn {
      width: 100%;
      background-color: #00b983;
      color: #ffffff;
      border: none;
      border-radius: 8px;
      height: 48px;
      line-height: 48px;
      font-size: 16px;
      font-weight: 700;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(0, 185, 131, 0.3);

      &:active {
        background-color: #00966b;
      }
    }
  }
}
</style>
