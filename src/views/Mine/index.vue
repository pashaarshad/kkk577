<!-- Mine  -->
<template>
  <div class="Mine-view">
    <!-- Profile Header -->
    <div class="profile-header">
      <div class="header-left">
        <span class="user-greeting">Hi, {{ data.tel || 'User' }}</span>
      </div>
      <img alt="" class="avatar-img" src="../../assets/img/mine/photo.png">
    </div>

    <!-- Gold Balance Card -->
    <div class="gold-balance-card">
      <div class="balance-cell">
        <span class="lbl">Total balance (USDT)</span>
        <span class="val">{{ data.balance || '0' }}</span>
      </div>
      <div class="balance-cell">
        <span class="lbl">Recharge amount (USDT)</span>
        <span class="val">{{ data.recharge_amount || '0' }}</span>
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
      <span>Copyright ©2011-2024</span>
      <span>marketing de mercado Pictures All Rights Reserved</span>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import Request from '@/services/index.js'
import { ref } from 'vue'
import { useMitt } from '@/utils/mitt.js'

const navList = [
  { path: '/bankCard', icon: 'card', title: 'Account', bgClass: 'bg-blue' },
  { path: '/recharge', icon: 'gold-coin', title: 'Recharge', bgClass: 'bg-teal' },
  { path: '/withdraw', icon: 'balance-pay', title: 'Withdraw', bgClass: 'bg-indigo' },
  { path: '/billList', icon: 'description-o', title: 'Financial records', bgClass: 'bg-green' },
  { path: '/password', icon: 'setting', title: 'Change Password', bgClass: 'bg-orange' }
]

const router = useRouter()
const toViews = (path) => {
  router.push(path)
}

const data = ref({})
Request.get({ url: 'index/user/info' }).then(res => {
  data.value = res.info || {}
})

const mitt = useMitt()
const goBack = () => {
  sessionStorage.clear()
  Request.get({ url: 'index/user/logout' }).then(() => {
    router.replace('/home')
    mitt.emit('goBack')
  })
}
</script>

<style lang="less" scoped>
.Mine-view {
  background: var(--bg-second-color);
  min-height: 100vh;
  padding: 16px 0 90px 0;
  box-sizing: border-box;

  .profile-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 16px;

    .user-greeting {
      font-size: 20px;
      font-weight: 750;
      color: var(--default-color);
    }

    .avatar-img {
      width: 54px;
      height: 54px;
      border-radius: 50%;
      border: 2px solid var(--second-color);
    }
  }

  .gold-balance-card {
    width: 92%;
    margin: 0 auto 20px;
    background: linear-gradient(135deg, #fce0ad, #dfb479);
    border-radius: 12px;
    padding: 20px 16px;
    display: flex;
    justify-content: space-between;
    box-sizing: border-box;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);

    .balance-cell {
      display: flex;
      flex-direction: column;
      gap: 6px;
      width: 50%;

      &:first-child {
        border-right: 1px solid rgba(0,0,0,0.1);
        padding-right: 16px;
      }

      &:last-child {
        padding-left: 16px;
      }

      .lbl {
        font-size: 11px;
        color: #1e293b;
        font-weight: 600;
      }

      .val {
        font-size: 22px;
        font-weight: 800;
        color: #000000;
      }
    }
  }

  .menu-links-list {
    background-color: var(--bg-color);
    border: 1px solid var(--second-color);
    border-radius: 12px;
    width: 92%;
    margin: 20px auto;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);

    .menu-link-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 16px;
      border-bottom: 1px solid var(--second-color);
      cursor: pointer;

      &:last-child {
        border-bottom: none;
      }

      .menu-link-left {
        display: flex;
        align-items: center;
        gap: 12px;

        .icon-circle-wrapper {
          width: 32px;
          height: 32px;
          border-radius: 6px;
          display: flex;
          align-items: center;
          justify-content: center;
          color: #ffffff;
          font-size: 18px;

          &.bg-blue { background-color: #2563eb; }
          &.bg-teal { background-color: #0d9488; }
          &.bg-indigo { background-color: #4f46e5; }
          &.bg-green { background-color: #16a34a; }
          &.bg-orange { background-color: #ea580c; }
          &.bg-red-icon { background-color: #b91c1c; }
        }

        .link-title {
          font-size: 14px;
          color: var(--default-color);
          font-weight: 600;
        }
      }

      .arrow-right-icon {
        color: var(--text-second);
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
    color: var(--text-second);
    font-size: 11px;
    gap: 4px;
  }
}
</style>
