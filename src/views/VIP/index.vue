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
    <van-popup v-model:show="showModal" round :style="{ width: '80%', maxWidth: '300px', padding: '20px 16px', textAlign: 'center' }">
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
    }
  } catch (e) {
    console.error('Failed to load VIP levels:', e)
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
  background-color: #fff9f8;
  padding-bottom: 70px;

  .vip-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 16px;
    background-color: #B83A2E;
    color: #ffffff;

    .app-title {
      font-size: 18px;
      font-weight: 700;
    }

    .upgrade-log {
      font-size: 13px;
      color: #ffe6e0;
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
      border: 1.5px solid #E86C3F;
      border-radius: 12px;
      padding: 12px 14px;
      box-shadow: 0 2px 6px rgba(184, 58, 46, 0.08);

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
            border: 1px solid #fdece8;
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
              color: #1f1a1a;
              margin: 0;

              .fuel-icon {
                font-size: 12px;
              }
            }
          }
        }

        .join-btn {
          background-color: #B83A2E;
          color: #ffffff;
          border: none;
          border-radius: 20px;
          padding: 6px 16px;
          font-size: 13px;
          font-weight: 600;
          cursor: pointer;
          transition: background 0.2s;

          &:active {
            background-color: #962d23;
          }
        }
      }

      .card-body {
        display: flex;
        justify-content: space-between;
        background: #fff5f3;
        border-radius: 8px;
        padding: 8px 12px;

        .info-col {
          display: flex;
          flex-direction: column;

          .info-label {
            font-size: 11px;
            color: #6b5c5a;
          }

          .info-val {
            font-size: 13px;
            font-weight: 700;
            color: #1f1a1a;
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
  max-width: 260px;
  margin: 0 auto;

  .modal-text {
    font-size: 13px;
    color: #1f1a1a;
    line-height: 1.4;
    margin-bottom: 16px;
    font-weight: 500;
  }

  .confirm-red-btn {
    width: 100%;
    background: #ff3b30;
    color: #ffffff;
    border: none;
    border-radius: 20px;
    height: 38px;
    line-height: 38px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(255, 59, 48, 0.3);

    &:active {
      background: #d63027;
    }
  }
}
</style>
