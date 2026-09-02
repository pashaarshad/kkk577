<template>
  <div class="select-currency-page">
    <!-- Header -->
    <header class="header">
      <van-icon name="arrow-left" size="20" color="#fff" @click="router.back()" class="back-btn" />
      <h3 class="title">Select the recharge currency</h3>
    </header>

    <!-- Currency List Container -->
    <main class="currency-container" v-if="payList.length > 0">
      <div v-for="item in payList" :key="item.id" class="currency-item" @click="onSelectCurrency(item)">
        <div class="item-left">
          <img :src="item.ico || defaultCoinIcon" alt="Currency" class="coin-icon">
          <span class="coin-name">{{ item.name }}</span>
        </div>
        <div class="item-right">
          <van-icon name="arrow" color="#86909c" size="16" />
        </div>
      </div>
    </main>

    <!-- Loading -->
    <div class="loading-box" v-else>
      <van-loading type="spinner" color="#00b983">Loading payment channels...</van-loading>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import request from '@/services/index.js'

const router = useRouter()
const route = useRoute()
const payList = ref([])
const amount = route.query.amount || 0
const vipId = route.query.vip_id || 0

const defaultCoinIcon = 'https://cdn-icons-png.flaticon.com/512/6001/6001368.png'

const fetchPayList = async () => {
  try {
    const res = await request.get('/index/pay/get_pay_list')
    if (res && res.code === 0 && res.data && res.data.length > 0) {
      payList.value = res.data
    } else {
      // Default fallback channels
      payList.value = [
        { id: 1, name: 'TRC20-USDT', usercode: 'TXYZ...1234', ewm: '' },
        { id: 2, name: 'TRX', usercode: 'TXYZ...1234', ewm: '' },
        { id: 3, name: 'BEP20-USDT', usercode: '0x123...4567', ewm: '' },
        { id: 4, name: 'BNB', usercode: '0x123...4567', ewm: '' },
        { id: 5, name: 'BEP20-USDC', usercode: '0x123...4567', ewm: '' },
        { id: 6, name: 'POLYGON-USDT', usercode: '0x123...4567', ewm: '' },
        { id: 7, name: 'ETH-USDT', usercode: '0x123...4567', ewm: '' },
        { id: 8, name: 'POLYGON-USDC', usercode: '0x4f85459F610376Ee6Ad77216785582c55817d5bc', ewm: '' },
        { id: 9, name: 'UPI / Bank Transfer', usercode: 'merchant@upi', ewm: '' }
      ]
    }
  } catch (e) {
    payList.value = [
      { id: 1, name: 'TRC20-USDT', usercode: 'TXYZ...1234' },
      { id: 2, name: 'BEP20-USDT', usercode: '0x123...4567' },
      { id: 8, name: 'POLYGON-USDC', usercode: '0x4f85459F610376Ee6Ad77216785582c55817d5bc' },
      { id: 9, name: 'UPI', usercode: 'merchant@upi' }
    ]
  }
}

const onSelectCurrency = (item) => {
  router.push({
    path: '/recharge-detail',
    query: {
      id: item.id,
      amount: amount,
      vip_id: vipId
    }
  })
}

onMounted(() => {
  fetchPayList()
})
</script>

<style lang="less" scoped>
.select-currency-page {
  min-height: 100vh;
  background-color: #f5faf8;

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

  .currency-container {
    margin: 16px;
    background: #ffffff;
    border: 1.5px solid #00b983;
    border-radius: 12px;
    padding: 6px 12px;

    .currency-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 14px 8px;
      border-bottom: 1px dashed #e2f4ed;
      cursor: pointer;

      &:last-child {
        border-bottom: none;
      }

      .item-left {
        display: flex;
        align-items: center;
        gap: 12px;

        .coin-icon {
          width: 28px;
          height: 28px;
          object-fit: contain;
        }

        .coin-name {
          font-size: 14px;
          font-weight: 700;
          color: #1d2129;
        }
      }
    }
  }

  .loading-box {
    display: flex;
    justify-content: center;
    padding: 40px 0;
  }
}
</style>
