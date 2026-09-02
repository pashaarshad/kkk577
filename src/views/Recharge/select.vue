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
          <img :src="getChannelIcon(item)" alt="Currency" class="coin-icon">
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

const iconMap = {
  'TRC20-USDT': 'https://cdn-icons-png.flaticon.com/512/12114/12114233.png',
  'TRX': 'https://cdn-icons-png.flaticon.com/512/12114/12114251.png',
  'BEP20-USDT': 'https://cdn-icons-png.flaticon.com/512/12114/12114233.png',
  'BNB': 'https://cdn-icons-png.flaticon.com/512/12114/12114214.png',
  'BEP20-USDC': 'https://cdn-icons-png.flaticon.com/512/12114/12114241.png',
  'POLYGON-USDT': 'https://cdn-icons-png.flaticon.com/512/12114/12114233.png',
  'ETH-USDT': 'https://cdn-icons-png.flaticon.com/512/12114/12114233.png',
  'POLYGON-USDC': 'https://cdn-icons-png.flaticon.com/512/12114/12114241.png',
  'ETH-USDC': 'https://cdn-icons-png.flaticon.com/512/12114/12114241.png',
  'ETH': 'https://cdn-icons-png.flaticon.com/512/12114/12114218.png',
  'POLYGON': 'https://cdn-icons-png.flaticon.com/512/12114/12114230.png',
  'ETH-PYUSD': 'https://cdn-icons-png.flaticon.com/512/888/888870.png',
  'PHP': 'https://cdn-icons-png.flaticon.com/512/2489/2489756.png',
  'UPI': 'https://cdn-icons-png.flaticon.com/512/10112/10112502.png'
}

const getChannelIcon = (item) => {
  if (item.ico && item.ico.trim() !== '') return item.ico
  const key = Object.keys(iconMap).find(k => item.name && item.name.toUpperCase().includes(k))
  return key ? iconMap[key] : defaultCoinIcon
}

const fetchPayList = async () => {
  try {
    const res = await request.get('/index/pay/get_pay_list')
    if (res && res.code === 0 && res.data && res.data.length > 0) {
      payList.value = res.data.sort((a, b) => (b.sort || 0) - (a.sort || 0))
    } else {
      // Default fallback channels matching media_1788351479051.png
      payList.value = [
        { id: 1, name: 'TRC20-USDT', sort: 13 },
        { id: 2, name: 'TRX', sort: 12 },
        { id: 3, name: 'BEP20-USDT', sort: 11 },
        { id: 4, name: 'BNB', sort: 10 },
        { id: 5, name: 'BEP20-USDC', sort: 9 },
        { id: 6, name: 'POLYGON-USDT', sort: 8 },
        { id: 7, name: 'ETH-USDT', sort: 7 },
        { id: 8, name: 'POLYGON-USDC', sort: 6 },
        { id: 9, name: 'ETH-USDC', sort: 5 },
        { id: 10, name: 'ETH', sort: 4 },
        { id: 11, name: 'POLYGON', sort: 3 },
        { id: 12, name: 'ETH-PYUSD', sort: 2 },
        { id: 13, name: 'PHP', sort: 1 },
        { id: 14, name: 'UPI', sort: 0 }
      ]
    }
  } catch (e) {
    payList.value = [
      { id: 1, name: 'TRC20-USDT', sort: 13 },
      { id: 2, name: 'TRX', sort: 12 },
      { id: 3, name: 'BEP20-USDT', sort: 11 },
      { id: 4, name: 'BNB', sort: 10 },
      { id: 5, name: 'BEP20-USDC', sort: 9 },
      { id: 6, name: 'POLYGON-USDT', sort: 8 },
      { id: 7, name: 'ETH-USDT', sort: 7 },
      { id: 8, name: 'POLYGON-USDC', sort: 6 },
      { id: 9, name: 'ETH-USDC', sort: 5 },
      { id: 10, name: 'ETH', sort: 4 },
      { id: 11, name: 'POLYGON', sort: 3 },
      { id: 12, name: 'ETH-PYUSD', sort: 2 },
      { id: 13, name: 'PHP', sort: 1 },
      { id: 14, name: 'UPI', sort: 0 }
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
  background-color: #fff9f8;
  padding-bottom: 20px;

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

  .currency-container {
    margin: 16px;
    background: #ffffff;
    border: 1.5px solid #E86C3F;
    border-radius: 12px;
    padding: 6px 12px;
    box-shadow: 0 2px 8px rgba(184, 58, 46, 0.08);

    .currency-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 14px 8px;
      border-bottom: 1px dashed #fdece8;
      cursor: pointer;
      transition: background 0.15s;

      &:hover, &:active {
        background-color: #fdf5f3;
      }

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
