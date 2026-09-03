<!-- Mine  -->
<template>
  <div class="Mine-view">
    <!-- Profile Header -->
    <div class="profile-header">
      <div class="header-left">
        <span class="welcome-tag">Welcome</span>
        <h2 class="user-greeting">Hi, {{ data.username || data.tel || 'User' }}</h2>
      </div>
      <img alt="" class="avatar-img" src="../../assets/img/mine/photo.png">
    </div>

    <!-- Red Gradient Balance Card -->
    <div class="gold-balance-card">
      <div class="balance-cell">
        <span class="lbl">Total balance (USDT)</span>
        <span class="val">$ {{ data.balance != null ? Number(data.balance).toFixed(2) : '0.00' }}</span>
      </div>
      <div class="balance-cell">
        <span class="lbl">Recharge amount (USDT)</span>
        <span class="val">$ {{ data.recharge_amount != null ? Number(data.recharge_amount).toFixed(2) : '0.00' }}</span>
      </div>
    </div>

    <!-- Menu Links List -->
    <div class="menu-links-list">
      <div v-for="item in navList" :key="item.path" class="menu-link-row" @click="toViews(item.path)">
        <div class="menu-link-left">
          <div class="icon-circle-wrapper" :class="item.bgClass">
            <van-icon :name="item.icon" />
          </div>
          <span class="link-title">{{ item.title }}</span>
        </div>
        <van-icon name="arrow" class="arrow-right-icon" />
      </div>
      
      <!-- Sign out -->
      <div class="menu-link-row" @click="goBack">
        <div class="menu-link-left">
          <div class="icon-circle-wrapper bg-red-icon">
            <van-icon name="close" />
          </div>
          <span class="link-title">Sign out</span>
        </div>
        <van-icon name="arrow" class="arrow-right-icon" />
      </div>
    </div>

    <!-- Foot copy info -->
    <div class="foot">
      <span>Copyright ©2011-2026</span>
      <span>Global Business • Global Success All Rights Reserved</span>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import Request from '@/services/index.js'
import { ref } from 'vue'
import { useMitt } from '@/utils/mitt.js'

const navList = [
  { path: '/recharge', icon: 'gold-coin', title: 'Recharge / Deposit', bgClass: 'bg-orange' },
  { path: '/withdraw', icon: 'balance-pay', title: 'Withdrawal', bgClass: 'bg-crimson' },
  { path: '/order', icon: 'orders-o', title: 'Task & Order History', bgClass: 'bg-orange' },
  { path: '/vip', icon: 'gem-o', title: 'VIP Levels & Benefits', bgClass: 'bg-crimson' },
  { path: '/team', icon: 'friends-o', title: 'Team & Agency Data', bgClass: 'bg-orange' },
  { path: '/poster/detail/13', icon: 'share-o', title: 'Invite Friends / Referral Link', bgClass: 'bg-crimson' },
  { path: '/billList', icon: 'description-o', title: 'Financial Records / Balance Log', bgClass: 'bg-orange' },
  { path: '/rechargeRecord', icon: 'records', title: 'Recharge History', bgClass: 'bg-crimson' },
  { path: '/withdrawRecord', icon: 'bill-o', title: 'Withdrawal History', bgClass: 'bg-orange' },
  { path: '/password', icon: 'setting', title: 'Security & Password', bgClass: 'bg-crimson' }
]

const router = useRouter()
const token = localStorage.getItem('token') || sessionStorage.getItem('token')

if (!token) {
  router.replace('/login')
}

const toViews = (path) => {
  const currentToken = localStorage.getItem('token') || sessionStorage.getItem('token')
  if (!currentToken) {
    router.replace('/login')
    return
  }
  router.push(path)
}

const data = ref({})
if (token) {
  Request.get({ url: 'index/user/info' }).then(res => {
    data.value = res.info || {}
  }).catch(() => {
    router.replace('/login')
  })
}

const mitt = useMitt()
const goBack = () => {
  sessionStorage.clear()
  localStorage.clear()
  data.value = {}
  Request.get({ url: 'index/user/logout' }).then(() => {
    router.replace('/login')
    mitt.emit('goBack')
  })
}
</script>

<style lang="less" scoped>
.Mine-view {
  background: #fff9f8;
  min-height: 100vh;
  padding: 16px 0 90px 0;
  box-sizing: border-box;

  .profile-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;

    .header-left {
      display: flex;
      flex-direction: column;

      .welcome-tag {
        font-size: 11px;
        color: #86909c;
      }

      .user-greeting {
        font-size: 20px;
        font-weight: 800;
        color: #1f1a1a;
        margin: 2px 0 0;
      }
    }

    .avatar-img {
      width: 52px;
      height: 52px;
      border-radius: 50%;
      border: 2px solid #E86C3F;
      box-shadow: 0 2px 8px rgba(184, 58, 46, 0.15);
    }
  }

  .gold-balance-card {
    width: 92%;
    margin: 0 auto 20px;
    background: linear-gradient(135deg, #B83A2E, #E86C3F);
    border-radius: 16px;
    padding: 22px 18px;
    display: flex;
    justify-content: space-between;
    box-sizing: border-box;
    box-shadow: 0 4px 14px rgba(184, 58, 46, 0.25);
    color: #ffffff;

    .balance-cell {
      display: flex;
      flex-direction: column;
      gap: 6px;
      width: 50%;

      &:first-child {
        border-right: 1px solid rgba(255,255,255,0.25);
        padding-right: 16px;
      }

      &:last-child {
        padding-left: 16px;
      }

      .lbl {
        font-size: 11px;
        opacity: 0.9;
        font-weight: 500;
      }

      .val {
        font-size: 22px;
        font-weight: 800;
        color: #ffffff;
      }
    }
  }

  .menu-links-list {
    background-color: #ffffff;
    border: 1.5px solid #E86C3F;
    border-radius: 14px;
    width: 92%;
    margin: 20px auto;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(184, 58, 46, 0.08);

    .menu-link-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 16px;
      border-bottom: 1px dashed #fdece8;
      cursor: pointer;
      transition: background 0.15s;

      &:hover, &:active {
        background-color: #fdf5f3;
      }

      &:last-child {
        border-bottom: none;
      }

      .menu-link-left {
        display: flex;
        align-items: center;
        gap: 14px;

        .icon-circle-wrapper {
          width: 34px;
          height: 34px;
          border-radius: 8px;
          display: flex;
          align-items: center;
          justify-content: center;
          color: #ffffff;
          font-size: 18px;

          &.bg-crimson { background-color: #B83A2E; }
          &.bg-orange { background-color: #E86C3F; }
          &.bg-red-icon { background-color: #d9363e; }
        }

        .link-title {
          font-size: 14.5px;
          color: #1f1a1a;
          font-weight: 700;
        }
      }

      .arrow-right-icon {
        color: #86909c;
        font-size: 14px;
      }
    }
  }

  .foot {
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
    padding: 30px 0;
    color: #86909c;
    font-size: 11px;
    gap: 4px;
  }
}
</style>
