<template>
  <div class="vip-container">
    <!-- Header -->
    <header class="vip-header">
      <div class="header-left">
        <span class="app-title">Good</span>
      </div>
      <div class="header-right" @click="router.push('/rechargeRecord')">
        <span class="upgrade-log">Upgrade log</span>
      </div>
    </header>

    <!-- VIP List -->
    <main class="vip-list" v-if="levelList.length > 0">
      <div v-for="(item, idx) in levelList" :key="item.id || idx" class="vip-card">
        <div class="card-top">
          <div class="card-left">
            <img :src="item.pic || defaultIcons[idx % defaultIcons.length]" alt="Grade" class="grade-icon">
            <div class="grade-info">
              <span class="grade-label">Grade</span>
              <h4 class="grade-name">{{ item.name || 'VIP' + item.level }} <span class="fuel-icon">⛽</span></h4>
            </div>
          </div>
          <div class="card-right">
            <button class="join-btn" @click="onJoin(item)">Join now</button>
          </div>
        </div>

        <div class="card-body">
          <div class="info-col">
            <span class="info-label">Daily tasks</span>
            <span class="info-val">{{ item.order_num || 0 }}</span>
          </div>
          <div class="info-col">
            <span class="info-label">Daily profit</span>
            <span class="info-val">${{ Number(item.daily_profit || item.num * item.bili || 0).toFixed(2) }}</span>
          </div>
          <div class="info-col">
            <span class="info-label">Price</span>
            <span class="info-val">${{ Number(item.num || 0).toFixed(2) }}</span>
          </div>
        </div>
      </div>
    </main>

    <!-- Skeleton Loading -->
    <div class="vip-loading" v-else>
      <van-loading type="spinner" color="#00b983">Loading VIP Levels...</van-loading>
    </div>

    <!-- Confirm Dialog Modal -->
    <van-popup v-model:show="showModal" round :style="{ width: '85%', padding: '24px 16px', textAlign: 'center' }">
      <div class="modal-content">
        <p class="modal-text">
          The recharge balance is automatically unlocked Need to recharge ${{ Number(selectedItem?.num || 0).toFixed(2) }}
        </p>
        <button class="confirm-red-btn" @click="onConfirm">Confirm</button>
      </div>
    </van-popup>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { showToast } from 'vant'
import request from '@/services/index.js'

const router = useRouter()
const levelList = ref([])
const showModal = ref(false)
const selectedItem = ref(null)

const defaultIcons = [
  'https://cdn-icons-png.flaticon.com/512/2936/2936886.png',
  'https://cdn-icons-png.flaticon.com/512/3135/3135715.png',
  'https://cdn-icons-png.flaticon.com/512/1041/1041883.png',
  'https://cdn-icons-png.flaticon.com/512/3594/3594363.png'
]

const fetchLevels = async () => {
  try {
    const res = await request.get('/index/pay/get_level_list')
    if (res && res.code === 0 && res.data) {
      levelList.value = res.data
    } else {
      // Fallback VIP levels
      levelList.value = [
        { id: 1, name: 'jiqirenbot', level: 0, order_num: 0, daily_profit: 0, num: 500 },
        { id: 2, name: 'VIP2', level: 2, order_num: 3, daily_profit: 33, num: 30 },
        { id: 3, name: 'STARLINK10MB', level: 3, order_num: 30, daily_profit: 3, num: 100 },
        { id: 4, name: '初级任务', level: 4, order_num: 2, daily_profit: 4, num: 9 },
        { id: 5, name: '高端商品任务', level: 5, order_num: 6, daily_profit: 66, num: 600 },
        { id: 6, name: '大宗商品任务', level: 6, order_num: 10, daily_profit: 40, num: 1500 }
      ]
    }
  } catch (e) {
    levelList.value = [
      { id: 1, name: 'jiqirenbot', level: 0, order_num: 0, daily_profit: 0, num: 500 },
      { id: 2, name: 'VIP2', level: 2, order_num: 3, daily_profit: 33, num: 30 },
      { id: 3, name: 'STARLINK10MB', level: 3, order_num: 30, daily_profit: 3, num: 100 }
    ]
  }
}

const onJoin = (item) => {
  selectedItem.value = item
  showModal.value = true
}

const onConfirm = () => {
  showModal.value = false
  const price = selectedItem.value ? selectedItem.value.num : 0
  router.push({ path: '/select-currency', query: { amount: price, vip_id: selectedItem.value?.id } })
}

onMounted(() => {
  fetchLevels()
})
</script>

<style lang="less" scoped>
.vip-container {
  min-height: 100vh;
  background-color: #f5faf8;
  padding-bottom: 70px;

  .vip-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 16px;
    background-color: #00b983;
    color: #ffffff;

    .app-title {
      font-size: 18px;
      font-weight: 700;
    }

    .upgrade-log {
      font-size: 13px;
      color: #e8fef5;
      text-decoration: underline;
      cursor: pointer;
    }
  }

  .vip-list {
    padding: 12px 16px;
    display: flex;
    flex-direction: column;
    gap: 12px;

    .vip-card {
      background: #ffffff;
      border: 1.5px solid #00b983;
      border-radius: 12px;
      padding: 12px 14px;
      box-shadow: 0 2px 6px rgba(0, 185, 131, 0.08);

      .card-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;

        .card-left {
          display: flex;
          align-items: center;
          gap: 10px;

          .grade-icon {
            width: 44px;
            height: 44px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e5f7f2;
          }

          .grade-info {
            .grade-label {
              font-size: 11px;
              color: #86909c;
              display: block;
            }

            .grade-name {
              font-size: 15px;
              font-weight: 700;
              color: #1d2129;
              margin: 0;

              .fuel-icon {
                font-size: 12px;
              }
            }
          }
        }

        .join-btn {
          background-color: #00b983;
          color: #ffffff;
          border: none;
          border-radius: 20px;
          padding: 6px 16px;
          font-size: 13px;
          font-weight: 600;
          cursor: pointer;
          transition: background 0.2s;

          &:active {
            background-color: #00966b;
          }
        }
      }

      .card-body {
        display: flex;
        justify-content: space-between;
        background: #f7fcf9;
        border-radius: 8px;
        padding: 8px 12px;

        .info-col {
          display: flex;
          flex-direction: column;

          .info-label {
            font-size: 11px;
            color: #4e5969;
          }

          .info-val {
            font-size: 13px;
            font-weight: 700;
            color: #1d2129;
            margin-top: 2px;
          }
        }
      }
    }
  }

  .vip-loading {
    display: flex;
    justify-content: center;
    padding: 40px 0;
  }
}

.modal-content {
  .modal-text {
    font-size: 15px;
    color: #1d2129;
    line-height: 1.5;
    margin-bottom: 24px;
    font-weight: 500;
  }

  .confirm-red-btn {
    width: 100%;
    background: #ff3b30;
    color: #ffffff;
    border: none;
    border-radius: 24px;
    height: 44px;
    line-height: 44px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(255, 59, 48, 0.3);

    &:active {
      background: #d63027;
    }
  }
}
</style>
